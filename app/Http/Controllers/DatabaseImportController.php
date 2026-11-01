<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class DatabaseImportController extends Controller
{
    public function import(Request $request)
    {
        $validated = $request->validate([
            'diak' => ['required', 'file', 'max:2048'],
            'targy' => ['required', 'file', 'max:2048'],
            'jegy' => ['required', 'file', 'max:2048'],
        ]);

        // Ne írjuk felül a már meglévő adatokat.
        foreach (['diak', 'targy', 'jegy'] as $table) {
            if (DB::table($table)->exists()) {
                throw ValidationException::withMessages([
                    'import' => "A(z) {$table} tábla már tartalmaz adatokat. Az import megszakadt.",
                ]);
            }
        }

        try {
            $counts = DB::transaction(function () use ($validated) {
                $diakCount = $this->importTsv(
                    $validated['diak'],
                    'diak',
                    ['id', 'nev', 'osztaly', 'fiu'],
                    fn (array $row) => [
                        'id' => $this->integer($row[0]),
                        'nev' => $row[1],
                        'osztaly' => $row[2],
                        'fiu' => $this->integer($row[3]),
                    ]
                );

                $targyCount = $this->importTsv(
                    $validated['targy'],
                    'targy',
                    ['id', 'nev', 'kategoria'],
                    fn (array $row) => [
                        'id' => $this->integer($row[0]),
                        'nev' => $row[1],
                        'kategoria' => $row[2],
                    ]
                );

                $jegyCount = $this->importTsv(
                    $validated['jegy'],
                    'jegy',
                    ['diakid', 'datum', 'ertek', 'tipus', 'targyid'],
                    fn (array $row) => [
                        'diakid' => $this->integer($row[0]),
                        'datum' => $row[1],
                        'ertek' => $this->integer($row[2]),
                        'tipus' => $row[3],
                        'targyid' => $this->integer($row[4]),
                    ]
                );

                return [
                    'diak' => $diakCount,
                    'targy' => $targyCount,
                    'jegy' => $jegyCount,
                ];
            });

            return redirect()
                ->back()
                ->with('import_success', $counts);

        } catch (Throwable $e) {
            report($e);

            throw ValidationException::withMessages([
                'import' => 'Az importálás nem sikerült. Az adatbázis-tranzakció visszaállt. Ellenőrizd a fájlokat és a szerver naplóját.',
            ]);
        }
    }

    private function importTsv(
        UploadedFile $file,
        string $table,
        array $expectedHeaders,
        callable $transform
    ): int {
        $handle = fopen($file->getRealPath(), 'r');

        if ($handle === false) {
            throw new \RuntimeException("Nem sikerült megnyitni: {$table}");
        }

        try {
            $headers = fgetcsv($handle, 0, "\t", '"', '\\');

            if ($headers === false) {
                throw new \RuntimeException("Hiányzó fejléc: {$table}");
            }

            // UTF-8 BOM eltávolítása az első oszlop elejéről.
            $headers[0] = preg_replace('/^\xEF\xBB\xBF/', '', $headers[0]);

            if ($headers !== $expectedHeaders) {
                throw new \RuntimeException("Hibás fejléc: {$table}");
            }

            $batch = [];
            $count = 0;
            $line = 1;

            while (($row = fgetcsv($handle, 0, "\t", '"', '\\')) !== false) {
                $line++;

                // Üres sor kihagyása.
                if ($row === [null] || $row === []) {
                    continue;
                }

                if (count($row) !== count($expectedHeaders)) {
                    throw new \RuntimeException(
                        "Hibás oszlopszám a(z) {$table} fájl {$line}. sorában."
                    );
                }

                $row = array_map(
                    fn ($value) => $value === null ? null : trim($value),
                    $row
                );
                foreach ($row as $value) {
                    if ($value !== null && !mb_check_encoding($value, 'UTF-8')) {
                        throw new \RuntimeException(
                            "Érvénytelen UTF-8 karakter a(z) {$table} fájl {$line}. sorában."
                        );
                    }
                }

                $batch[] = $transform($row);
                $count++;

                if (count($batch) >= 500) {
                    DB::table($table)->insert($batch);
                    $batch = [];
                }
            }

            if ($batch !== []) {
                DB::table($table)->insert($batch);
            }

            return $count;

        } finally {
            fclose($handle);
        }
    }

    private function integer(?string $value): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (!preg_match('/^-?\d+$/', $value)) {
            throw new \RuntimeException('Érvénytelen egész szám az importfájlban.');
        }

        return (int) $value;
    }
}

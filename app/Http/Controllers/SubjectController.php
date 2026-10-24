<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = DB::table('targy')
            ->orderBy('nev')
            ->get();

        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('subjects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nev' => ['required', 'string', 'max:255'],
            'kategoria' => ['required', 'string', 'max:255'],
        ]);

        DB::table('targy')->insert([
            'nev' => $validated['nev'],
            'kategoria' => $validated['kategoria'],
        ]);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'A tantárgy sikeresen létrejött.');
    }

    public function edit(string $id)
    {
        $subject = DB::table('targy')
            ->where('id', $id)
            ->first();

        abort_if(!$subject, 404);

        return view('subjects.edit', compact('subject'));
    }

    public function update(Request $request, string $id)
    {
        $subject = DB::table('targy')
            ->where('id', $id)
            ->first();

        abort_if(!$subject, 404);

        $validated = $request->validate([
            'nev' => ['required', 'string', 'max:255'],
            'kategoria' => ['required', 'string', 'max:255'],
        ]);

        DB::table('targy')
            ->where('id', $id)
            ->update([
                'nev' => $validated['nev'],
                'kategoria' => $validated['kategoria'],
            ]);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'A tantárgy adatai frissültek.');
    }

    public function destroy(string $id)
    {
        $subject = DB::table('targy')
            ->where('id', $id)
            ->first();

        abort_if(!$subject, 404);

        // Olyan tantárgyat nem törlünk, amelyhez jegyek tartoznak.
        $hasGrades = DB::table('jegy')
            ->where('targyid', $id)
            ->exists();

        if ($hasGrades) {
            return redirect()
                ->route('subjects.index')
                ->with(
                    'error',
                    'A tantárgyhoz már tartoznak jegyek, ezért nem törölhető.'
                );
        }

        DB::table('targy')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('subjects.index')
            ->with('success', 'A tantárgy sikeresen törölve.');
    }
}

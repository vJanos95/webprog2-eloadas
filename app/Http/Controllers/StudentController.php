<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = DB::table('diak')
            ->orderBy('nev')
            ->get();

        return view('students.index', compact('students'));
    }

    public function create()
    {
        return view('students.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nev' => ['required', 'string', 'max:255'],
            'osztaly' => ['required', 'string', 'max:50'],
            'fiu' => ['required', 'in:0,1'],
        ]);

        DB::table('diak')->insert([
            'nev' => $validated['nev'],
            'osztaly' => $validated['osztaly'],
            'fiu' => (int) $validated['fiu'],
        ]);

        return redirect()
            ->route('students.index')
            ->with('success', 'A diák sikeresen létrejött.');
    }

    public function edit(string $id)
    {
        $student = DB::table('diak')->where('id', $id)->first();

        abort_if(!$student, 404);

        return view('students.edit', compact('student'));
    }

    public function update(Request $request, string $id)
    {
        $student = DB::table('diak')->where('id', $id)->first();

        abort_if(!$student, 404);

        $validated = $request->validate([
            'nev' => ['required', 'string', 'max:255'],
            'osztaly' => ['required', 'string', 'max:50'],
            'fiu' => ['required', 'in:0,1'],
        ]);

        DB::table('diak')
            ->where('id', $id)
            ->update([
                'nev' => $validated['nev'],
                'osztaly' => $validated['osztaly'],
                'fiu' => (int) $validated['fiu'],
            ]);

        return redirect()
            ->route('students.index')
            ->with('success', 'A diák adatai frissültek.');
    }

    public function destroy(string $id)
    {
        $student = DB::table('diak')->where('id', $id)->first();

        abort_if(!$student, 404);

        // Ha vannak a diákhoz tartozó jegyek, ne töröljük
        // a diákot, mert ezzel sérülhet a napló adatintegritása.
        $hasGrades = DB::table('jegy')
            ->where('diakid', $id)
            ->exists();

        if ($hasGrades) {
            return redirect()
                ->route('students.index')
                ->with('error', 'A diáknak már vannak jegyei, ezért nem törölhető.');
        }

        DB::table('diak')->where('id', $id)->delete();

        return redirect()
            ->route('students.index')
            ->with('success', 'A diák sikeresen törölve.');
    }
}

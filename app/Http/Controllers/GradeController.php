<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GradeController extends Controller
{
    private function gradeTypes(): array
    {
        return [
            'szóbeli felelet',
            'órai munka',
            'röpdolgozat',
            'házi dolgozat',
            'témazáró dolgozat',
        ];
    }

    private function validateGrade(Request $request): array
    {
        return $request->validate([
            'diakid' => ['required', 'integer', 'exists:diak,id'],
            'targyid' => ['required', 'integer', 'exists:targy,id'],
            'datum' => ['required', 'date_format:Y-m-d'],
            'ertek' => ['required', 'integer', 'between:1,5'],
            'tipus' => ['required', Rule::in($this->gradeTypes())],
        ]);
    }

    public function index()
    {
        $grades = DB::table('jegy')
            ->leftJoin('diak', 'jegy.diakid', '=', 'diak.id')
            ->leftJoin('targy', 'jegy.targyid', '=', 'targy.id')
            ->select(
                'jegy.id',
                'jegy.diakid',
                'jegy.targyid',
                'jegy.datum',
                'jegy.ertek',
                'jegy.tipus',
                'diak.nev as diak_nev',
                'diak.osztaly as diak_osztaly',
                'targy.nev as targy_nev'
            )
            ->orderByDesc('jegy.datum')
            ->orderByDesc('jegy.id')
            ->get();

        return view('grades.index', compact('grades'));
    }

    public function create()
    {
        $students = DB::table('diak')->orderBy('nev')->get();
        $subjects = DB::table('targy')->orderBy('nev')->get();
        $types = $this->gradeTypes();

        return view('grades.create', compact('students', 'subjects', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateGrade($request);

        DB::table('jegy')->insert($validated);

        return redirect()
            ->route('grades.index')
            ->with('success', 'A jegy sikeresen hozzáadva.');
    }

    public function edit(string $id)
    {
        $grade = DB::table('jegy')->where('id', $id)->first();
        abort_if(!$grade, 404);

        $students = DB::table('diak')->orderBy('nev')->get();
        $subjects = DB::table('targy')->orderBy('nev')->get();
        $types = $this->gradeTypes();

        return view('grades.edit', compact('grade', 'students', 'subjects', 'types'));
    }

    public function update(Request $request, string $id)
    {
        $grade = DB::table('jegy')->where('id', $id)->first();
        abort_if(!$grade, 404);

        $validated = $this->validateGrade($request);

        DB::table('jegy')->where('id', $id)->update($validated);

        return redirect()
            ->route('grades.index')
            ->with('success', 'A jegy sikeresen módosítva.');
    }

    public function destroy(string $id)
    {
        $grade = DB::table('jegy')->where('id', $id)->first();
        abort_if(!$grade, 404);

        DB::table('jegy')->where('id', $id)->delete();

        return redirect()
            ->route('grades.index')
            ->with('success', 'A jegy sikeresen törölve.');
    }
}
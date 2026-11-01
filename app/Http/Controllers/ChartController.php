<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index()
    {
        $subjects = DB::table('jegy')
            ->join('targy', 'jegy.targyid', '=', 'targy.id')
            ->select(
                'targy.nev as subject_name',
                DB::raw('ROUND(AVG(jegy.ertek), 2) as average_grade')
            )
            ->groupBy('targy.id', 'targy.nev')
            ->orderBy('targy.nev')
            ->get();

        $labels = $subjects->pluck('subject_name');
        $averages = $subjects->pluck('average_grade');

        return view('charts.index', compact('labels', 'averages'));
    }
}
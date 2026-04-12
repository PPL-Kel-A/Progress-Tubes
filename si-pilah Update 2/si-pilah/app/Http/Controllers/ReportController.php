<?php

namespace App\Http\Controllers;

use App\Models\Report;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', auth()->id())
                        ->latest()
                        ->get();

        return view('reports.index', compact('reports'));
    }
}
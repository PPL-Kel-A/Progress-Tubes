<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::where('user_id', auth()->id())
                        ->latest()
                        ->get();

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'     => 'required|string|max:255',
            'deskripsi' => 'required|string',
        ]);

        Report::create([
            'user_id'   => auth()->id(),
            'judul'     => $request->judul,
            'deskripsi' => $request->deskripsi,
            'status'    => 'Menunggu',
        ]);

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dikirim! Tim kami akan segera memprosesnya.');
    }
}
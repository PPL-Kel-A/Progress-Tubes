<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Waste;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WasteController extends Controller
{
    // =========================
    // FORM PAGE
    // =========================
    public function create(Request $request)
    {
        return view('waste.form', [
            'type' => $request->type
        ]);
    }

    // =========================
    // PREVIEW PAGE
    // =========================
    public function preview(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', // 🔥 ganti user_id jadi name
            'type' => 'required|in:organic,inorganic',
            'category' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0.1',
            'tps' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'image' => 'required|image|max:2048'
        ]);

        // =========================
        // HITUNG RESULT
        // =========================
        $result = $validated['type'] === 'organic'
            ? $validated['weight'] * 0.5
            : $validated['weight'] * 0.8;

        // =========================
        // SIMPAN IMAGE SEMENTARA
        // =========================
        $path = $request->file('image')->store('tmp', 'public');

        return view('waste.preview', [
            'data' => $validated,
            'result' => $result,
            'image' => $path
        ]);
    }

    // =========================
    // STORE FINAL (SUBMIT)
    // =========================
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255', // 🔥 tambahin name
            'type' => 'required|in:organic,inorganic',
            'category' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0.1',
            'tps' => 'required|string|max:255',
            'desa' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'image' => 'required|string',
        ]);

        // =========================
        // HITUNG ULANG RESULT
        // =========================
        $result = $validated['type'] === 'organic'
            ? $validated['weight'] * 0.5
            : $validated['weight'] * 0.8;

        // =========================
        // PINDAH IMAGE TMP → FINAL
        // =========================
        $tmpPath = $validated['image'];
        $newPath = str_replace('tmp/', 'wastes/', $tmpPath);

        if (Storage::disk('public')->exists($tmpPath)) {
            Storage::disk('public')->move($tmpPath, $newPath);
        } else {
            return back()->withErrors('Image tidak ditemukan, silakan upload ulang.');
        }

        // =========================
        // GENERATE ID
        // =========================
        $submissionId = 'SUB-' . strtoupper(Str::random(10));

        // =========================
        // FORMAT LOKASI
        // =========================
        $fullLocation = $validated['tps'] . ' | ' .
                        $validated['desa'] . ', ' .
                        $validated['kecamatan'] . ', ' .
                        $validated['kota'];

        // =========================
        // SIMPAN DATABASE
        // =========================
        Waste::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'type' => $validated['type'],
            'category' => $validated['category'],
            'weight' => $validated['weight'],
            'tps' => $fullLocation,
            'image' => $newPath,
            'result' => $result,
        ]);

        // =========================
        // REDIRECT SUCCESS
        // =========================
        return redirect('/waste/success')->with([
        'name' => $validated['name'],
        'type' => $validated['type'],
        'category' => $validated['category'],
        'weight' => $validated['weight'],
        'tps' => $validated['tps'],
        'desa' => $validated['desa'],
        'kecamatan' => $validated['kecamatan'],
        'kota' => $validated['kota'],
        'image' => $newPath,
        'result' => $result,
        'submission_id' => $submissionId
        ]);
    }

    // =========================
    // SUCCESS PAGE
    // =========================
    public function success()
    {
        return view('waste.success');
    }
}
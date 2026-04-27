<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index(Request $request)
    {
        $query = Education::latest();

        // 🔍 SEARCH (opsional tapi berguna banget)
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $educations = $query->paginate(9)->withQueryString();

        return view('education.index', compact('educations'));
    }
}
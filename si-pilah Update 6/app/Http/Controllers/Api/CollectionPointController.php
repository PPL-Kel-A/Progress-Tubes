<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CollectionPoint;
use Illuminate\Http\Request;

class CollectionPointController extends Controller
{
    /**
     * Get all collection points.
     * Optional filters: kota, kecamatan
     */
    public function index(Request $request)
    {
        $query = CollectionPoint::query();

        // Filter by city if provided
        if ($request->has('kota')) {
            $query->where('kota', $request->kota);
        }

        // Filter by district if provided
        if ($request->has('kecamatan')) {
            $query->where('kecamatan', $request->kecamatan);
        }

        $collectionPoints = $query->select([
            'id',
            'name',
            'address',
            'latitude',
            'longitude',
            'desa',
            'kecamatan',
            'kota',
        ])->get();

        return response()->json([
            'success' => true,
            'data' => $collectionPoints,
            'count' => $collectionPoints->count(),
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionPoint extends Model
{
    protected $table = 'collection_points';

    protected $fillable = [
        'name',
        'address',
        'latitude',
        'longitude',
        'desa',
        'kecamatan',
        'kota',
    ];

    protected $casts = [
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    /**
     * Get all waste submissions for this collection point.
     */
    public function wastes()
    {
        return $this->hasMany(Waste::class, 'tps_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    // nama tabel
    protected $table = 'wastes';

    // field yang boleh diisi
    protected $fillable = [
        'name',       // ✅ ganti dari user_id ke name
        'type',
        'category',
        'weight',
        'tps',
        'image',
        'result',
    ];

    // casting tipe data
    protected $casts = [
        'weight' => 'float',
        'result' => 'float',
    ];
}
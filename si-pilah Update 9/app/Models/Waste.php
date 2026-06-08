<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waste extends Model
{
    // nama tabel
    protected $table = 'wastes';

    // field yang boleh diisi
    protected $fillable = [
        'user_id',
        'name',
        'type',
        'category',
        'weight',
        'tps',
        'image',
        'result',
        'status',
        'is_rewarded',
    ];

    // casting tipe data
    protected $casts = [
        'weight' => 'float',
        'result' => 'float',
    ];

    /**
     * Get the user that owns the waste submission.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if the points for this waste have been claimed.
     */
    public function getIsClaimedAttribute()
    {
        return $this->is_rewarded || Reward::where('user_id', $this->user_id)
            ->where('description', 'like', '%[ID: ' . $this->id . ']%')
            ->exists();
    }

    /**
     * Get the points earned for this waste claim.
     */
    public function getPointsEarnedAttribute()
    {
        $reward = Reward::where('user_id', $this->user_id)
            ->where('description', 'like', '%[ID: ' . $this->id . ']%')
            ->first();
        return $reward ? $reward->points : ($this->result * 10);
    }
}
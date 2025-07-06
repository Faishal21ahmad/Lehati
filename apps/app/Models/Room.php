<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_code',
        'user_id',
        'product_id',
        'room_notes',
        'status',
        'starting_price',
        'min_bid_step',
        'start_time',
        'end_time'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function participants()
    {
        return $this->hasMany(Participant::class, 'room_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}

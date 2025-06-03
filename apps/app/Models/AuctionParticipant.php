<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuctionParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'auction_room_id',
        'status'
    ];

    protected $casts = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function auctionRoom()
    {
        return $this->belongsTo(AuctionRoom::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'participan_id');
    }
}

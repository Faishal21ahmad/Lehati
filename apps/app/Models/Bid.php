<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = [
        'participan_id',
        'auction_room_id',
        'amount',
        'is_winner'
    ];

    protected $casts = [
        'is_winner' => 'boolean',
    ];

    public function participant()
    {
        return $this->belongsTo(AuctionParticipant::class, 'participan_id');
    }

    public function auctionRoom()
    {
        return $this->belongsTo(AuctionRoom::class);
    }

    public function transaction()
    {
        return $this->hasOne(AuctionTransaction::class, 'bid_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuctionRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_code',
        'title_room',
        'auctioneer_id',
        'product_id',
        'description',
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

    public function auctioneer()
    {
        return $this->belongsTo(AuctioneerData::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function participants()
    {
        return $this->hasMany(AuctionParticipant::class, 'auction_room_id');
    }

    public function bids()
    {
        return $this->hasMany(Bid::class);
    }
}

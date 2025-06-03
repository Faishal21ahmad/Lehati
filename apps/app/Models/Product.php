<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'auctioneer_id',
        'product_name',
        'description',
        'quantity',
        'unit',
        'status'
    ];

    public function auctioneer()
    {
        return $this->belongsTo(AuctioneerData::class);
    }

    public function images()
    {
        return $this->hasMany(ImageProduct::class);
    }

    public function auctionRooms()
    {
        return $this->hasMany(AuctionRoom::class);
    }
}

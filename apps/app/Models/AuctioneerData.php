<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuctioneerData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'business_name',
        'business_address',
        'NPWP',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function logs()
    {
        return $this->hasMany(AuctioneerLog::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function auctionRooms()
    {
        return $this->hasMany(AuctionRoom::class);
    }
}

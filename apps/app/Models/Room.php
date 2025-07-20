<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    use SoftDeletes;

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
    protected $dates = ['deleted_at'];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'starting_price' => 'decimal:2',
        'min_bid_step' => 'decimal:2',
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
    // Pengecekan data relasi room -> participants || room -> bids
    protected static function booted()
    {
        static::deleting(function ($product) {
            if ($product->participants()->exists()) {
                throw new \Exception("Produk tidak dapat dihapus karena sedang digunakan di Room.");
            }
            if ($product->bids()->exists()) {
                throw new \Exception("Produk tidak dapat dihapus karena sedang digunakan di Room.");
            }
        });
    }
}

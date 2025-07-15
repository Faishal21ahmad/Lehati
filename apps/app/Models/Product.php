<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'product_name',
        'description',
        'quantity',
        'units',
        'status'
    ];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ImageProduct::class);
    }

    public function Rooms()
    {
        return $this->hasMany(Room::class);
    }

    // Pengecekan data relasi product -> room
    protected static function booted()
    {
        static::deleting(function ($product) {
            if ($product->rooms()->exists()) {
                throw new \Exception("Produk tidak bisa dihapus karena masih digunakan di Room.");
            }

            $product->images()->delete(); // tetap hapus image
        });
    }
}

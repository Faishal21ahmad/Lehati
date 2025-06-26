<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_name',
        'description',
        'quantity',
        'units',
        'status'
    ];

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
}

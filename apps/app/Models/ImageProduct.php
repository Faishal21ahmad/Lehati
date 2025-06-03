<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ImageProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

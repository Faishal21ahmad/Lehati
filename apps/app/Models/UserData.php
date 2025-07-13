<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone',
        'address',
        'nik',
        'gender',
        'bank',
        'bank_name',
        'bank_number',

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

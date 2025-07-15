<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Participant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'room_id',
        'status'
    ];
    protected $dates = ['deleted_at'];

    protected $casts = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function Room()
    {
        return $this->belongsTo(Room::class);
    }

    public function bids()
    {
        return $this->hasMany(Bid::class, 'participan_id');
    }
}

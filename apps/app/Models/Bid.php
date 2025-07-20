<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bid extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'participan_id',
        'room_id',
        'amount',
        'is_winner'
    ];

    protected $dates = ['deleted_at'];

    protected $casts = [
        'is_winner' => 'boolean',
        'amount' => 'decimal:2',
    ];

    public function participant()
    {
        return $this->belongsTo(Participant::class, 'participan_id');
    }

    public function Room()
    {
        return $this->belongsTo(Room::class);
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'bid_id');
    }
}

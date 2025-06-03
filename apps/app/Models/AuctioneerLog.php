<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AuctioneerLog extends Model
{
     use HasFactory;

    protected $fillable = [
        'auctioneer_id',
        'action_by',
        'status',
        'notes',
        'reviewed_at'
    ];

    public function auctioneer()
    {
        return $this->belongsTo(AuctioneerData::class, 'auctioneer_id');
    }

    public function actionBy()
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}

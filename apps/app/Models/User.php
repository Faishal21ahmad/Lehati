<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\Role;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'code_user',
        'name',
        'email',
        'password',
        'role',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'role' => Role::class,
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn(string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }


    public function userData()
    {
        return $this->hasOne(UserData::class);
    }

    public function auctioneerData()
    {
        return $this->hasOne(AuctioneerData::class);
    }

    public function auctioneerLogs()
    {
        return $this->hasMany(AuctioneerLog::class, 'action_by');
    }

    public function products()
    {
        return $this->hasManyThrough(Product::class, AuctioneerData::class);
    }

    public function auctionRooms()
    {
        return $this->hasManyThrough(AuctionRoom::class, AuctioneerData::class);
    }

    public function auctionParticipants()
    {
        return $this->hasMany(AuctionParticipant::class);
    }

    public function bids()
    {
        return $this->hasManyThrough(Bid::class, AuctionParticipant::class, 'user_id', 'participan_id');
    }

    public function transactions()
    {
        return $this->hasMany(AuctionTransaction::class);
    }
}

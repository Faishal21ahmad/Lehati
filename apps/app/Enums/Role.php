<?php

namespace App\Enums;

enum Role: string
{
    case administrator = 'administrator';
    case admin = 'admin';
    case auctioneer = 'auctioneer';
    case bidder = 'bidder';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public function permissions(): array
    {
        return match ($this) {
            self::administrator => [
                'administrator',
                'manage_account',
                'create_admin',
                'create_',
                'manage_lelang',
                'manage_room',
                'manage_transaction',
                'manage_category',
                'manage_auctioneer',
                'manage_bidder',
                'room_participant',
                'room'
            ],
            self::admin => [
                'admin',
                'manage_lelang',
                'approve_lelang',
            ],
            self::auctioneer => [
                'auctioneer',
                'create_lelang',
                'edit_lelang',
            ],
            self::bidder => [
                'bidder',
                'ikut_lelang',
            ],
        };
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions());
    }
}

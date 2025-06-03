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
                'manage_users',
                'manage_lelang',
                'approve_lelang',
                'full_access',
            ],
            self::admin => [
                'manage_lelang',
                'approve_lelang',
            ],
            self::auctioneer => [
                'create_lelang',
                'edit_lelang',
            ],
            self::bidder => [
                'ikut_lelang',
            ],
        };
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions());
    }
}
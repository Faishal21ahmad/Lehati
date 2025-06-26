<?php

namespace App\Enums;

enum Role: string
{
    case admin = 'admin';
    case bidder = 'bidder';

    public function label(): string
    {
        return ucfirst($this->value);
    }

    public function permissions(): array
    {
        return match ($this) {
            self::admin => [
                'admin',
                'manage_lelang',
                'approve_lelang',
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

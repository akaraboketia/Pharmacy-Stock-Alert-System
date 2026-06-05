<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';

    protected $fillable = ['username', 'password', 'role'];

    protected $hidden = ['password'];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'preferences' => 'array',
        ];
    }

    public function username(): string
    {
        return 'username';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPharmacist(): bool
    {
        return $this->role === 'pharmacist';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function roleLabel(): string
    {
        return match ($this->role) {
            'admin' => 'Administrator',
            'pharmacist' => 'Pharmacist',
            'staff' => 'Staff',
            default => ucfirst($this->role),
        };
    }

    public function roleIcon(): string
    {
        return match ($this->role) {
            'admin' => 'bi-shield-lock',
            'pharmacist' => 'bi-capsule',
            'staff' => 'bi-person-badge',
            default => 'bi-person',
        };
    }
}

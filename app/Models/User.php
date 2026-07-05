<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Helper methods untuk role
    public function isCustomer(): bool
    {
        return $this->role === 'customer';
    }

    public function isHoreka(): bool
    {
        return $this->role === 'horeka';
    }

    public function isDriver(): bool
    {
        return $this->role === 'driver';
    }

    // Scope untuk filter role
    public function scopeCustomer($query)
    {
        return $query->where('role', 'customer');
    }

    public function scopeHoreka($query)
    {
        return $query->where('role', 'horeka');
    }

    public function scopeDriver($query)
    {
        return $query->where('role', 'driver');
    }
}
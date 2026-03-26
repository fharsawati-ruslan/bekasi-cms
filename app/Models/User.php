<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id', // 🔥 tambahan
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

    // 🔗 RELASI KE ROLE
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // 🔐 CHECK PERMISSION
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->role?->permissions ?? []);
    }

    // 🔥 BATASI LOGIN HANYA @internal
    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@internal');
    }
}

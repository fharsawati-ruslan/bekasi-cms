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
        'role_id',
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

    // 🔥 CHECK PERMISSION (FIX TOTAL)
    public function hasPermission(string $menu, string $action): bool
    {
        $permissions = $this->role?->permissions ?? [];

        foreach ($permissions as $perm) {
            if (
                strtolower($perm['menu'] ?? '') === strtolower($menu) &&
                ($perm[$action] ?? false) === true
            ) {
                return true;
            }
        }

        return false;
    }

    // 🔥 HELPER BIAR ENAK DIPAKAI
    public function canView(string $menu): bool
    {
        return $this->hasPermission($menu, 'view');
    }

    public function canCreate(string $menu): bool
    {
        return $this->hasPermission($menu, 'create');
    }

    public function canUpdate(string $menu): bool
    {
        return $this->hasPermission($menu, 'update');
    }

    public function canDelete(string $menu): bool
    {
        return $this->hasPermission($menu, 'delete');
    }

    // 🔥 BATASI LOGIN HANYA @internal
    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, '@internal');
    }
}
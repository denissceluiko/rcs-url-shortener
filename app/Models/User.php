<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar_path',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
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
            'role' => UserRole::class,
        ];
    }

    public function avatar(): string
    {
        return !empty($this->avatar_path) ? asset('storage/'.$this->avatar_path) : 'https://ui-avatars.com/api/?name='. urlencode($this->name) .'&color=FFFFFF&background=09090b';
    }

    public function isAdmin(): bool
    {
        return $this->role == UserRole::Administrator;
    }

    public function links(): HasMany
    {
        return $this->hasMany(Link::class);
    }

    public function scopeAdmins(Builder $query) : Builder
    {
        return $query->where('role', UserRole::Administrator);
    }
}

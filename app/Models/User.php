<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;
    use LogsActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name','email','role.name'])
            ->useLogName('User');
    }
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
    
    public function equipments(): HasMany
    {
        return $this->hasMany(Equipment::class);
    }

    public function isAdmin(): bool
    {
        return $this->role->permission_level === 3;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        // Uncomment this to require roles to access panel
        if ($panel->getId() === 'admin'){
            return str_contains($this->role->permission_level, 3);
            //return str_contains($this->role_id, 5);
        }
        if ($panel->getId() === 'moderator'){
            if (str_contains ($this->role->permission_level, 2) || str_contains($this->role->permission_level, 3)){
            //if (str_contains($this->role_id, 4) || str_contains($this->role_id, 5)){
                return true;
            }return false;            
        }
        return true;
        
    }
}

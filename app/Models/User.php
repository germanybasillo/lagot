<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type', // Added user_type to mass assignable attributes
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        // No need for casting user_type if it's a string or enum
    ];

    /**
     * Scope a query to only include tenants.
     */
    public function scopeTenants($query)
    {
        return $query->where('user_type', 'tenant');
    }

    /**
     * Scope a query to only include rental owners.
     */
    public function scopeRentalOwners($query)
    {
        return $query->where('user_type', 'rental_owner');
    }
}

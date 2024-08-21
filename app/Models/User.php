<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The name of the folder where user profile images are stored.
     *
     * @var string
     */
    const FOLDER_NAME = 'avatar';

    /**
     * Defines the 'admin' role for users.
     *
     * @var string
     */
    const ADMIN_ROLE = 'admin';

    /**
     * Defines the 'employee' role for users.
     *
     * @var string
     */
    const EMPLOYEE_ROLE = 'employee';

    /**
     * Defines the 'manager' role for users.
     *
     * @var string
     */
    const MANAGER_ROLE = 'manager';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
    ];

    /**
     * Scope a query to only include active users (those with a non-null email_verified_at value).
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    /**
     * Get the URL for the user's profile image.
     *
     * @return string The URL for the user's profile image.
     */
    public function getProfileImageURL()
    {
        return asset('storage/' . self::FOLDER_NAME . '/' . $this->image);
    }
}

<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'admin_id',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
        ];
    }

    /**
     * Get the mikrotiks for the user.
     */

    public function mikrotiks()
    {
        return $this->hasMany(Mikrotik::class);
    }

    public function adminMicrotiks()
    {
        return $this->hasMany(Mikrotik::class, 'admin_id');
    }


    // Relationship: An Admin can have many users
    public function users()
    {
        return $this->hasMany(User::class, 'admin_id');
    }

    // Relationship: A User belongs to an Admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Relationship: An admin can have many logs

    public function logs()
    {
        return $this->hasMany(Log::class, 'admin_id');
    }
}

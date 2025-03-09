<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mikrotik extends Model
{
    protected $fillable = [
        'name',
        'ip',
        'username',
        'password',
        'port',
        'location',
        'user_id',
    ];


    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

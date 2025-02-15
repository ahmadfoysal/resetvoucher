<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $fillable = ['user_id', 'mikrotik_id', 'action'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function mikrotik()
    {
        return $this->belongsTo(Mikrotik::class);
    }
}

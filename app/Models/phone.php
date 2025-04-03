<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class phone extends Model
{
    protected $fillable = ['phone', 'is_verified', 'verified_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

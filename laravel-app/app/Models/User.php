<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $guarded = ['id'];

    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function getFullNameAttribute()
    {
        $user = User::where('id', $this['id'])->first();
        return $user->first_name . ' ' . $user->last_name;
    }
}

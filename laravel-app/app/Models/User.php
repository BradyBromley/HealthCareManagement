<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;

class User extends Authenticatable
{
    use HasFactory;
    use Sortable;

    protected $guarded = ['id'];
    
    public $timestamps = false;
    public $sortable = ['id',
                        'email',
                        'first_name',
                        'last_name'];
    

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function availabilities()
    {
        return $this->belongsToMany('App\Models\Availability');
    }

    public function appointments()
    {
        return $this->hasMany('App\Models\Appointment');
    }

    // Get the first available time
    public function startTime()
    {
        $availabilities = $this->availabilities;
        if ($availabilities->isEmpty())
        {
            $start_time = '00:00:00';
        } else
        {
            $start_time = $availabilities->first()->time;
        }
        return $start_time;
    }

    // Get the last
    public function endTime()
    {
        $availabilities = $this->availabilities;
        if ($availabilities->isEmpty())
        {
            $end_time = '00:30:00';
        } else
        {
            $end_time = $availabilities->last()->time;
        }
        return $end_time;
    }

    public function hasPermissionTo($permission_name)
    {
        return $this->role->permissions->contains('permission_name', $permission_name);
    }

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}

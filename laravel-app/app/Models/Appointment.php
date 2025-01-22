<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;
use Auth;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;
    use Sortable;

    protected $guarded = ['id'];

    public $timestamps = false;
    public $sortable = ['patient_id',
                        'physician_id',
                        'start_time',
                        'end_time',
                        'reason',
                        'status'];

    public function patient()
    {
        return $this->belongsTo('App\Models\User', 'patient_id');
    }

    public function physician()
    {
        return $this->belongsTo('App\Models\User', 'physician_id');
    }

    // Get the first available time
    public function localStartTime()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->start_time, 'UTC');
        $date->setTimezone(Auth::user()->timezone);

        return $date->format('M j Y, g:i A');
    }

    public function localEndTime()
    {
        $date = Carbon::createFromFormat('Y-m-d H:i:s', $this->end_time, 'UTC');
        $date->setTimezone(Auth::user()->timezone);

        return $date->format('M j Y, g:i A');
    }
}

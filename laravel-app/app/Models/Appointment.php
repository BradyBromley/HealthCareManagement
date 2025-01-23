<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminCalendarDate extends Model
{
    protected $table = 'admin_calendar_dates';

    protected $fillable = ['date'];

    protected $casts = [
        'date' => 'date',
    ];

    public $timestamps = true;
}

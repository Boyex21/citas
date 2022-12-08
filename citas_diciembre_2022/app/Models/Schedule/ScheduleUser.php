<?php

namespace App\Models\Schedule;

use Illuminate\Database\Eloquent\Model;

class ScheduleUser extends Model
{
    protected $table = 'schedule_user';

    protected $fillable = ['user_id', 'schedule_id'];
}

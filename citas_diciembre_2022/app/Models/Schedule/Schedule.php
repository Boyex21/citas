<?php

namespace App\Models\Schedule;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use SoftDeletes;

    protected $fillable = ['day', 'start', 'end', 'appointment_limit', 'state'];

    protected $casts = [
        'start' => 'datetime',
        'end' => 'datetime'
    ];

    /**
     * Get the day.
     *
     * @return string
     */
    public function getDayAttribute($value)
    {
        if ($value=='1') {
            return 'Lunes';
        } elseif ($value=='2') {
            return 'Martes';
        } elseif ($value=='3') {
            return 'Miércoles';
        } elseif ($value=='4') {
            return 'Jueves';
        } elseif ($value=='5') {
            return 'Viernes';
        } elseif ($value=='6') {
            return 'Sábado';
        } elseif ($value=='7') {
            return 'Domingo';
        }
        return 'Desconocido';
    }

    /**
     * Get the state.
     *
     * @return string
     */
    public function getStateAttribute($value)
    {
        if ($value=='1') {
            return 'Activo';
        } elseif ($value=='0') {
            return 'Inactivo';
        }
        return 'Desconocido';
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        $schedule=$this->where($field, $value)->first();
        if (!is_null($schedule)) {
            return $schedule;
        }

        return abort(404);
    }

    public function users() {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function appointments() {
        return $this->hasMany(Appointment::class);
    }
}

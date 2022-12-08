<?php

namespace App\Models;

use App\Models\Schedule\Schedule;
use App\Models\Specialty\Specialty;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Appointment extends Model
{
    use SoftDeletes;

    protected $fillable = ['day', 'date', 'blood_pressure', 'pulse_rate', 'temperature', 'problem_description', 'covid', 'covid_date', 'uci', 'covid_state', 'advice', 'test', 'days', 'time', 'type', 'state', 'specialty_id', 'schedule_id', 'user_id', 'doctor_id'];

    protected $casts = [
        'date' => 'datetime',
        'covid_date' => 'datetime'
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
     * Get the covid.
     *
     * @return string
     */
    public function getCovidAttribute($value)
    {
        if ($value=='0') {
            return 'No';
        } elseif ($value=='1') {
            return 'Si';
        }
        return 'Desconocido';
    }

    /**
     * Get the uci.
     *
     * @return string
     */
    public function getUciAttribute($value)
    {
        if ($value=='0') {
            return 'No';
        } elseif ($value=='1') {
            return 'Si';
        }
        return 'Desconocido';
    }

    /**
     * Get the covid state.
     *
     * @return string
     */
    public function getCovidStateAttribute($value)
    {
        if ($value=='1') {
            return 'Recuperado';
        } elseif ($value=='2') {
            return 'No Recuperado';
        }
        return 'Desconocido';
    }

    /**
     * Get the time.
     *
     * @return string
     */
    public function getTimeAttribute($value)
    {
        if ($value=='1') {
            return 'Días';
        } elseif ($value=='2') {
            return 'Meses';
        } elseif ($value=='3') {
            return 'Años';
        }
        return 'Desconocido';
    }

    /**
     * Get the type.
     *
     * @return string
     */
    public function getTypeAttribute($value)
    {
        if ($value=='2') {
            return 'Virtual';
        } elseif ($value=='1') {
            return 'Presencial';
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
        if ($value=='2') {
            return 'Pendiente';
        } elseif ($value=='1') {
            return 'Tratado';
        } elseif ($value=='0') {
            return 'Cancelada';
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
        $appointment=$this->with(['specialty', 'schedule', 'user', 'doctor', 'prescriptions', 'symptoms'])->where($field, $value)->first();
        if (!is_null($appointment)) {
            return $appointment;
        }

        return abort(404);
    }

    public function specialty() {
        return $this->belongsTo(Specialty::class);
    }

    public function schedule() {
        return $this->belongsTo(Schedule::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function prescriptions() {
        return $this->hasMany(Prescription::class);
    }

    public function symptoms() {
        return $this->hasMany(AppointmentSymptom::class);
    }
}

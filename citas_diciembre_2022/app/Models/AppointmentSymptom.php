<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentSymptom extends Model
{
    protected $table = 'appointment_symptom';

    protected $fillable = ['symptom', 'appointment_id'];

    /**
     * Get the symptom.
     *
     * @return string
     */
    public function getSymptomAttribute($value)
    {
        if ($value=='1') {
            return 'Fiebre';
        } elseif ($value=='2') {
            return 'Tos';
        } elseif ($value=='3') {
            return 'Cansancio';
        } elseif ($value=='4') {
            return 'Pérdida del gusto';
        } elseif ($value=='5') {
            return 'Pérdida del olfato';
        } elseif ($value=='6') {
            return 'Dolor de garganta';
        } elseif ($value=='7') {
            return 'Dolor de cabeza';
        } elseif ($value=='8') {
            return 'Diarrea';
        } elseif ($value=='9') {
            return 'Dolor en el pecho';
        } elseif ($value=='10') {
            return 'Dificultad para respirar';
        }
        return 'Desconocido';
    }

    public function appointment() {
        return $this->belongsTo(Appointment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    protected $fillable = ['dosage', 'days', 'time', 'comments', 'medicine_id', 'appointment_id'];

    /**
     * Get the dosage.
     *
     * @return string
     */
    public function getDosageAttribute($value)
    {
        if ($value=='1') {
            return '0-0-0';
        } elseif ($value=='2') {
            return '0-0-1';
        } elseif ($value=='3') {
            return '0-1-0';
        } elseif ($value=='4') {
            return '0-1-1';
        } elseif ($value=='5') {
            return '1-0-0';
        } elseif ($value=='6') {
            return '1-0-1';
        } elseif ($value=='7') {
            return '1-1-0';
        } elseif ($value=='8') {
            return '1-1-1';
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
        if ($value=='2') {
            return 'Antes de Comer';
        } elseif ($value=='1') {
            return 'Despues de Comer';
        }
        return 'Desconocido';
    }

    public function medicine() {
        return $this->belongsTo(Medicine::class);
    }

    public function appointment() {
        return $this->belongsTo(Appointment::class);
    }
}

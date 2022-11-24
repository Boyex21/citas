<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    public function day(){
        return $this->belongsTo(Day::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }

    public function chamber(){
        return $this->belongsTo(Chamber::class);
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}
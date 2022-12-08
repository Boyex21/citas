<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    public function chamber(){
        return $this->belongsTo(Chamber::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class);
    }





    public function schedule(){
        return $this->belongsTo(Schedule::class);
    }

    public function prescribes(){
        return $this->hasMany(PrescriptionMedicine::class);
    }


}

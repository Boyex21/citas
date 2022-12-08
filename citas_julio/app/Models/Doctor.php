<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Doctor extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }

    public function chambers(){
        return $this->hasMany(Chamber::class);
    }

    public function staffs(){
        return $this->hasMany(Staff::class);
    }

    public function socialLinks(){
        return $this->hasMany(DoctorSocialLink::class);
    }

    public function schedules(){
        return $this->hasMany(Schedule::class);
    }

    public function imageGelleries(){
        return $this->hasMany(ImageGallery::class);
    }

    public function videoGelleries(){
        return $this->hasMany(VideoGallery::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    public function faqs() {
        return $this->hasMany(ServiceFaq::class);
    }

    public function galleries() {
        return $this->hasMany(ServiceImageGallery::class);
    }

    public function videos() {
        return $this->hasMany(Servicevideo::class);
    }




}

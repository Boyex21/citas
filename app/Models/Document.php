<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'user_id', 'doctor_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function doctor() {
        return $this->belongsTo(Doctor::class);
    }

    public function files() {
        return $this->hasMany(File::class);
    }
}

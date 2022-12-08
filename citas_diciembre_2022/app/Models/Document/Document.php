<?php

namespace App\Models\Document;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['description', 'user_id', 'doctor_id'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function doctor() {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function files() {
        return $this->hasMany(File::class);
    }
}

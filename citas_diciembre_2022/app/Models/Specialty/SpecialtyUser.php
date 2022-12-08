<?php

namespace App\Models\Specialty;

use Illuminate\Database\Eloquent\Model;

class SpecialtyUser extends Model
{
    protected $table = 'specialty_user';

    protected $fillable = ['user_id', 'specialty_id'];
}

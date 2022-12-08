<?php

namespace App\Models;

use App\Models\Schedule\Schedule;
use App\Models\Specialty\Specialty;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable
{
    use Notifiable, HasRoles, SoftDeletes, HasSlug;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'lastname', 'slug', 'photo', 'dni', 'phone', 'address', 'email', 'gender', 'birthday', 'weight', 'designation', 'about', 'education', 'password', 'state', 'location_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday' => 'datetime'
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Get the age.
     *
     * @return string
     */
    public function getAgeAttribute()
    {
        return age($this->birthday);
    }

    /**
     * Get the gender.
     *
     * @return string
     */
    public function getGenderAttribute($value)
    {
        if ($value=='1') {
            return 'Masculino';
        } elseif ($value=='2') {
            return 'Femenino';
        } elseif ($value=='3') {
            return 'Otro';
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
        if ($value=='1') {
            return 'Activo';
        } elseif ($value=='0') {
            return 'Inactivo';
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
        $user=$this->with(['roles'])->where($field, $value)->first();
        if (!is_null($user)) {
            return $user;
        }

        return abort(404);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom(['name', 'lastname'])->saveSlugsTo('slug')->slugsShouldBeNoLongerThan(191)->doNotGenerateSlugsOnUpdate();
    }

    public function location() {
        return $this->belongsTo(Location::class);
    }

    public function specialties() {
        return $this->belongsToMany(Specialty::class)->withTimestamps();
    }

    public function schedules() {
        return $this->belongsToMany(Schedule::class)->withTimestamps();
    }

    public function appointments(){
        return $this->hasMany(Appointment::class);
    }
}

<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});



Broadcast::channel('App.Models.Doctor.{id}', function ($doctor, $id) {
    return true;
});


Broadcast::channel('chat', function ($user) {
    return Auth::check();
  });

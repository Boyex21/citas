<?php

use App\Models\User;
use App\Models\Appointment;

function state($state) {
	if ($state=='Inactivo') {
		return '<span class="badge badge-danger">'.$state.'</span>';
	} elseif ($state=='Activo') {
		return '<span class="badge badge-success">'.$state.'</span>';
	}
	return '<span class="badge badge-dark">'.$state.'</span>';
}

function stateAppointment($state) {
	if ($state=='Cancelada') {
		return '<span class="badge badge-danger">'.$state.'</span>';
	} elseif ($state=='Tratado') {
		return '<span class="badge badge-success">'.$state.'</span>';
	} elseif ($state=='Pendiente') {
		return '<span class="badge badge-warning">'.$state.'</span>';
	}
	return '<span class="badge badge-dark">'.$state.'</span>';
}

function roleUser($user, $badge=true) {
	$num=1;
	$roles="";
	foreach ($user['roles'] as $rol) {
		if ($user->hasRole($rol->name)) {
			$roles.=($user['roles']->count()==$num) ? $rol->name : $rol->name."<br>";
			$num++;
		}
	}

	if (!is_null($user['roles']) && !empty($roles)) {
		if ($badge) {
			return '<span class="badge badge-primary">'.$roles.'</span>';
		} else {
			return $roles;
		}
	} else {
		if ($badge) {
			return '<span class="badge badge-dark">Desconocido</span>';
		} else {
			return 'Desconocido';
		}
	}
}

function active($path, $group=null) {
	if (is_array($path)) {
		foreach ($path as $url) {
			if (is_null($group)) {
				if (request()->is($url)) {
					return 'active';
				}
			} else {
				if (is_int(strpos(request()->path(), $url))) {
					return 'active';
				}
			}
		}
		return '';
	} else {
		if (is_null($group)) {
			return request()->is($path) ? 'active' : '';
		} else {
			return is_int(strpos(request()->path(), $path)) ? 'active' : '';
		}
	}
}

function menu_expanded($path, $group=null) {
	if (is_array($path)) {
		foreach ($path as $url) {
			if (is_null($group)) {
				if (request()->is($url)) {
					return 'true';
				}
			} else {
				if (is_int(strpos(request()->path(), $url))) {
					return 'true';
				}
			}
		}
		return 'false';
	} else {
		if (is_null($group)) {
			return request()->is($path) ? 'true' : 'false';
		} else {
			return is_int(strpos(request()->path(), $path)) ? 'true' : 'false';
		}
	}
}

function submenu($path, $action=null) {
	if (is_array($path)) {
		foreach ($path as $url) {
			if (is_null($action)) {
				if (request()->is($url)) {
					return 'class=active';
				}
			} else {
				if (is_int(strpos(request()->path(), $url))) {
					return 'show';
				}
			}
		}
		return '';
	} else {
		if (is_null($action)) {
			return request()->is($path) ? 'class=active' : '';
		} else {
			return is_int(strpos(request()->path(), $path)) ? 'show' : '';
		}
	}
}

function selectArray($arrays, $selectedItems) {
	$selects="";
	foreach ($arrays as $array) {
		$select="";
		if (count($selectedItems)>0) {
			foreach ($selectedItems as $selected) {
				if (is_object($selected) && $selected->slug==$array->slug) {
					$select="selected";
					break;
				} elseif ($selected==$array->slug) {
					$select="selected";
					break;
				}
			}
		}
		$selects.='<option value="'.$array->slug.'" '.$select.'>'.$array->name.'</option>';
	}
	return $selects;
}

function selectArrayRoles($arrays, $selectedItems) {
	$selects="";
	foreach ($arrays as $array) {
		$select="";
		if (count($selectedItems)>0) {
			foreach ($selectedItems as $selected) {
				if (is_object($selected) && $selected->name==$array->name) {
					$select="selected";
					break;
				} elseif ($selected==$array->name) {
					$select="selected";
					break;
				}
			}
		}
		$selects.='<option value="'.$array->name.'" '.$select.'>'.trans('permissions.'.$array->name).'</option>';
	}
	return $selects;
}

function selectArrayDoctorSpecialties($doctor, $selectedItems) {
	$doctor=User::with(['specialties'])->role(['Doctor'])->where('slug', $doctor)->first();
	$selects="";
	foreach ($doctor['specialties']->where('state', 'Activo') as $array) {
		$select="";
		if (count($selectedItems)>0) {
			foreach ($selectedItems as $selected) {
				if (is_object($selected) && $selected->slug==$array->slug) {
					$select="selected";
					break;
				} elseif ($selected==$array->slug) {
					$select="selected";
					break;
				}
			}
		}
		$selects.='<option value="'.$array->slug.'" '.$select.'>'.$array->name.'</option>';
	}
	return $selects;
}

function selectArrayDoctorSchedules($doctor, $selectedItems, $date) {
	$doctor=User::with(['schedules'])->role(['Doctor'])->where('slug', $doctor)->first();
	$selects="";
	foreach ($doctor['schedules']->where('state', 'Activo') as $array) {
		$select="";
		if (count($selectedItems)>0) {
			foreach ($selectedItems as $selected) {
				if (is_object($selected) && $selected->id==$array->id) {
					$select="selected";
					break;
				} elseif ($selected==$array->id) {
					$select="selected";
					break;
				}
			}
		}

		$countAppointment=Appointment::where([['date', date('Y-m-d', strtotime($date))], ['schedule_id' , $array->id], ['doctor_id', $doctor->id]])->count();
		$limit=$array->appointment_limit-$countAppointment;

		$selects.='<option value="'.$array->id.'" '.$select.'>'.$array->start->format('H:i A').' - '.$array->end->format('H:i A').' (Citas Disponibles: '.$limit.')</option>';
	}
	return $selects;
}

function selectArraySymptoms($arrays, $selectedItems) {
	$selects="";
	foreach ($arrays as $array) {
		$select="";
		if (count($selectedItems)>0) {
			foreach ($selectedItems as $selected) {
				if (is_object($selected) && $selected->symptom==$array['name']) {
					$select="selected";
					break;
				} elseif (!is_object($selected) && $selected==$array['id']) {
					$select="selected";
					break;
				}
			}
		}

		$selects.='<option value="'.$array['id'].'" '.$select.'>'.$array['name'].'</option>';
	}
	return $selects;
}

function store_files($file, $file_name, $route) {
	$image=$file_name.".".$file->getClientOriginalExtension();
	if (file_exists(public_path().$route.$image)) {
		unlink(public_path().$route.$image);
	}
	$file->move(public_path().$route, $image);
	return $image;
}

function image_exist($file_route, $image, $user_image=false, $large=true) {
	if (file_exists(public_path().$file_route.$image)) {
		$img=asset($file_route.$image);
	} else {
		if ($user_image) {
			$img=asset("/admins/img/template/usuario.png");
		} else {
			if ($large) {
				$img=asset("/admins/img/template/imagen.jpg");
			} else {
				$img=asset("/admins/img/template/image.jpg");
			}
		}
	}

	return $img;
}

function typeAppointment($type) {
	if ($type=='Virtual' || $type=='Presencial') {
		return '<span class="badge badge-primary">'.$type.'</span>';
	}
	return '<span class="badge badge-dark">'.$type.'</span>';
}

function age($date) {
    $birthday=new DateTime($date);
    $now=new DateTime(date("Y-m-d"));
    $diff=$now->diff($birthday);
    return $diff->format("%y");
}

function prescriptionDosage($dosage) {
    if ($dosage=='1') {
    	$dosage='0-0-0';
    } elseif ($dosage=='2') {
    	$dosage='0-0-1';
    } elseif ($dosage=='3') {
    	$dosage='0-1-0';
    } elseif ($dosage=='4') {
    	$dosage='0-1-1';
    } elseif ($dosage=='5') {
    	$dosage='1-0-0';
    } elseif ($dosage=='6') {
    	$dosage='1-0-1';
    } elseif ($dosage=='7') {
    	$dosage='1-1-0';
    } elseif ($dosage=='8') {
    	$dosage='1-1-1';
    } else {
    	$dosage='Desconocido';
    }
    return $dosage;
}

function prescriptionTime($time) {
    if ($time=='1') {
    	$time='Despues de Comer';
    } elseif ($time=='2') {
    	$time='Antes de Comer';
    } else {
    	$time='Desconocido';
    }
    return $time;
}
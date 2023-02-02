<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $table = 'students';
    
    public function inscripcion_estudiante(){
        return $this->hasMany('App\Models\Inscripcion');
    }


}

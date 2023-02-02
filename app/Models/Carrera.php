<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $table = 'careers';

    public function estudiante_carrera(){
        return $this->hasMany('App\Models\Estudiante');
    }
    
    public function seccion_carrera(){
        return $this->hasMany('App\Models\Seccion');
    }

}

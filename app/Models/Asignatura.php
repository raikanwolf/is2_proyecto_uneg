<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    use HasFactory;

    protected $table = 'courses';

      
    public function control_inscripcion_asignatura(){
        return $this->hasMany('App\Models\Control_inscripcion');
    }
    

}

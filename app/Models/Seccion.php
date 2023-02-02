<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'sections';

    public function asignaturas_secciones(){
        return $this->hasMany('App\Models\Asignatura');
    }

    public function semestres_secciones(){
        return $this->belongsTo('App\Models\Semestre', 'semesters_id');
    }
    
}
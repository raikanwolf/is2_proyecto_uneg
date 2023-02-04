<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

      
    public function control_inscripcion_asignatura(){
        return $this->hasMany('App\Models\Controls_incription', 'course_id');
    }

    public function seccion(){
        return $this->belongsTo('App\Models\Section', 'section_id');
    }
    
}

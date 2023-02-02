<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Control_inscripcion extends Model
{
    use HasFactory;

    protected $table = 'controls_incriptions';

    public function asignaturas_control_ins(){
        return $this->belongsTo('App\Models\Asignatura', 'course_id');
    }
    public function inscripcion_control_ins(){
        return $this->belongsTo('App\Models\Inscripcion', 'incription_id');
    }
    

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Controls_incription extends Model
{
    use HasFactory;

    protected $table = 'controls_incriptions';

    public function asignaturas_control_ins(){
        return $this->belongsTo('App\Models\Course', 'course_id');
    }
    public function inscripcion_control_ins(){
        return $this->belongsTo('App\Models\Incription', 'incription_id');
    }
}

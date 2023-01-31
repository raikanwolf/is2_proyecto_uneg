<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'incriptions';

      
    public function control_inscripcion(){
        return $this->hasMany('App\Models\Control_inscripcion');
    }
    
    public function Estudiante_ins(){
        return $this->belongsTo('App\Models\Estudiante', 'student_id');
    }
}

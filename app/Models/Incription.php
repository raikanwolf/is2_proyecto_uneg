<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incription extends Model
{
    use HasFactory;

    protected $table = 'incriptions';

      
    public function control_inscripcion_ins(){
        return $this->hasMany('App\Models\Controls_incription', 'incription_id');
    }
    
    public function estudiante_ins(){
        return $this->belongsTo('App\Models\student', 'student_id');
    }
}

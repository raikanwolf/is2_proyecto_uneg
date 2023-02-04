<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semestre extends Model
{
    use HasFactory;

    protected $table = 'semesters';

    public function secciones_semestre(){
        return $this->hasMany('App\Models\Seccion', 'semesters_id');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asignatura;
use App\Models\Inscripcion;
use App\Models\Estudiante;
use App\Models\Control_inscripcion;



class InscripcionController extends Controller
{
    public function todos(){

        $asignaturas = Asignatura::get();
        
        $inscripciones = Inscripcion::get();
        
        $estudiante = Estudiante::get();
        
        $control = Control_inscripcion::get();

        return view('mostrar', [
            'asignaturas' => $asignaturas,
            'inscripciones' => $inscripciones,
            'estudiantes' => $estudiante,
            'control' => $control
        ]);
    }
}

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Incription;
use App\Models\student;
use App\Models\Controls_incription;
use App\Models\User;
use App\Models\Section;


function mostrar_datos($id){

    //Busco el id de la inscripcion
    $inscripcion = Incription::where('student_id', $id)->first();
    //Busco todos los registros que coincidan con el id de la inscripcion
    $control_ins = Controls_incription::where('incription_id', $inscripcion->id)->get();
    $materias_ins= array();
    $cont=0;
    foreach($control_ins as $control){
        //Añado las asignaturas inscritas al array
        $asignatura = Course::find($control->course_id);
        $materias_ins[$cont]['asignatura'] = $asignatura;
        $materias_ins[$cont]['control_ins'] = $control;
        $cont++;
    }
    return $materias_ins;
}

function asignaturas_carreras($id){
    
    $nombre_asignaturas = DB:: table('courses')
    ->selectRaw("course_type, career_id, COUNT(course_type) as secciones")
    ->where('career_id', $id)
    ->groupBy('course_type','career_id')
    ->get();
    
    return $nombre_asignaturas; 
}

function asignaturas_carreras_adicion($id, $nombre){
    
    $nombre_asignaturas = DB:: table('courses')
    ->selectRaw("course_type, career_id, COUNT(course_type) as secciones")
    ->where('career_id', $id)
    ->where('course_type', $nombre)
    ->groupBy('course_type','career_id')
    ->get();
    
    return $nombre_asignaturas; 
}

function save_control_inscripcion($estudiante, $nombres, $seccion, $id_inscripcion){
    
    $carrera_estudiante = $estudiante->career_id;
    $semestre_estudiante = $estudiante->semester_id;
    $cont=0;
       
    for($i=0; $i < count($seccion); $i++){
            
        if($seccion[$i] != 'no'){
            //Se busca el id de la seccion
            $seccion_id = Section:: where('career_id', $carrera_estudiante)->where('semesters_id', $semestre_estudiante)
            ->where('section_number', $seccion[$i])->first();
            //Se busa el id de la asignatura
            $asignatura = Course:: where('section_id', $seccion_id->id)->where('course_type', $nombres[$cont])->first();
            $cont++;
            //Se crea el nuevo registro por cada materia inscrita 
            $control_inscripcion = new Controls_incription();
            $control_inscripcion->incription_id = $id_inscripcion;
            $control_inscripcion->course_id = $asignatura->id;
            $control_inscripcion->save();

        }
    }
    return $cont;
}
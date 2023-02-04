<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Asignatura;
use App\Models\Inscripcion;
use App\Models\Estudiante;
use App\Models\Control_inscripcion;
use App\Models\User;
use App\Models\Seccion;


class InscripcionController extends Controller
{
    public function ver_inscripcion(){
        //Se accede al usuario identificado, se supone que este tiene que ser el estudiante
        $user = \Auth::user();
        $id_user = $user->id;
        $estudiante = Estudiante::find($id_user);
        $carrera_estudiante = $estudiante->career_id;
        //Se busca las asignaturas que corresponadan con la carrera del estudiante
        $nombre_asignaturas = DB:: table('courses')
        ->selectRaw("course_type, careers_id, COUNT(course_type) as secciones")
        ->where('careers_id', $carrera_estudiante)
        ->groupBy('course_type','careers_id')
        ->get();
       
        return view('mostrar', [
            'nombre_asi' => $nombre_asignaturas
        ]);
    }
    
    public function mostrar(){
        
        $control_inscripcion = Inscripcion:: latest('id')->limit(1)->first();
        //echo $control_inscripcion ."<br/>";
        $asi=$control_inscripcion = Inscripcion::with('control_inscripcion_ins')
        ->where('id', $control_inscripcion->id)
        ->get();
        echo $asi;
         //var_dump($control_inscripcion);
        foreach($asi as $asignatura){
            echo $asignatura->control_inscripcion_ins[1]->id;
        }
        die();
            
    }

    public function inscribir(Request $request){
        
       
        //Se accede al usuario identificado, se supone que este tiene que ser el estudiante
        $user = \Auth::user();
        $id_user = $user->id;

        $fecha = date('Y-m-d');
        $estudiante = Estudiante::find($id_user);
        
        //Añadiendo a la tabla inscripcion
       $inscripcion = new Inscripcion();
        $inscripcion->student_id = $id_user;
        $inscripcion->fecha = $fecha;
        $inscripcion->save();
        echo 'todo bien';
        

        //Se cambia el status del estudiante
       $estudiante->status = 'Inscrito';
        $estudiante->update();
        echo $estudiante->status;

        //obtengo el id de la ultima inscripcion
        $ultima_inscripcion = Inscripcion:: latest('id')->limit(1)->first();
        $id_inscripcion = $ultima_inscripcion->id;
        
        $carrera_estudiante = $estudiante->career_id;
        $semestre_estudiante = $estudiante->semester_id;
        
        //Se obtiene los datos de las materias y secciones
        $nombres = $request->input('nombres');
        $seccion = $request->input('seccion');
        $cont=0;
        
        for($i=0; $i < count($seccion); $i++){
                
            if($seccion[$i] != 'no'){
                //Se busca el id de la seccion
               $seccion_id = Seccion:: where('career_id', $carrera_estudiante)->where('semesters_id', $semestre_estudiante)
                ->where('section_number', $seccion[$i])->first();
                //Se busa el id de la asignatura
                $asignatura = Asignatura:: where('section_id', $seccion_id->id)->where('course_type', $nombres[$cont])->first();
                $cont++;
                //Se crea el nuevo registro por cada materia inscrita 
                $control_inscripcion = new Control_inscripcion();
                $control_inscripcion->incription_id = $id_inscripcion;
                $control_inscripcion->course_id = $asignatura->id;
                $control_inscripcion->save();

            }
        }

        /*
        foreach($id_asignaturas as $id_asig){
            
            $id = (int) $id_asig;
            $asignatura = Asignatura::find($id);
            $control_inscripcion = new Control_inscripcion();
                $control_inscripcion->incription_id = $id_inscripcion;
                $control_inscripcion->course_id = $asignatura->id;
            $control_inscripcion->save();
                
        }
        echo "Todo bien";
        die();

        $control_inscripcion
        die();
        //return view('inscrito', []);*/
    }



}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\DB;
use App\Models\Course;
use App\Models\Incription;
use App\Models\student;
use App\Models\Controls_incription;
use App\Models\User;
use App\Models\Section;


class IncriptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        $id_user = $user->id;
        $estudiante = student::find($id_user);

        if($estudiante->status != 'Inscrito'){

            $carrera_estudiante = $estudiante->career_id;
            //Se busca las asignaturas que corresponadan con la carrera del estudiante
            $nombre_asignaturas = DB:: table('courses')
            ->selectRaw("course_type, career_id, COUNT(course_type) as secciones")
            ->where('career_id', $carrera_estudiante)
            ->groupBy('course_type','career_id')
            ->get();
        
            
            return view('mostrar', [
                'nombre_asi' => $nombre_asignaturas
            ]);
        }else{
            //Busco el id de la inscripcion
            $inscripcion = Incription::where('student_id', $id_user)->first();
            //Busco todos los registros que coincidan con el id de la inscripcion
            $control_ins = Controls_incription::where('incription_id', $inscripcion->id)->get();
            $materias_ins= array();
            $cont=0;
            foreach($control_ins as $control){
                //Añado las asignaturas inscritas al array
                $asignatura = Course::find($control->course_id);
                $materias_ins[$cont]['asignatura'] = $asignatura;
                $cont++;
            }
            return view('mostrar', [
                'asignaturas' => $materias_ins
            ]);
        }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //Valida que lleguen los datos de las asignaturas a inscribir
        $request->validate([
            'nombres' => 'required|array',
            'seccion' => 'required|array',
        ]);
        
        //Se accede al usuario identificado, se supone que este tiene que ser el estudiante
        $user = \Auth::user();
        $id_user = $user->id;

        $fecha = date('Y-m-d');
        $estudiante = student::find($id_user);
        
        if($estudiante->status != 'Inscrito'){
            //Añadiendo a la tabla inscripcion
            $inscripcion = new Incription();
            $inscripcion->student_id = $id_user;
            $inscripcion->fecha = $fecha;
            $inscripcion->save();
        
            //Se cambia el status del estudiante
            $estudiante->status = 'Inscrito';
            $estudiante->update();
        
            //obtengo el id de la ultima inscripcion
            $ultima_inscripcion = Incription:: latest('id')->limit(1)->first();
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
            if($cont >=1){
                return redirect()->route('dashboard')->with('message', 'Inscripcion realizada correctamente');
            }else{
                return redirect()->route('dashboard')->with('message', 'Error al realizar la inscripcion');
            }
        
        }else{
            return view('mostrar');
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

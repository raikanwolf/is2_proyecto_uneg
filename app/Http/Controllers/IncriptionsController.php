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
   //Metodo que me muestra las asignaturas que tengo inscritas
    public function index()
    {
        $user = \Auth::user();
        $id_user = $user->id;
        $estudiante = student::find($id_user);

        if($estudiante->status == 'Inscrito'){
            
            $materias_ins = mostrar_datos($id_user);
            
            return view('Inscripcion.ver_datos', [
                'asignaturas' => $materias_ins
            ]);
          
        }else{

            return view('Inscripcion.ver_datos');
        }

    }

  //Metodo que me muestra las asignaturas que puedo inscribir
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
        
            
            return view('Inscripcion.crear', [
                'nombre_asi' => $nombre_asignaturas
            ]);
        }else{
            
            $materias_ins = mostrar_datos($id_user);
            
            return view('Inscripcion.ver_datos', [
                'asignaturas' => $materias_ins
            ]);
        }
        
    }

  
  //Metodo que me inscribe una asignatura
    public function store(Request $request)
    { 
        //Valida que lleguen los datos de las asignaturas a inscribir
        $this->validate($request, [
            'nombres' => 'required|array',
            'seccion' => 'required|array',
        ]);
        
        //Se accede al usuario identificado, se supone que este tiene que ser el estudiante
        $user = \Auth::user();
        $id_user = $user->id;

        $fecha = date('Y-m-d');
        $estudiante = student::find($id_user);
    
        //Añadiendo a la tabla inscripcion
        $inscripcion = new Incription();
        $inscripcion->student_id = $id_user;
        $inscripcion->fecha = $fecha;
        $inscripcion->save();
    
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
            
            //Se cambia el status del estudiante
            $estudiante->status = 'Inscrito';
            $estudiante->update();
    
            $materias_ins = mostrar_datos($id_user);
            return redirect()->route('incriptions.index')->with([
                'message'=> 'Inscripcion realizada con exito'
            ]);

        }else{
            return redirect()->route('incriptions.create')->with([
                'message'=> 'Error al realizar la inscripcion'
            ]);
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

    //Metodo que me dice si existe mas de una seccion
    public function cambio($id_control, $nombre_asig, $carrera)
    {
        $cambio = Course::where('course_type', $nombre_asig)->where('career_id', $carrera)->get();
        //Comprobar que existe mas de una seccion
        if(count($cambio)>1){
            return view('Inscripcion.cambio',[
                'asignatura' => $nombre_asig,
                'cambio' => $cambio,
                'control_id' => $id_control
            ]);
        }else{
            return redirect()->route('incriptions.index')->with([
                'message' => 'Esta asignatura solo posee una seccion'
            ]);
        }
       
    }

  ////Metodo que me cambia de seccion
    public function seccion_ca(Request $request)
    {
        $this->validate($request, [
            'control_id' => 'required',
            'seccion' => 'required',
        ]);
       
        $id_control = $request->input('control_id');
        $id_course = $request->input('seccion');
        $control = Controls_incription::find($id_control);
        $control->course_id = $id_course;
        $control->update();

        return redirect()->route('incriptions.index')->with([
            'message' => 'Cambio realizado con exito!!'
        ]);
        
    }

  //Metodo para retirar una asignatura
    public function delete($id_control, $id_ins)
    {
        
        $control_inscripcion = Controls_incription::find($id_control);
        $control_inscripcion->delete();
        $inscrito = Controls_incription::where('incription_id', $id_ins)->get();
        //Se verifica que el estudiante aun tenga materias inscritas
        if(count($inscrito)>=1){
            return redirect()->route('incriptions.index')->with([
                'message'=> 'Asignatura retirada con exito'
            ]);
        }else{
            //En caso de que ya no tenga materias inscritas hay que eliminar los registros de la BD
            $user = \Auth::user();
            $id_user = $user->id;
            $estudiante = student::find($id_user);
            $inscripcion = Incription::where('student_id', $estudiante->id)->first();
            //Se elimina la inscripcion
            $inscripcion->delete();
            //Se actualiza su estado
            $estudiante->status = 'No inscrito';
            $estudiante->update();
            return redirect()->route('incriptions.index')->with([
                'message'=> 'Asignatura retirada con exito'
            ]);
        }
    }
}

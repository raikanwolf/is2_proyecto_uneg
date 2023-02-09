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
            $nombre_asignaturas = asignaturas_carreras($carrera_estudiante);
            
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
    
        //Comprobando que este estudiante no tiene inscripciones
        $estudiante_inscrito = Incription::where('student_id', $id_user)->first();
        if(empty($estudiante_inscrito)){
            //Añadiendo a la tabla inscripcion
        
            $inscripcion = new Incription();
            $inscripcion->student_id = $id_user;
            $inscripcion->fecha = $fecha;
            $inscripcion->save();
            //obtengo el id de la ultima inscripcion
            $ultima_inscripcion = Incription:: latest('id')->limit(1)->first();
            $id_inscripcion = $ultima_inscripcion->id;
    
        }else{
            $id_inscripcion = $estudiante_inscrito->id;
        }
            
        //Se obtiene los datos de las materias y secciones
        $nombres = $request->input('nombres');
        $seccion = $request->input('seccion');
        $cont = save_control_inscripcion($estudiante, $nombres, $seccion, $id_inscripcion);
        if($cont >=1){
            
            //Se cambia el status del estudiante
            $estudiante->status = 'Inscrito';
            $estudiante->update();
    
            $materias_ins = mostrar_datos($id_user);
            
            return view('Inscripcion.ver_datos', [
                'asignaturas' => $materias_ins
            ])->with([
                'message'=> 'La inscripcion se ha realizado con exito!!'
            ]);


        }else{
            return redirect()->route('incriptions.create')->with([
                'message'=> 'Error al realizar la inscripcion'
            ]);
        }
    
    }

   
    public function adicionar()
    {
    
        $user = \Auth::user();
        $id_user = $user->id;
        $estudiante = student::find($id_user);
        $carrera_estudiante = $estudiante->career_id;
        $nombre_asignaturas = asignaturas_carreras($carrera_estudiante);
        $inscripcion = Incription::where('student_id', $estudiante->id)->first();
        $datos = $inscripcion->control_inscripcion_ins;
        $adicion_asig = '';
        $adicion = array();
        $cont = 0;
        $ban = false;
        foreach ($nombre_asignaturas as $asignatura) {
            
            $adicion_asig = $asignatura->course_type;
            
            foreach ($datos as $data) {
            
                $asig_inscrita = $data->asignaturas_control_ins->course_type;
                if($adicion_asig == $asig_inscrita){
                    $ban = true;
                }
            }
            if(!$ban){
                $adicion[$cont] = asignaturas_carreras_adicion($carrera_estudiante, $adicion_asig);
                $cont++;
            }
            $ban=false;
        }
        if($cont>=1){
            return view('Inscripcion.adicionar', [
                'nombre_asi' => $adicion,
                'id_ins' => $inscripcion->id,
                'cont' => $cont
            ]);
        }else{
            
            $materias_ins = mostrar_datos($id_user);
            
            return view('Inscripcion.ver_datos', [
                'asignaturas' => $materias_ins
            ])->with([
                'message'=> 'No se encuentran asignaturas disponibles para la adicion'
            ]);
        }
        

    }

    public function save_adicion(Request $request){
        
        $this->validate($request, [
            'nombres' => 'required|array',
            'seccion' => 'required|array',
            'id_ins' => 'required'
        ]);

        $user = \Auth::user();
        $id_user = $user->id;

        $estudiante = student::find($id_user);
        
        //Se obtiene los datos de las materias y secciones
        $nombres = $request->input('nombres');
        $seccion = $request->input('seccion');
        $id_inscripcion = $request->input('id_ins');
        $cont = save_control_inscripcion($estudiante, $nombres, $seccion, $id_inscripcion);
        if($cont >=1){

            $materias_ins = mostrar_datos($id_user);
            
            return view('Inscripcion.ver_datos', [
                'asignaturas' => $materias_ins
            ])->with([
                'message'=> 'La asignatura se ha adicionado con exito!!'
            ]);

        }else{
            return redirect()->route('inscripciones.adicionar')->with([
                'message'=> 'Error al realizar la adicion'
            ]);
        }
        
    }



    //Metodo que me dice si existe mas de una seccion
    public function cambio($id_control, $nombre_asig, $carrera)
    {
        $user = \Auth::user();
        $id_user = $user->id;

        $cambio = Course::where('course_type', $nombre_asig)->where('career_id', $carrera)->get();
        //Comprobar que existe mas de una seccion
        if(count($cambio)>1){
            return view('Inscripcion.cambio',[
                'asignatura' => $nombre_asig,
                'cambio' => $cambio,
                'control_id' => $id_control
            ]);
        }else{
            $materias_ins = mostrar_datos($id_user);
            
            return view('Inscripcion.ver_datos', [
                'asignaturas' => $materias_ins
            ])->with([
                'message'=> 'Esta asignatura solo posee una seccion...'
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
        $user = \Auth::user();
        $id_user = $user->id;

        $id_control = $request->input('control_id');
        $id_course = $request->input('seccion');
        $control = Controls_incription::find($id_control);
        $control->course_id = $id_course;
        $control->update();

        $materias_ins = mostrar_datos($id_user);
            
        return view('Inscripcion.ver_datos', [
            'asignaturas' => $materias_ins
        ])->with([
            'message'=> 'Cambio de seccion realizado con exito!!'
        ]);
        
    }

  //Metodo para retirar una asignatura
    public function delete($id_control, $id_ins)
    {
        $user = \Auth::user();
        $id_user = $user->id;

        $control_inscripcion = Controls_incription::find($id_control);
        $control_inscripcion->delete();
        $inscrito = Controls_incription::where('incription_id', $id_ins)->get();
        //Se verifica que el estudiante aun tenga materias inscritas
        if(count($inscrito)>=1){
            $materias_ins = mostrar_datos($id_user);
            
            return view('Inscripcion.ver_datos', [
                'asignaturas' => $materias_ins
            ])->with([
                'message'=> 'Asignatura retirada con exito!!'
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
            
            return view('Inscripcion.ver_datos')->with([
                'message'=> 'Asignatura retirada con exito!!'
            ]);
        }
    }
}

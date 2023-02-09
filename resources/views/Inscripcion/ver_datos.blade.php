<div>
    @if(isset($message))
        <p>{{$message}}</p>
    @endif
    @if(isset($asignaturas) && !empty($asignaturas))
        
        <h1>Materias inscritas:</h1>
        <div>
        
            @foreach($asignaturas as $asig)
                <label> 
                    {{$asig['asignatura']->course_type}} - {{$asig['asignatura']->seccion->section_number}}
                    <a href="{{route('inscripciones.delete', ['id_control' =>$asig['control_ins']->id, 'id_ins' =>$asig['control_ins']->incription_id])}}">Retirar</a> 
                    <a href="{{route('inscripciones.cambio', ['id_control' => $asig['control_ins']->id, 'nombre_asig' => $asig['asignatura']->course_type , 'carrera' => $asig['asignatura']->career_id ])}}">Cambiar Seccion</a><br/>
                </label>
            @endforeach 
            <label> 
                <a href="{{route('inscripciones.adicion')}}">Adicionar materia</a><br><br> 
            </label>
        
        </div>
    @else
        <h1>No tienes materias inscritas</h1>
    @endif
    
</div>
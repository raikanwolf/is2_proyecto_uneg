<div>

    @if(isset($asignaturas))
        
        @if(isset($message))
            {{$message}}
        @endif

        <h1>Materias inscritas:</h1>
        <div>
            @if(isset($asignaturas))
                @foreach($asignaturas as $asig)
                    <label> 
                        {{$asig['asignatura']->course_type}} - {{$asig['asignatura']->seccion->section_number}} - {{$asig['control_ins']->id}}
                        <a href="{{route('incriptions.destroy', ['id' =>$asig['control_ins']->id])}}">Retirar</a> <a href="#">Cambiar Seccion</a><br>
                    </label>
                @endforeach 
            @endif
        </div>
    @else
        @if(isset($message))
            {{message}}
        @endif
        <h1>No tienes materias inscritas</h1>
    @endif
    
</div>
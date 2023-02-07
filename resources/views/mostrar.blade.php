
<div class="">
    @if (isset($nombre_asi))
        
        <h1>Inscripciones 2023</h1>
        <h2>Seleccione las asignaturas que va a inscribir este semestre </h2>
        
        <div class="">    
            <form action="{{route('incriptions.store')}}" method="post">
                {{ csrf_field() }}
                @foreach($nombre_asi as $asi)

                        
                    <label><input type="checkbox" name="nombres[]" value="{{$asi->course_type}}"> {{$asi->course_type  }}
                        <select name="seccion[]">
                            <option value="no" selected>
                                Elija la seccion 
                            </option>
                            @for($i = 1; $i<= $asi->secciones; $i++)
                                <option value="Seccion {{$i}}">
                                    Seccion{{"$i"}} 
                                </option>
                            @endfor
                        </select>
                        <br/>
                    </label>
                @endforeach
                <br/>
                <input type="submit" name="submit" value="Enviar"/>
            </form>
        </div>
    @else
        <div>
            <h1>Materias inscritas:</h1>
            <div>
                @if(isset($asignaturas))
                    @foreach($asignaturas as $p)
                        <label> 
                            {{$p['asignatura']->course_type}} {{$p['asignatura']->seccion->section_number}}<br>
                        </label>
                    @endforeach 
                @endif
            </div>
            
        </div>
    @endif
</div>
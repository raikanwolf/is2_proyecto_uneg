<div>
    @if(isset($message))
        <p>{{$message}}</p>
    @endif
    @if(isset($cambio) && isset($asignatura))
        <form action="{{route('inscripciones.update_seccion')}}" method="post">
            {{ csrf_field() }}
            <label for="">
                {{$asignatura}}
                <select name="seccion">
                    @foreach($cambio as $ca)
                        <option value="{{$ca->id}}">
                            {{$ca->seccion->section_number}} 
                        </option>
                    @endforeach
                </select>
            </label>
            <input type="hidden" name="control_id" value="{{$control_id}}">
            <input type="submit" value="Cambiar">
        </form>
    @endif
</div>
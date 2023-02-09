<div class="">
        
    <h1>Inscripciones 2023</h1>
    <h2>Seleccione las asignaturas que desea adicionar </h2>
    
    <div class="">   
        @if(isset($message))
            <p>{{$message}}</p>
        @endif 
        <form action="{{route('inscripciones.save_adicion')}}" method="post">
            {{ csrf_field() }}
            
            
            @foreach($nombre_asi as $asi)
                    
                <label><input type="checkbox" name="nombres[]" value="{{$asi[0]->course_type}}"> {{$asi[0]->course_type  }}
                    <select name="seccion[]">
                        <option value="no" selected>
                            Elija la seccion 
                        </option>
                       @for($i = 1; $i<= $asi[0]->secciones; $i++)
                            <option value="Seccion {{$i}}">
                                Seccion {{"$i"}} 
                            </option>
                        @endfor
                    </select>
                    <br/>
                </label>
            @endforeach
            <br/>
            
            <input type="hidden" name="id_ins" value="{{$id_ins}}"/>
            <input type="submit" name="submit" value="Enviar"/>
        </form>
    </div>
    
</div>
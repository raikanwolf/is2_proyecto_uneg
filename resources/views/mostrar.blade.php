<h1>Mostrando todos los datos</h1>

@foreach($asignaturas as $asi)

    {{$asi->course_type}}<br/>
    {{$asi->course_credit_units}}<br/>

@endforeach

@foreach($inscripciones as $ins)

    {{$ins->fecha}}<br/>
    {{$ins->student_id}}<br/>

@endforeach

@foreach($estudiantes as $es)

    {{$es->status}}<br/>
    {{$es->semester_id}}<br/>

@endforeach


@foreach($control as $con)

    {{$con->incription_id .'-'. $con->course_id  }}<br/>

@endforeach
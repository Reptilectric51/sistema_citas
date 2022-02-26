@extends('templates-layouts.headerandfooter')
@section('body')
<h1>Reporte de Consultas</h1>
<table>
    <thead>
    <tr>
        <th>
            <h3>id de la Cita</h3>
        </th>
        <th>
            <h3>Nombre completo del paciente</h3>
        </th>
        <th>
            <h3>Estatura</h3>
        </th>
        <th>
            <h3>Peso</h3>
        </th>
        <th>
            <h3>Temperatura</h3>
        </th>
        <th>
            <h3>Alergias</h3>
        </th>
        <th>
            <h3>Sintomas</h3>
        </th>
        <th>
            <h3>Diagnostico</h3>
        </th>
        <th>
            <h3>Medicamentos Recetados</h3>
        </th>
        <th>
            <h3>Observaciones</h3>
        </th>
    </tr>
</thead>
<tbody>
    @foreach ($consultas as $consulta)
    <tr>
        <td>{{$consulta->id_cita}}</td>
        <td>{{$consulta->nombre_paciente}} {{$consulta->apellido_paterno_paciente}} {{$consulta->apellido_materno_paciente}}</td>
        <td>{{$consulta->estatura}}</td>
        <td>{{$consulta->peso}}</td>
        <td>{{$consulta->temperatura}}</td>
        <td>{{$consulta->alergias}}</td>
        <td>{{$consulta->sintomas}}</td>
        <td>{{$consulta->diagnostico}}</td>
        <td>{{$consulta->medicamentos_recetados}}</td>
        <td>{{$consulta->observaciones}}</td>
    </tr>
    @endforeach
</tbody>
</table>
@endsection
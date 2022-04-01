@extends('templates-layouts.headerandfooter')
@if(empty(session('session_id')))
<script type="text/javascript">
    alert("No tiene los permisos suficientes para acceder a esta ventana por favor inicie sesión o contacte a un administrador");
    window.location.href = "/";
</script>
@else
@section('body')
<div class="inner-banner-w3ls">
    <div class="container">

    </div>
    <!-- //banner 2 -->
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        var refreshId = setInterval(function () {
            $('#sesion').load("{{route('verificar_sesion')}}");
        }, 500);
    });
</script>
<h1>Reporte de citas</h1>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>
                    <h3>CURP del paciente</h3>
                </th>
                <th>
                    <h3>Folio</h3>
                </th>
                <th>
                    <h3>Fecha</h3>
                </th>
                <th>
                    <h3>Hora</h3>
                </th>
                <th>
                    <h3>Estatus</h3>
                </th>
                <th>
                    <h3>opciones</h3>
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($citas as $cita)
            <tr>
                <td>{{$curp}}</td>
                <td>{{$cita->folio}}</td>
                <td>{{$cita->fecha_cita}}</td>
                <td>{{$cita->hora_cita}}</td>
                <td>{{$cita->estatus_cita}}</td>
                <td>
                    <form action="{{route('detalles_cita')}}" method="post">
                        @csrf
                        <input type="text" name="id" readonly value="{{$cita->id_cita}}" hidden>
                        <input type="text" name="paciente" readonly value="{{$cita->id_paciente}}" hidden>
                        <input type="text" name="folio" readonly value="{{$cita->folio}}" hidden>
                        <input type="submit"
                            style="border-radius: 5px; width: 130px; cursor: pointer; background-color: aqua;"
                            value="Ver detalles">
                    </form>
                    <form id="cancelar" action="{{route('cancelar_cita')}}" method="post">
                        @csrf
                        <input type="text" name="id" readonly value="{{$cita->id_cita}}" hidden>
                        <input type="text" name="folio" readonly value="{{$cita->folio}}" hidden>
                        @if($cita->folio != "Cancelado")
                        <input type="button" value="Cancelar cita"
                            style="border-radius: 5px; width: 130px; cursor: pointer; background-color: red;"
                            onclick="confirmacion()">
                        @else
                        <input type="button" value="Cancelar cita"
                            style="border-radius: 5px; width: 130px; cursor: pointer; background-color: red;"
                            onclick="cancelado()">
                        @endif
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="sesion">

</div>

<!-- Js files -->
<!-- JavaScript -->
<script src="js/jquery-2.2.3.min.js"></script>
<!-- Default-JavaScript-File -->

<!-- banner slider -->
<script src="js/responsiveslides.min.js"></script>
<script>
    $(function () {
        $("#slider4").responsiveSlides({
            auto: true,
            pager: true,
            nav: true,
            speed: 1000,
            namespace: "callbacks",
            before: function () {
                $('.events').append("<li>before event fired.</li>");
            },
            after: function () {
                $('.events').append("<li>after event fired.</li>");
            }
        });
    });
</script>

<script>
    function confirmacion() {
        var mensaje = confirm("Se va a cancelar la cita este proceso es irreversible");
        if (mensaje) {
            document.getElementById("cancelar").submit();
        }else{
            alert("No se ha cancelado la cita has denegado la cancelación");
        }
    }
</script>

<script>
    function cancelado() {
        alert("Ya se ha cancelado la cita anteriormente");
    }
</script>
<!-- //banner slider -->

<!-- smooth scrolling -->
<script src="js/SmoothScroll.min.js"></script>
<!-- move-top -->
<script src="js/move-top.js"></script>
<!-- easing -->
<script src="js/easing.js"></script>
<!--  necessary snippets for few javascript files -->
<script src="js/medic.js"></script>

<script src="js/bootstrap.js"></script>
<!-- Necessary-JavaScript-File-For-Bootstrap -->

<!-- //Js files -->
@endsection
@endif
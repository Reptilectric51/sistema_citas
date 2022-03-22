<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\citas;
use App\Models\pacientes;
use App\Models\especialidades;
use App\Models\consultorios;
use App\Models\consultas;
use Illuminate\Support\Facades\DB;
use \Crypt;//---->Se llama a la librería que nos permite encriptar las fotografías y contraseñas.


class SystemController extends Controller
{
    //----------------------------------------------Ver pacientes---------------------------------------//
    public function verusuarios()
    {
        $usuarios = pacientes::all();
        return view('templates.usuarios')
        ->with(['usuarios' => $usuarios]);
    }

    //----------------------------------------------Actualizar tabla usuarios--------------------------//
    public function verificar_sesion()
    {
        if(empty(session('session_id'))){
            echo '<script language="javascript"> alert("No tiene los permisos suficientes para acceder a esta ventana por favor inicie sesión o contacte a un administrador");
            window.location.href = "/";</script>';
        }
    }

    //----------------------------------------------Ver detalles usuario------------------------------//
    public function detallesusu(Request $request)
    {
        $id = $request['id'];
        $usuarios = pacientes::select('*')->where('id_pacientes','=',$id)->get();
        foreach($usuarios as $usuarior){
            $rfc = Crypt::decrypt($usuarior->rfc);
        }
        return view('templates.detalles-usu')
        ->with(['usuarios' => $usuarios])
        ->with('rfc', $rfc);
    }

    //----------------------------------------------Agregar nuevo usuario-----------------------------//
    public function nuevousuario(Request $request)
    {
        $correo = $request['correo'];
        $contraseña = $request['contraseña'];
        $confirmcontraseña = $request['confirmarcon'];
        if($request->file('foto') != ''){
            $file = $request->file('foto');

            $foto =$file->getClientOriginalName(); 

            $date = date('Ymd_His_');
                $foto2 =  $date . $foto;

            \Storage::disk('local')->put($foto2, \File::get($file));
        }
        else{
            $foto2 = "shadow.png";
        }
        if($contraseña = $confirmcontraseña){
        $emailexist = DB::select("SELECT * FROM pacientes  WHERE correo = '$correo'");
        if(count($emailexist) == 0){
            $paciente = pacientes::create(array(
                'nombre' => strtoupper($request['nombre']),
                'apellido_paterno' => strtoupper($request['apellido_paterno']),
                'apellido_materno' => strtoupper($request['apellido_materno']),
                'genero' => $request['genero'],
                'foto' => $foto2,
                'edad' => $request['edad'],
                'calle' => strtoupper($request['calle']),
                'numero' => $request['numero'],
                'codigo_postal' =>$request['cp'],
                'municipio' => strtoupper($request['municipio']),
                'telefono' => $request['telefono'],
                'correo' => $request['correo'],
                'contraseña' => Crypt::encrypt($contraseña),
                'rfc' => Crypt::encrypt($request['rfc']),
                'estatus' => $request['estatus']
            ));
            echo '<script language="javascript">alert("Te has registrado apropiadamente"); window.location.href="/";</script>';
        }else{
            echo'<script type="text/javascript">
                        alert("El usuario ya ha sido registrado anteriormente");
                        history.go(-1);
                        </script>';  
        }
      }else{
        echo'<script type="text/javascript">
                        alert("Las contraseñas deben ser iguales por favor verifique");
                        history.go(-1);
                        </script>';  
      }
    }


//----------------------------------------- ver citas ------------------------------//
    public function citas ()
    {
        $citas = citas::orderBy('fecha_cita', 'ASC', 'hora_cita', 'DESC')->get();
        return view('templates.citas.ver_citas')
        ->with(['citas' => $citas]);
    }

//-----------------------------------------crear_cita-------------------------//
    public function nueva_cita(){
        $especialidades = especialidades::all();
        return view('templates.citas.crear_cita')
        ->with(["especialidades" => $especialidades]);
    }

//----------------------------------------Guardar cita------------------------//
    public function guardar_cita(Request $request){
        $letra_usu = substr(session("session_name"), 0, 2); 
        $folio = $request['especialidad'].".".$request['fecha'].".".$request['hora'].".".$letra_usu;
        $citaexist = DB::select("SELECT * FROM citas  WHERE folio = '$folio'");
        if(count($citaexist) == 0){
        $paciente = citas::create(array(
            'id_paciente' => session('session_id'),
            'id_doctor' => 1,
            'id_especialidad' => $request['especialidad'],
            'estatus_cita' => "Activo",
            'folio' => $folio,
            'fecha_cita' => $request['fecha'],
            'hora_cita' => $request['hora'],
            'id_consultorio' => $request['consultorio']
        ));
        echo '<script language="javascript">alert("Cita agendada correctamente"); window.location.href="/";</script>';
    }else{
        echo'<script type="text/javascript">alert("Esta cita ya fue agendada con anterioridad");history.go(-1);</script>';
    }
    }

    //----------------------------------------------Ver detalles cita------------------------------//
    public function detalles_cita(Request $request)
    {
        $id = $request['id'];
        $citas = consultas::select('*')->where('id_cita','=',$id)->get();
        if(count($citas)==0){
            echo '<script language="javascript">alert("La cita no cuenta con detalles sera redirigido al formualrio para crear los respectivos"); window.location.href="/";</script>';
        }
    }


    //------------------------------------------- Crear Consultorio-------------------------------------------//
    public function nuevo_consultorio(){
        $especialidades = especialidades::all();
        return view('templates.consultorios.crear_consultorios')
        ->with(["especialidades" => $especialidades]);
    }
    public function guardar_consultorio(Request $request){

    $consultorio = consultorios::create(array(
        'numero_de_consultorio' => $request['numero_de_consultorio'],
        'id_especialidad' =>$request['id_especialidad'],
        'estatus' => $request['estatus']
    ));

    echo '<script language="javascript">alert("Tu consultorio se guardo exitosamente"); window.location.href="/";</script>';

    }
}



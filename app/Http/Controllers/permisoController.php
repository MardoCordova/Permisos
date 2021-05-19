<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\solicitud_permiso;
use App\permiso;
use App\empleado;
use App\user;
use DateTime;

class permisoController extends Controller
{




    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
 
        $IdTipoPermiso = $request->IDTipoPermiso;
        $id = Auth::user()->id;
        $nombre = Auth::user()->name;

                            //Funcion para convertir Time en decimal
                            function decimalHours($time)
                            {
                                $hms = explode(":", $time);
                                return ($hms[0] + ($hms[1]/60) );
                            }

                            //Obetenmos los datos del formulario
                            $horaSalida = $request->horaSalida;
                            $horaEntrada = $request->horaEntrada; 

                            //Encontrar la diferencia RESTA
                            $timeSalida = new DateTime($horaSalida);
                            $timeEntrada = new DateTime($horaEntrada);
                            $interval = $timeSalida->diff($timeEntrada);
                            $resta =  $interval->format('%H:%I'); 

                            //Convertir Decimal para insertar en las horas del EMPLEADO
                            $totalResta = decimalHours($resta); 

                            //Tomamos los datos del formulario a convertir a formato 12 HORAS (VISTA)
                           $date = new DateTime($horaSalida);
                           $hSalidaa = $date->format('g:i A');
                           $date = new DateTime($horaEntrada);
                           $hEntradaa = $date->format('g:i A');
                           

        switch ($IdTipoPermiso) {
            case 'Medica':

                $medico = new solicitud_permiso();
$idSolicitud =  $medico->id_solicitud = rand(1,99)."MED".$id;
                $medico->id_permiso_fk = "1";
                $medico->cod_users_fk = $id;
                $medico->hora_salida = $hSalidaa; 
                $medico->hora_entrada =  $hEntradaa;
                $medico->motivo_permiso = $request->MotivoPermiso;
               $request->file('CustomFile')->storeAs('public', $idSolicitud); 
                $medico->estado_revision = "PENDIENTE";
                $medico->save(); 

         
                    $empleados = empleado::findOrFail($id); 
                    $horasGastadas =   $totalResta;
                    $empleados->tiempo_disponible = $empleados->tiempo_disponible  - $horasGastadas;
                    $empleados->save();
                                   

               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '.$nombre); 

            break;

             case 'Fallecimiento':
                $fallecido = $request->NombreFallecido;
                $relacion = $request->relacionPariente;
                $medico = new solicitud_permiso();
                $medico->id_solicitud = rand(1,99)."FAL".$id;
                $medico->id_permiso_fk = "2";
                $medico->cod_users_fk = $id;
                $medico->motivo_permiso = $request->MotivoPermiso." --- "." Nombre del Fallecido: ".$fallecido.", y mi relación familiar con dicha persona es: ". $relacion;
                $medico->estado_revision = "Pendiente";
                $medico->save();

               return redirect('/permiso')->with('datos','Solictud de Fallecimiento Enviada, Estimado: '.$nombre); 

            break;

            case 'Matrimonio':
                $pareja = $request->NombrePareja;
                $fecha = $request->FechaEvento;
                $medico = new solicitud_permiso();
                $medico->id_solicitud = rand(1,99)."MAT".$id;
                $medico->id_permiso_fk = "3";
                $medico->cod_users_fk = $id;
                $medico->motivo_permiso = $request->MotivoPermiso." --- "." Nombre de la pareja: ".$pareja.", y la fecha del evento sera: ". $fecha;
                $medico->estado_revision = "Pendiente";
                $medico->save();

               return redirect('/permiso')->with('datos','Solictud de Matrimonio Enviada, Estimado: '.$nombre); 

            break;
        
            
            default:
               echo "nada papa";
                break;
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { //ACEPTAR
             
           $estado = solicitud_permiso::findOrFail($id);
           $estado->estado_revision = "ACEPTADA"; 
            $estado->save();
       

       $datos = solicitud_permiso::all();
        $idEmpleado = Auth::user()->id;
       $empleadoss = empleado::where('cod_empleado','=', $idEmpleado)->first()->tiempo_disponible;
       return view('permisos.verPermisosAdmin', compact('datos','empleadoss'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $estado = solicitud_permiso::findOrFail($id);
           $estado->estado_revision = "RECHAZADA"; 
           $estado->save();

       $datos = solicitud_permiso::all();
        $idEmpleado = Auth::user()->id;
       $empleadoss = empleado::where('cod_empleado','=', $idEmpleado)->first()->tiempo_disponible;
       return view('permisos.verPermisosAdmin', compact('datos','empleadoss'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  
                //Convierte datos de tipo date ("08:30") a decimal
              function decimalHours($time)
                            {
                                $hms = explode(":", $time);
                                return ($hms[0] + ($hms[1]/60) );
                            }
       
       //Accedemos a la otra de entrada y salida segun el id empleado
        $permiso = solicitud_permiso::findOrFail($id);
        $horaEntrada = $permiso->hora_entrada; 
        $horaSalida = $permiso->hora_salida; 
        
        //Convertimos las horas de formato 12 Horas a 24 Horas, porque la resta es mas facil en 24 Horas
        $hSalida  = date("H:i", strtotime($horaSalida)); 
        $hEntrada  = date("H:i", strtotime($horaEntrada)); 

        //Al estar en formato 24 horas se hace el diferencial de estas dos horas para sacar las horas de permiso
        $timeSalida = new DateTime($hSalida);
        $timeEntrada = new DateTime($hEntrada);
        $interval = $timeSalida->diff($timeEntrada);
        $resta =  $interval->format('%H:%I');

        //Convertimos la resta resultante en formato time a decimal 
        $totalResta = decimalHours($resta); 
                                                        
        //Eliminamos la solicitud
        $permiso->delete();


        //Accedemos a las horas disponibles del empleado
        $idEmpleado = Auth::user()->id;
        $empleados = empleado::findOrFail($idEmpleado);

        //Le sumamos las horas que iba a ocupar al total que ya tenia
        $empleados->tiempo_disponible = $empleados->tiempo_disponible + $totalResta; 

        //Guardamos las horas
        $empleados->save();
               
        return redirect('/verPermisos'); 
    }


    public function verPermisos()
    {
        $id = Auth::user()->id; 
        $datos = solicitud_permiso::where('cod_users_fk','=',$id)->orderBy('created_at', 'desc')->get();
        $contAceptados = solicitud_permiso::where('estado_revision','=','Aceptados')->count();
        $contPendientes = solicitud_permiso::where('estado_revision','=','Pendiente')->count();
        $empleadoss = empleado::where('cod_empleado','=', $id)->first()->tiempo_disponible;

       
        return view('permisos.verPermisos', compact('id','datos','contPendientes','contAceptados', 'empleadoss'));
    }

     public function verPermisosAdmin(Request $request)
    {
       $id = Auth::user()->id;
       $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado; 
       if ($cargo == 'Secretaria') {
                 
       $datos = solicitud_permiso::all();

       $empleadoss = empleado::where('cod_empleado','=', $id)->first()->tiempo_disponible;

       return view('permisos.verPermisosAdmin', compact('datos','empleadoss')); 
       } else{
        return redirect('/');
       }      
    }


    public function buscador(Request $request)
    {


        $id = $request->buscarpor1;

       $idSolicitud = solicitud_permiso::where('id_solicitud','=',$id)->first()->cod_users_fk;

       $nombreEmpleado = user::where('id','=',$idSolicitud)->first()->name;

        $cargoEmpleado = empleado::where('cod_empleado','=',$idSolicitud)->first()->cargo_empleado;

        $msm = $nombreEmpleado. " con el cargo de: ".$cargoEmpleado;
       return $msm;

        
    }


    public function confirmar($id)
    {
       
        $nombre = Auth::user()->name;
        $permiso = permiso::findOrFail($id);
         $permiso->delete();
        // return redirect('/permiso')->with('datos','Solictud Cancelada, Estimado: '.$nombre); 
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\solicitud_permiso;
use App\permiso;
use App\empleado;
use App\user;

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

        //dd($id);
        
        switch ($IdTipoPermiso) {
            case 'Medica':

                $medico = new solicitud_permiso();
$idSolicitud =  $medico->id_solicitud = rand(1,99)."MED".$id;
                $medico->id_permiso_fk = "1";
                $medico->cod_users_fk = $id;
                $medico->tiempo_permiso = $request->tiempoEmpleado; 
                $medico->motivo_permiso = $request->MotivoPermiso;
                $request->file('CustomFile')->storeAs('public', $idSolicitud); //Evidencia File
                $medico->estado_revision = "PENDIENTE";
                $medico->save(); 

                $tiempoDisponible = $request->tiempoEmpleado;

                if($tiempoDisponible == 'De 8:00 AM a 12:00 MD' || $tiempoDisponible == 'De 1:00 PM a 5:00 PM'){
                        $empleados = empleado::findOrFail($id);
                        $empleados->tiempo_disponible = $empleados->tiempo_disponible - 4; 
                        $empleados->save();
                }else{

                         $empleados = empleado::findOrFail($id);
                         $empleados->tiempo_disponible = $empleados->tiempo_disponible - 8;
                         $empleados->save();
                }
               

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

        $permiso = solicitud_permiso::findOrFail($id);
        $permiso->delete();

        $rangoTiempo = $permiso->tiempo_permiso;
        $idEmpleado = Auth::user()->id;
      

                if($rangoTiempo == 'De 8:00 AM a 12:00 MD' || $rangoTiempo == 'De 1:00 PM a 5:00 PM'){
                        $empleados = empleado::findOrFail($idEmpleado);
                        $empleados->tiempo_disponible = $empleados->tiempo_disponible + 4; 
                        $empleados->save();
                }else{

                         $empleados = empleado::findOrFail($idEmpleado);
                         $empleados->tiempo_disponible = $empleados->tiempo_disponible + 8;
                         $empleados->save();
                }
   
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

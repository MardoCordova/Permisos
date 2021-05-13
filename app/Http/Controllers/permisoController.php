<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\solicitud_permiso;
use App\permiso;

class permisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permisos.index');
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
                $medico->id_solicitud = rand(1,99)."MED".$id;
                $medico->id_permiso_fk = "1";
                $medico->cod_users_fk = $id;
                $medico->tiempo_permiso = $request->tiempoEmpleado;
                $medico->motivo_permiso = $request->MotivoPermiso;
                $medico->estado_revision = "Pendiente";
                $medico->save();

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
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }


    public function verPermisos()
    {
        $id = Auth::user()->id; 
        $datos = solicitud_permiso::where('cod_users_fk','=',$id)->orderBy('created_at', 'desc')->get();
        $contAceptados = solicitud_permiso::where('estado_revision','=','Aceptados')->count();
        $contPendientes = solicitud_permiso::where('estado_revision','=','Pendiente')->count();
        return view('permisos.verPermisos', compact('id','datos','contPendientes','contAceptados'));
    }
}

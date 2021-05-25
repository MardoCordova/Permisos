<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\solicitud_permiso;
use App\permiso;
use App\empleado;
use App\user;
use DateTime;
class permisoController2 extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
          $idEmpleado = Auth::user()->id;
         $empleadoss = empleado::where('cod_empleado','=', $idEmpleado)->first()->tiempo_disponible;
         return view('permisos.editPermisos', compact('estado', 'empleadoss'));
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
                  
                            //Funcion para convertir Time en decimal
                            function decimalHours($time)
                            {
                                $hms = explode(":", $time);
                                return ($hms[0] + ($hms[1]/60) );
                            }

                            //Obetenmos los datos del formulario
                            $horaSalida = $request->horaSalida;
                            $horaEntrada = $request->horaEntrada; 

                    $valorSalida = round(decimalHours($horaSalida));
                    $valorEntrada = round(decimalHours($horaEntrada));

                     //dd($valorSalida." ".$valorEntrada);

                    if (  (  $valorSalida <= 12)  &&  ( $valorEntrada >= 13)  ) {
                        $horaMedioDia = 1;
                    }else{
                        $horaMedioDia = 0;
                    }

                               //Encontrar la diferencia RESTA
                            $timeSalida = new DateTime($horaSalida);
                            $timeEntrada = new DateTime($horaEntrada);
                            $interval = $timeSalida->diff($timeEntrada);
                            $resta =  $interval->format('%H:%I'); 

                            //Convertir Decimal para insertar en las horas del EMPLEADO
                            $totalResta = decimalHours($resta); 
                            $horasGastadas =   $totalResta;

                             //Tomamos los datos del formulario a convertir a formato 12 HORAS (VISTA)
                           $date = new DateTime($horaSalida);
                           $hSalidaa = $date->format('g:i A');
                           $date = new DateTime($horaEntrada);
                           $hEntradaa = $date->format('g:i A');


                            $editSolicitud = solicitud_permiso::findOrFail($id);
                            $id = Auth::user()->id;
                            $empleados = empleado::findOrFail($id);
                            


                            if ($editSolicitud->hora_salida == $hSalidaa && $editSolicitud->hora_entrada == $hEntradaa) {
                               $horasGastadas = 0;
                               $horaMedioDia = 0;


                                 $empleados->tiempo_disponible = $empleados->tiempo_disponible  - $horasGastadas + $horaMedioDia;
                                  dd($empleados->tiempo_disponible."  Igual");
                                //$empleados->save();

                                  return redirect()->route('permiso.verPermiso');
         
                            }else{
                                  
                           $horaSvista = $editSolicitud->hora_salida;  
                           $horaEvista = $editSolicitud->hora_entrada; 

                            $timeSalida = new DateTime($horaSalida); //dato nuevo
                            $timeSalidaVista = new DateTime($horaSvista); //dato de la vista
                            $intervalSalida = $timeSalida->diff($timeSalidaVista);
                            $restaSalida = $intervalSalida->format('%H:%I'); 
                            $totalRestaSalida = decimalHours($restaSalida); 

                            $timeEntrada = new DateTime($horaEntrada);
                            $timeEntradaVista = new DateTime($horaEvista);
                            $intervalEntrada = $timeEntrada->diff($timeEntradaVista);
                            $restaEntrada =  $intervalEntrada->format('%H:%I');
                            $totalRestaEntrada = decimalHours($restaEntrada);

                            $RestaTotal = $totalRestaEntrada - $totalRestaSalida;

                            $empleados->tiempo_disponible = $empleados->tiempo_disponible  - $RestaTotal + $horaMedioDia;

                            dd($empleados->tiempo_disponible."  Diferente");
                          //  $empleados->save();
                                return redirect()->route('permiso.verPermiso');
                            }

                            $editSolicitud->hora_salida = $hSalidaa;
                            $editSolicitud->hora_entrada = $hEntradaa;                             
                            $editSolicitud->motivo_permiso = $request->MotivoPermiso;
                            $editSolicitud->save();
                              return redirect()->route('permiso.verPermiso');

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
}

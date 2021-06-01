<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\medico;
use App\MaterPater;
use App\fallecimiento;
use App\permiso;
use App\empleado;
use App\user;
use DateTime;
use Barryvdh\DomPDF\Facade as PDF;

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
           
        $tipoPermiso = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]+/u', '', $id);

        switch ($tipoPermiso) {
            case 'MED':
                 $estado = medico::findOrFail($id);
                 $idEmpleado = Auth::user()->id;
                 $empleadoss = empleado::where('cod_empleado','=', $idEmpleado)->first()->tiempo_disponible;
                 return view('permisos.editPermisos', compact('estado', 'empleadoss'));
                break;
            
            case 'MAT':
                 $estado = MaterPater::findOrFail($id);
                 $idEmpleado = Auth::user()->id;
                 $empleadoss = empleado::where('cod_empleado','=', $idEmpleado)->first()->tiempo_disponible;
                 return view('permisos.editPermisosPM', compact('estado', 'empleadoss'));
                break;

            case 'PAT':
                 $estado = MaterPater::findOrFail($id);
                 $idEmpleado = Auth::user()->id;
                 $empleadoss = empleado::where('cod_empleado','=', $idEmpleado)->first()->tiempo_disponible;
                 return view('permisos.editPermisosPM', compact('estado', 'empleadoss'));
                break;


            case 'FAL':
                 $estado = fallecimiento::findOrFail($id);
                 $idEmpleado = Auth::user()->id;
                 $empleadoss = empleado::where('cod_empleado','=', $idEmpleado)->first()->tiempo_disponible;
                 return view('permisos.editPermisosFA', compact('estado', 'empleadoss'));
                break;

            default:
                # code...
                break;
        }

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
                   $tipoPermiso = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]+/u', '', $id);

        switch ($tipoPermiso) {
            case 'MED':
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


                            $editSolicitud = medico::findOrFail($id);
                            $id = Auth::user()->id;
                            $empleados = empleado::findOrFail($id);
                            


                            if ($editSolicitud->hora_salida == $hSalidaa && $editSolicitud->hora_entrada == $hEntradaa) {
                              //dd("Entro ");
                                $editSolicitud->hora_salida = $hSalidaa;
                                $editSolicitud->hora_entrada = $hEntradaa;                             
                                $editSolicitud->motivo_permiso = $request->MotivoPermiso;
                                $editSolicitud->save();
                                $horasGastadas = 0;
                               //$horaMedioDia = 0;
                                $empleados->tiempo_disponible = $empleados->tiempo_disponible  - $horasGastadas ;
                                  //dd($empleados->tiempo_disponible."  Igual");
                                $empleados->save();
                                return redirect()->route('permiso.verPermiso');
         
                            }else{
                                  
                           $horaSvista = $editSolicitud->hora_salida;  
                           $horaEvista = $editSolicitud->hora_entrada; 
                           if ($horaEvista == "NULL") {
                               $horaEvista = $request->horaSalida;
                           }
                           

                           //Diferencia de times de la BD
                            $salida = new DateTime($horaSvista); //dato nuevo
                            $entrada = new DateTime($horaEvista); //dato de la vista
                            $inter = $salida->diff($entrada);
                            $resSalida = $inter->format('%H:%I'); 
                            $totalRestaBD = decimalHours($resSalida); 

                              //Diferencia de times salidaEdit y entradaEdit
                            $salidaV = new DateTime($horaSalida); //dato nuevo
                            $entradaV = new DateTime($horaEntrada); //dato de la vista
                            $interV = $salidaV->diff($entradaV);
                            $resTotalV = $interV->format('%H:%I'); 
                            $totalRestaV = decimalHours($resTotalV); 

                         //   dd($totalRestaBD);
/*
                            //Diferencia de la salidaBD y salidaEdit
                            $timeSalida = new DateTime($horaSalida); //dato nuevo
                            $timeSalidaVista = new DateTime($horaSvista); //dato de la vista
                            $intervalSalida = $timeSalida->diff($timeSalidaVista);
                            $restaSalida = $intervalSalida->format('%H:%I'); 
                            $totalRestaSalida = decimalHours($restaSalida); 

                            //Diferencia de la entradaBD y entradaEdit
                            $timeEntrada = new DateTime($horaEntrada);
                            $timeEntradaVista = new DateTime($horaEvista);
                            $intervalEntrada = $timeEntrada->diff($timeEntradaVista);
                            $restaEntrada =  $intervalEntrada->format('%H:%I');
                            $totalRestaEntrada = decimalHours($restaEntrada);

                            //Diferencia total de Entradas y salidas ya procesadas
                            $restaE = new DateTime($restaEntrada);
                            $restaS = new DateTime($restaSalida);
                            $interva = $restaE->diff($restaS);
                            $diffResta =  $interva->format('%H:%I');
                            $totalDiffResta = decimalHours($diffResta);


                            if ($totalRestaBD<$horasGastadas) {
                                //dd("Menor -----");
                                $Signo = "1";
                            }else{
                                $Signo = "-1";
                                //dd("Mayo no hay pex ++++");
                            }
*/                            
                            $tiempoAntes = $empleados->tiempo_disponible;
                            $empleados->tiempo_disponible = ($tiempoAntes + $totalRestaBD)  - $totalRestaV ;




//dd("Diferente. Tiempo Disponible:".$empleados->tiempo_disponible." Resta BD:".$totalRestaBD." Almuerzo:".$horaMedioDia." Entrada:".$totalRestaEntrada." Salida:".$totalRestaSalida." Total Diferencia: ".$totalRestaV. " Tiempo Antes:".$tiempoAntes);
                         $empleados->save();
                            $editSolicitud->hora_salida = $hSalidaa;
                            $editSolicitud->hora_entrada = $hEntradaa;                             
                            $editSolicitud->motivo_permiso = $request->MotivoPermiso;
                            $editSolicitud->save();
                                return redirect()->route('permiso.verPermiso');
                            }

                break;
            
            case 'MAT':
                     $maternidad = MaterPater::findOrFail($id);
                     $maternidad->fecha_permiso = $request->fechaPM;
                     $maternidad->motivo_permiso = $request->MotivoPermisoPM;
                     $maternidad->save();
                      return redirect()->route('permiso.verPermiso');
                break;

                 case 'PAT':
                     $maternidad = MaterPater::findOrFail($id);
                     $maternidad->fecha_permiso = $request->fechaPM;
                     $maternidad->motivo_permiso = $request->MotivoPermisoPM;
                     $maternidad->save();
                      return redirect()->route('permiso.verPermiso');
                break;

                 case 'FAL':
                     $fallecimiento = fallecimiento::findOrFail($id);
                     $fallecimiento->fecha_permiso = $request->fechaFA;
                     $fallecimiento->motivo_permiso = $request->MotivoPermisoFA;
                     $fallecimiento->nombre_fallecido = $request->nombreFallecido;
                     $fallecimiento->relacion_fallecido = $request->relacionFallecido;
                     $fallecimiento->save();
                      return redirect()->route('permiso.verPermiso');
                break;

            default:
                # code...
                break;
        }

                            
                          
                            

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

    public function imprimir()
    { 
    $datosMedicos = medico::all();
    $datosFallecidos = fallecimiento::all();
    $datosMaterPater = MaterPater::all();
    return $pdf = \PDF::loadView('pdfViews.pdfviewAll', compact('datosMedicos','datosFallecidos','datosMaterPater'))->setPaper('a3', 'landscape')->stream('pdfviewAll.pdf');
    }

    public function imprimirID(Request $request)
    {

    $tipoPermiso = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]+/u', '', $request->idSoli);

 


switch ($tipoPermiso) {

    case 'MED':
         $idSoli = medico::where('id_solicitud','=',$request->idSoli)->first();
        return $pdf = \PDF::loadView('pdfViews.pdfViewID', compact('idSoli','tipoPermiso'))->setPaper('a5', 'horizontally')->stream('pdfViewID.pdf');
        break;

          case 'MAT':
         $idSoli = MaterPater::where('id_solicitud','=',$request->idSoli)->first();
        return $pdf = \PDF::loadView('pdfViews.pdfViewIDmaterpater', compact('idSoli','tipoPermiso'))->setPaper('a5', 'horizontally')->stream('pdfViewID.pdf');
        break;

          case 'PAT':
         $idSoli = MaterPater::where('id_solicitud','=',$request->idSoli)->first();
        return $pdf = \PDF::loadView('pdfViews.pdfViewIDmaterpater', compact('idSoli','tipoPermiso'))->setPaper('a5', 'horizontally')->stream('pdfViewID.pdf');
        break;

          case 'FAL':
         $idSoli = fallecimiento::where('id_solicitud','=',$request->idSoli)->first();
        return $pdf = \PDF::loadView('pdfViews.pdfViewIDfallecimiento', compact('idSoli','tipoPermiso'))->setPaper('a5', 'horizontally')->stream('pdfViewID.pdf');
        break;
    
    default:
        # code...
        break;
}
   
        
    }
}

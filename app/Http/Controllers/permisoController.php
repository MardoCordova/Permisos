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
use Carbon\Carbon;
use App\medicoG;
use App\personal;
use App\obligacionCiudadano;


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

                            

                            if (isset($request->horaEntrada)) {
                                $horaEntrada = $request->horaEntrada;

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

                                $empleados = empleado::findOrFail($id); 
                                $horasGastadas =   $totalResta;
                                $valorSalida = round(decimalHours($horaSalida));
                                $valorEntrada = round(decimalHours($horaEntrada));
                                    if (  (  $valorSalida <= 12)  &&  ( $valorEntrada >= 13)  ) {
                                        $horaMedioDia = 1;
                                    }else{
                                        $horaMedioDia = 0;
                                    }
                                $empleados->tiempo_disponible = $empleados->tiempo_disponible  - $horasGastadas + $horaMedioDia;
                                $empleados->save();


                            }else{
                                $hEntradaa = "NULL";
                                $date = new DateTime($horaSalida);
                                $hSalidaa = $date->format('g:i A');
                            }


                            //dd(decimalHours($horaSalida));
                            //Encontrar la diferencia RESTA
                            
                           

        switch ($IdTipoPermiso) {
            case 'Medica':
                $medico = new medico();
$idSolicitud =  $medico->id_solicitud = rand(1,99)."MED".$id;
                $medico->id_permiso_fk = "1";
                $medico->cod_users_fk = $id;
                $medico->hora_salida = $hSalidaa; 
                $medico->fecha_permiso = $request->fechaPermiso;
                $medico->hora_entrada =  $hEntradaa;
                $medico->motivo_permiso = $request->MotivoPermiso;
                $request->file('CustomFile')->storeAs('public', $idSolicitud); 
                $medico->estado_revision = "PENDIENTE";
                $medico->save(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '.$nombre); 

            break;

                  case 'PM':



                  $genero = empleado::findOrFail($id)->sexo;
                    if ($genero == "M") {

                    $totalFecha = Carbon::parse($request->fechaPMSalida);
                            if ($request->cantDias == 1) {
                                $dias = 0;
                                $aux=0;
                                $contDias = empleado::findOrFail($id);
                                $contDias->dispo_materpater = $contDias->dispo_materpater - 1;
                                $contDias->save();
                            }else{
                                $aux = 1;
                                $dias = $request->cantDias;
                                $contDias = empleado::findOrFail($id);
                                $mayor = max($request->cantDias,$contDias->dispo_materpater);
                                $menor = min($request->cantDias,$contDias->dispo_materpater);
                                $contDias->dispo_materpater = $mayor - $menor;
                                $contDias->save();
                            }

                    $ddd = $totalFecha->addDays($dias-$aux)->format('Y-m-d');
                    $gen = "PAT";

                    }else{

                        $totalFecha = Carbon::parse($request->fechaPMSalida);
                        $ddd = $totalFecha->addMonth(3)->format('Y-m-d');
                        $gen = "MAT";
                    }

                $materPater = new MaterPater();
$idSolicitud =  $materPater->id_solicitud = rand(1,99).$gen.$id;
                $materPater->id_permiso_fk = "3";
                $materPater->cod_users_fk = $id;
                $materPater->fecha_salida = $request->fechaPMSalida;
                $materPater->fecha_entrada = $ddd;
                $materPater->motivo_permiso = $request->MotivoPermisoPM;
                $request->file('CustomFilePM')->storeAs('public', $idSolicitud); 
                $materPater->estado_revision = "PENDIENTE";
                $materPater->save(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '.$nombre); 
            break;

             case 'FA':
              $fallecido = new fallecimiento();
                $idSolicitud =  $fallecido->id_solicitud = rand(1,99)."FAL".$id;
                $fallecido->id_permiso_fk = "2";
                $fallecido->cod_users_fk = $id;
                $fallecido->fecha_permiso = $request->fechaFA;
                $fallecido->nombre_fallecido = $request->nombreFallecido; 
                $fallecido->relacion_fallecido = $request->relacionFallecido;
                $fallecido->motivo_permiso = $request->MotivoPermisoFA;
                $request->file('CustomFileFA')->storeAs('public', $idSolicitud); 
                $fallecido->estado_revision = "PENDIENTE";
                $fallecido->save(); 
          
               return redirect('/permiso')->with('datos','Solictud de Fallecimiento Enviada, Estimado: '.$nombre); 

            break;

            case 'Matrimonio':
                $pareja = $request->NombrePareja;
                $fecha = $request->FechaEvento;
                $medico = new medico();
                $medico->id_solicitud = rand(1,99)."MAT".$id;
                $medico->id_permiso_fk = "5";
                $medico->cod_users_fk = $id;
                $medico->motivo_permiso = $request->MotivoPermiso." --- "." Nombre de la pareja: ".$pareja.", y la fecha del evento sera: ". $fecha;
                $medico->estado_revision = "Pendiente";
                $medico->save();

               return redirect('/permiso')->with('datos','Solictud de Matrimonio Enviada, Estimado: '.$nombre); 

            break;

            case 'MedicoG':
                $medicoG = new medicoG();
$idSolicitud =  $medicoG->id_solicitud = rand(1,99)."MEDG".$id;
                $medicoG->id_permiso_fk = "4";
                $medicoG->cod_users_fk = $id;
                $medicoG->fecha_salida = $request->fechaPermisoMEDG; 
                $medicoG->fecha_entrada =  $request->fechaEntradaMEDG;
                $medicoG->motivo_permiso = $request->MotivoPermisoMEDG;
                $request->file('CustomFileMEDG')->storeAs('public', $idSolicitud); 
                $medicoG->estado_revision = "PENDIENTE";
                $medicoG->save(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '.$nombre);
                break;

                 case 'Personal':
                $personal = new personal();
$idSolicitud =  $personal->id_solicitud = rand(1,99)."PER".$id;
                $personal->id_permiso_fk = "6";
                $personal->cod_users_fk = $id;
                $personal->fecha_salida = $request->fechaPermisoPER; 
                $personal->fecha_entrada =  $request->fechaEntradaPER;
                $personal->motivo_permiso = $request->MotivoPermisoPER;
                $personal->estado_revision = "PENDIENTE";
                $personal->save(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '.$nombre);
                break;

                case 'OBL':
                $obligacionCiudadano = new obligacionCiudadano();
$idSolicitud =  $obligacionCiudadano->id_solicitud = rand(1,99)."OBL".$id;
                $obligacionCiudadano->id_permiso_fk = "7";
                $obligacionCiudadano->cod_users_fk = $id;
                $obligacionCiudadano->fecha_salida = $request->fechaPermisoOBL; 
                $obligacionCiudadano->fecha_entrada =  $request->fechaEntradaOBL;
                $obligacionCiudadano->motivo_permiso = $request->MotivoPermisoOBL;
                $request->file('CustomFileOBL')->storeAs('public', $idSolicitud); 
                $obligacionCiudadano->estado_revision = "PENDIENTE";
                $obligacionCiudadano->save(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '.$nombre);
                break;
        
            
            default:
               echo "ID MALO ";
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
             $tipoPermiso = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]+/u', '', $id);


             switch ($tipoPermiso) {
                 case 'MED':
                        $estado = medico::findOrFail($id);
                        $estado->estado_revision = "ACEPTADA"; 
                        $estado->save();
                return redirect('/verAdmin');
                     break;

                        case 'MAT':
                        $estado = MaterPater::findOrFail($id);
                        $estado->estado_revision = "ACEPTADA"; 
                        $estado->save();
                  return redirect('/verAdmin');
                     break;

                       case 'PAT':
                        $estado = MaterPater::findOrFail($id);
                        $estado->estado_revision = "ACEPTADA"; 
                        $estado->save();
       return redirect('/verAdmin');
                     break;

                       case 'FAL':
                        $estado = fallecimiento::findOrFail($id);
                        $estado->estado_revision = "ACEPTADA"; 
                        $estado->save();
      return redirect('/verAdmin');
                     break;

                         case 'MEDG':
                        $estado = medicoG::findOrFail($id);
                        $estado->estado_revision = "ACEPTADA"; 
                        $estado->save();
       return redirect('/verAdmin');
                     break;
                 

             case 'PER':
      $estado = personal::findOrFail($id);
     $estado->estado_revision = "ACEPTADA"; 
      $estado->save();
      return redirect('/verAdmin');
                     break;

       case 'OBL':
      $estado = obligacionCiudadano::findOrFail($id);
     $estado->estado_revision = "ACEPTADA"; 
      $estado->save();
     return redirect('/verAdmin');
                     break;



                 default:
                     # code...
                     break;
             }

        

            $estado = fallecimiento::findOrFail($id);
           $estado->estado_revision = "ACEPTADA"; 
            $estado->save();

            $estado = MaterPater::findOrFail($id);
           $estado->estado_revision = "ACEPTADA"; 
            $estado->save();
       

     
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
        $estado->estado_revision = "RECHAZADA"; 
        $estado->save();
        return redirect('/verAdmin');

                    break;

                    case 'FAL':
        $estado = fallecimiento::findOrFail($id);
        $estado->estado_revision = "RECHAZADA"; 
        $estado->save();
      
     return redirect('/verAdmin');
                        break;
                
                case 'MAT':
        $estado = MaterPater::findOrFail($id);
        $estado->estado_revision = "RECHAZADA"; 
        $estado->save();
     
       return redirect('/verAdmin');
                    break;

                    case 'PAT':
        $estado = MaterPater::findOrFail($id);
        $estado->estado_revision = "RECHAZADA"; 
        $estado->save();
       return redirect('/verAdmin');
                    break;

                case 'MEDG':
        $estado = medicoG::findOrFail($id);
        $estado->estado_revision = "RECHAZADA"; 
        $estado->save();

   return redirect('/verAdmin');
                    break;  


                case 'PER':
        $estado = personal::findOrFail($id);
        $estado->estado_revision = "RECHAZADA"; 
        $estado->save();

  return redirect('/verAdmin');
                    break;                        

          
                case 'OBL':
        $estado = obligacionCiudadano::findOrFail($id);
        $estado->estado_revision = "RECHAZADA"; 
        $estado->save();

    return redirect('/verAdmin');
                    break;             

                       
                default:
                    # code...
                    break;
            }
     
       

       

     
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
        


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {  

 $tipoPermiso = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]+/u', '', $id);

 switch ($tipoPermiso) {
     case 'MED':
        function decimalHours($time)
                            {
                                $hms = explode(":", $time);
                                return ($hms[0] + ($hms[1]/60) );
                            }

       
       $permisoNULL = medico::findOrFail($id);
        $horaEntradaNULL = $permisoNULL->hora_entrada; 


             if ($horaEntradaNULL == "NULL") {

                $permiso = medico::findOrFail($id);
                $horaEntrada = $permiso->hora_entrada; 
                $horaSalida = $permiso->hora_salida; 
                $permiso->delete();

                return redirect('/verPermisos');

            }else{

                  //Accedemos a la otra de entrada y salida segun el id empleado
        $permiso = medico::findOrFail($id);
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

        //Verificamos si el rango de permiso solo fue PM o todo AM para quitar la hora de almuerzo
        $valorSalida = decimalHours($hSalida);
        $valorEntrada = decimalHours($hEntrada);
        if (  ($valorSalida <= 12)  &&  ($valorEntrada >= 13)  ) {
                    $horaMedioDia = 1;
            }else{
                $horaMedioDia = 0;
            }

        //Le sumamos las horas que iba a ocupar al total que ya tenia
        $empleados->tiempo_disponible = $empleados->tiempo_disponible + $totalResta - $horaMedioDia; 

        //Guardamos las horas
       $empleados->save();
       //  dd($horaMedioDia);      
        return redirect('/verPermisos');
                   
            }  
         break;


         case 'MAT':
                $materPater = MaterPater::findOrFail($id);

                $materPater->delete(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '); 
             break;
     
        case 'PAT':
                $materPater = MaterPater::findOrFail($id);
                $idUSER = Auth::user()->id;
                $fechaSalidaPM = MaterPater::findOrFail($id)->fecha_salida;
                $fechaEntradaPM = MaterPater::findOrFail($id)->fecha_entrada;

                $sal = Carbon::createFromDate($fechaSalidaPM);
                $ent = Carbon::createFromDate($fechaEntradaPM);

                $diferenciaDias = $sal->diffInDays($ent);

                if ($diferenciaDias == 0) {
                    $diferenciaDias = 1;
                    
                $devolucion = empleado::findOrFail($idUSER);
                $devolucion->dispo_materpater = $devolucion->dispo_materpater + $diferenciaDias;
                 //dd($devolucion->dispo_materpater." aa");
                $devolucion->save();
                $materPater->delete(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '); 


                }else{


                $aux = 1;
                $devolucion = empleado::findOrFail($idUSER);
                $devolucion->dispo_materpater = $devolucion->dispo_materpater + $diferenciaDias + $aux;
                //dd($devolucion->dispo_materpater);
                $devolucion->save();
                $materPater->delete(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '); 
                }
               
            break;
 
        case 'FAL':
                $fallecimiento = fallecimiento::findOrFail($id);
                $fallecimiento->delete(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '); 
            break;

             case 'MEDG':
                $medicoG = medicoG::findOrFail($id);
                $medicoG->delete(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '); 
            break;

             case 'PER':
                $personal = personal::findOrFail($id);
                $personal->delete(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '); 
            break;

             case 'OBL':
                $obligacionCiudadano = obligacionCiudadano::findOrFail($id);
                $obligacionCiudadano->delete(); 
               return redirect('/permiso')->with('datos','Solictud Medica Enviada, Estimado: '); 
            break;
     default:
         # code...
         break;
 }
                //Convierte datos de tipo date ("08:30") a decimal
              
        
         
    }


    public function verPermisos()
    {
        $id = Auth::user()->id; 
        $datosMedicos = medico::where('cod_users_fk','=',$id)->orderBy('created_at', 'desc')->get();
        $datosFallecidos = fallecimiento::where('cod_users_fk','=',$id)->orderBy('created_at', 'desc')->get();
        $datosMaterPater = MaterPater::where('cod_users_fk','=',$id)->orderBy('created_at', 'desc')->get();
        $datosMedicosG = medicoG::where('cod_users_fk','=',$id)->orderBy('created_at', 'desc')->get();
          $datosPersonales = personal::where('cod_users_fk','=',$id)->orderBy('created_at', 'desc')->get();
           $datosObligacion = obligacionCiudadano::where('cod_users_fk','=',$id)->orderBy('created_at', 'desc')->get();
        
        $empleadoss = empleado::where('cod_empleado','=', $id)->first()->tiempo_disponible;

       
        return view('permisos.verPermisos', compact('id','datosMedicos','datosFallecidos','datosMaterPater','empleadoss','datosMedicosG','datosPersonales','datosObligacion'));
    }

     public function verPermisosAdmin(Request $request)
    {
       $id = Auth::user()->id;
       $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado; 
       if ($cargo == 'Secretaria') { 


       $datosMedicos = medico::all();
       $datosFallecidos = fallecimiento::all();
       $datosMaterPater = MaterPater::all();
       $datosMedicosG = medicoG::all();
        $datosPersonales = personal::all();
         $datosObligacion = obligacionCiudadano::all();
       $empleadoss = empleado::where('cod_empleado','=', $id)->first()->tiempo_disponible;

       return view('permisos.verPermisosAdmin', compact('datosMedicos','datosMaterPater','datosFallecidos','empleadoss','datosMedicosG','datosPersonales','datosObligacion'));

       } else{
        return redirect('/');
       }      
    }


    public function buscador(Request $request)
    {

         $id = user::findOrFail($request->buscarpor1)->name; 

        // dd($request);
       // $id = $request->buscarpor1;

      // $idSolicitud = MaterPater::where('id_solicitud','=',$id)->first()->cod_users_fk;

       //$nombreEmpleado = user::where('id','=',$id)->first()->name;

  $cargoEmpleado = empleado::where('cod_empleado','=',$request->buscarpor1)->first()->cargo_empleado;

        $msm = $id. " con el cargo de: ".$cargoEmpleado;
            
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

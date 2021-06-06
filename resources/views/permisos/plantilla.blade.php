<!DOCTYPE html>
<html>
<head>
	<title> Sistema de Permisos - Inicio</title>
 <link rel="shortcut icon" type="image/png" href="{{ asset('/img/web-design.png') }}">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
</head>

<style type="text/css">
	* {
  box-sizing: border-box;
}

body {
  margin: 0px;
  font-family: 'segoe ui';
}

.nav {
  height: 50px;
  width: 100%;
  background-color: #191970;
  position: relative;
}

.nav > .nav-header {
  display: inline;
}

.nav > .nav-header > .nav-title {
  display: inline-block;
  font-size: 22px;
  color: #fff;
  padding: 10px 10px 10px 10px;
}

.nav > .nav-btn {
  display: none;
}

.nav > .nav-links {
  display: inline;
  float: right;
  font-size: 18px;
}

.nav > .nav-links > a {
  display: inline-block;
  padding: 13px 10px 13px 10px;
  text-decoration: none;
  color: #efefef;
}

.nav > .nav-links > a:hover {
  background-color: rgba(0, 0, 0, 0.3);
}

.nav > #nav-check {
  display: none;
}

@media (max-width:600px) {
  .nav > .nav-btn {
    display: inline-block;
    position: absolute;
    right: 0px;
    top: 0px;
  }
  .nav > .nav-btn > label {
    display: inline-block;
    width: 50px;
    height: 50px;
    padding: 13px;
  }
  .nav > .nav-btn > label:hover,.nav  #nav-check:checked ~ .nav-btn > label {
    background-color: rgba(0, 0, 0, 0.3);
  }
  .nav > .nav-btn > label > span {
    display: block;
    width: 25px;
    height: 10px;
    border-top: 2px solid #eee;
  }
  .nav > .nav-links {
    position: absolute;
    display: block;
    width: 100%;
    background-color: #333;
    height: 0px;
    transition: all 0.3s ease-in;
    overflow-y: hidden;
    top: 50px;
    left: 0px;
  }
  .nav > .nav-links > a {
    display: block;
    width: 100%;
  }
  .nav > #nav-check:not(:checked) ~ .nav-links {
    height: 0px;
  }
  .nav > #nav-check:checked ~ .nav-links {
    height: calc(100vh - 50px);
    overflow-y: auto;
  }
}
</style>

<body>

<div class="nav">
  <input type="checkbox" id="nav-check">
  <div class="nav-header">
    <div class="nav-links">
       
    </div>
  </div>
  <div class="nav-btn">
    <label for="nav-check">
      <span></span>
      <span></span>
      <span></span>
    </label>
  </div>
  
  <div class="nav-links">
    <a href="/" style="color: white; font-size: 20px">Sistema de Permisos</a>
    <a href="/verPermisos" >Mis Permisos</a>

@php
use App\empleado;
  $id = Auth::user()->id;
    $roll = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado; 
    if ($roll == 'Secretaria') {
      $valorrr = '';
    }else{
      $valorrr = 'none';
    }
@endphp
      <a style="display: {{$valorrr}}" href="/verPermisosAdmin" >Ver Permisos Empleados </a>
      

      <a href="#" >Cargo: {{$roll}} </a>



      <a href="/verPermisos" >Horas Disponibles: {{$empleadoss}}</a>

    
<a  href="{{ route('logout') }}"
     onclick="event.preventDefault();
     document.getElementById('logout-form').submit();">
     Salir
</a>

   <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
         @csrf
    </form>

   

  </div>
</div> <br>


@yield('alert')

@yield('contenido')


<!-- Permiso Medico -->
<div class="modal fade" onchange="validateForm(this)" id="ModaPermisoMedico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud para Permiso Medico</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('permiso.store')}}" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <div class="col">
                <div style="display: none">
                  <input type="text" name="IDTipoPermiso" value="Medica">
                </div>

              <div class="form-group">
                <div class="row"> 
                  <div class="col">
                    <label for="exampleInputEmail1">Nombre Solicitante</label>
                    <input type="text" class="form-control" name="NombreEmpleado" placeholder="Ej. Juan Perez" value="{{ Auth::user()->name }}" disabled>  
                  </div>
                  <div class="col">
                    <label>Departamento al que pertenece</label>
                    <select class="custom-select" name="departamentoEmpleado" >
                      @php
                      $id = Auth::user()->id;
                      $departamento = empleado::where('cod_empleado','=',$id)->first()->departamento;
                      @endphp
                      <option selected disabled value="">{{$departamento}}</option>
                    </select>   
                  </div>
                  </div>
                </div>


                <div class="form-group">
                  <div class="row">
                    <div class="col">
                         <label>Jefe Inmediato</label>
                             <select class="custom-select" name="jefeEmpleado" >
                              @php                 
                              $id = Auth::user()->id;
                              $jefe = empleado::where('cod_empleado','=',$id)->first()->jefe_inmediato;
                              @endphp
                              <option selected disabled value="">{{$jefe}}</option>
                            </select>
                    </div>
                    <div class="col">
                      <label for="exampleInputPassword1">Cargo que desempeña en la empresa</label>
                    @php                 
                    $id = Auth::user()->id;
                    $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado;
                    @endphp
                  <input type="text" class="form-control" name="CargoPermiso" value="{{$cargo}}" disabled> </input>
                    </div>                
                  </div>
                </div>

                 <div class="form-group">
                  <div class="row">




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                    <script type="text/javascript">

                     
$( document ).ready(function() {
 f = new Date();
 año = f.getFullYear();
 mes = '' + (f.getMonth()+1);
 dia = '' + f.getDate();

 if (mes.length <2) 
  mes = "0"+mes;  

 if (dia.length < 2)
   dia = "0"+dia;
 fechaNOW = document.getElementById("fechaPermiso").value= año+"-"+mes+"-"+dia;

});

                      function validateForm(inputField) {
                         document.getElementById("btnEnviar").disabled = true;
                        var entrada = $("#horaEntrada").val();
                         var salida = $("#horaSalida").val();
                         var fechaEdit = $("#fechaPermiso").val();
                                               
                              if (fechaEdit < fechaNOW ) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaNOW);
                                fechaNOW = document.getElementById("fechaPermiso").value= año+"-"+mes+"-"+dia;
                              }      

                                     if (entrada) {
                                      if (entrada>salida) {
                                             document.getElementById("btnEnviar").disabled = false;
                                            }else{
                                               document.getElementById("btnEnviar").disabled = true;
                                               alert("La Hora de Entrada tiene que ser mayor que la Hora Salida");
                                               return 0;
                                            }
                                          }else{
                                            document.getElementById("btnEnviar").disabled = false;
                                          }
                      }
                    </script>

                  <div class="col" >
                    <label>Fecha Permiso</label>
                    <input  class="form-control" type="date" name="fechaPermiso" id="fechaPermiso" required="">
                  </div>

                    <div class="col">
                      <label>Hora de Salida</label>
                       <input  max="16:00" min="08:00" class="form-control" type="time" id="horaSalida" name="horaSalida" required>
                    </div>
                    
                    <div class="col">
                      <label>Hora de Entrada</label>
                      <input  max="16:30" min="08:30" class="form-control" type="time" name="horaEntrada" id="horaEntrada">
                    </div>   
            

                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Motivo Permiso</label>
                  <textarea  type="text" class="form-control" name="MotivoPermiso" id="MotivoPermiso" placeholder="Detalles sobre su permiso" required></textarea>
                </div>
                <div class="custom-file">
                <input type="file" id="CustomFile" class="custom-file-input" name="CustomFile" required>
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="submit" id="btnEnviar" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
  </div>
</div>


<!-- Permiso Fallecimiento --> 
<div class="modal fade" onmousemove="validateFormFAL(this)" id="ModaPermisoFallecimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud para Permiso Paternidad/Maternidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('permiso.store')}}" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <div class="col">
                <div style="display: none">
                  <input type="text" name="IDTipoPermiso" value="FA">
                </div>

              <div class="form-group">
                <div class="row"> 
                  <div class="col">
                    <label for="exampleInputEmail1">Nombre Solicitante</label>
                    <input type="text" class="form-control" name="NombreEmpleado" placeholder="Ej. Juan Perez" value="{{ Auth::user()->name }}" disabled>  
                  </div>
                  <div class="col">
                    <label>Departamento al que pertenece</label>
                    <select class="custom-select" name="departamentoEmpleado" >
                      @php
                      $id = Auth::user()->id;
                      $departamento = empleado::where('cod_empleado','=',$id)->first()->departamento;
                      @endphp
                      <option selected disabled value="">{{$departamento}}</option>
                    </select>   
                  </div>
                  </div>
                </div>


                <div class="form-group">
                  <div class="row">
                    <div class="col">
                         <label>Jefe Inmediato</label>
                             <select class="custom-select" name="jefeEmpleado" >
                              @php                 
                              $id = Auth::user()->id;
                              $jefe = empleado::where('cod_empleado','=',$id)->first()->jefe_inmediato;
                              @endphp
                              <option selected disabled value="">{{$jefe}}</option>
                            </select>
                    </div>
                    <div class="col">
                      <label for="exampleInputPassword1">Cargo que desempeña en la empresa</label>
                    @php                 
                    $id = Auth::user()->id;
                    $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado;
                    @endphp
                  <input type="text" class="form-control" name="CargoPermiso" value="{{$cargo}}" disabled> </input>
                    </div>                
                  </div>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                    <script type="text/javascript">
$( document ).ready(function() {
 f = new Date();
 año = f.getFullYear();
 mes = '' + (f.getMonth()+1);
 dia = '' + f.getDate();

 if (mes.length <2) 
  mes = "0"+mes;  

 if (dia.length < 2)
   dia = "0"+dia;
 fechaNOW = document.getElementById("fechaFA").value= año+"-"+mes+"-"+dia;

});

                      function validateFormFAL(inputField) {
                         document.getElementById("btnEnviarFA").disabled = true;
                          file = $("#CustomFileFA").val();
                           motivo = $("#MotivoPermisoFA").val();
                             var fechaFA = $("#fechaFA").val();
                                               
                              if (fechaFA < fechaNOW ) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaNOW);
                                fechaNOW = document.getElementById("fechaFA").value= año+"-"+mes+"-"+dia;
                              }  
  
                                    while(file.length > 0 && motivo.length > 0){
                                      document.getElementById("btnEnviarFA").disabled = false;
                                      break; 
                                    }           
                      }
                    </script>
                  <div class="form-group">

                    <div class="row">
                        <div class="col">
                          <label>Fecha Permiso </label>
                          <input  class="form-control" type="date" name="fechaFA" id="fechaFA">
                          </div>
                    <div class="col"> 
                          <label>Nombre del Fallecido</label>
                          <input  class="form-control" type="text" name="nombreFallecido" required>
                    </div>
                           <div class="col"> 
                    <label>Relacion con la persona</label>
                      <select class="custom-select" name="relacionFallecido" id="relacionFallecido" required>
                      <option selected value="">Seleccione su relación</option>
                      <option>Padre</option>
                      <option>Madre</option>
                      <option>Hijos</option>
                      <option>Conyugue</option>
                    </select> 
                        </div>                      
                    </div>
                  </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Motivo Permiso</label>
                  <textarea  type="text" class="form-control" name="MotivoPermisoFA" id="MotivoPermisoFA" placeholder="Detalles sobre su permiso" required></textarea>
                </div>
                <div class="custom-file">
                <input type="file" id="CustomFileFA" class="custom-file-input" name="CustomFileFA" required>
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div> <br>
          <strong><label style="color: red;">*Al momento de realizar esta solicitud, usted esta pidiendo permiso para un lapso de 3 días consecutivos, por Fallecimiento.</label></strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="submit" id="btnEnviarFA" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
  </div>
</div>

<!-- Permiso Maternidad o Paternidad -->
<div class="modal fade" onmousemove="validateFormPM(this)" id="ModaPermisoMPaternidad" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud para Permiso Paternidad/Maternidad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('permiso.store')}}" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <div class="col">
                <div style="display: none">
                  <input type="text" name="IDTipoPermiso" value="PM">
                </div>

              <div class="form-group">
                <div class="row"> 
                  <div class="col">
                    <label for="exampleInputEmail1">Nombre Solicitante</label>
                    <input type="text" class="form-control" name="NombreEmpleado" placeholder="Ej. Juan Perez" value="{{ Auth::user()->name }}" disabled>  
                  </div>
                  <div class="col">
                    <label>Departamento al que pertenece</label>
                    <select class="custom-select" name="departamentoEmpleado" >
                      @php
                      $id = Auth::user()->id;
                      $departamento = empleado::where('cod_empleado','=',$id)->first()->departamento;
                      @endphp
                      <option selected disabled value="">{{$departamento}}</option>
                    </select>   
                  </div>
                  </div>
                </div>


                <div class="form-group">
                  <div class="row">
                    <div class="col">
                         <label>Jefe Inmediato</label>
                             <select class="custom-select" name="jefeEmpleado" >
                              @php                 
                              $id = Auth::user()->id;
                              $jefe = empleado::where('cod_empleado','=',$id)->first()->jefe_inmediato;
                              @endphp
                              <option selected disabled value="">{{$jefe}}</option>
                            </select>
                    </div>
                    <div class="col">
                      <label for="exampleInputPassword1">Cargo que desempeña en la empresa</label>
                    @php                 
                    $id = Auth::user()->id;
                    $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado;
                    @endphp
                  <input type="text" class="form-control" name="CargoPermiso" value="{{$cargo}}" disabled> </input>
                    </div>                
                  </div>
                </div>

      
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                    <script type="text/javascript">

$( document ).ready(function() {
 f = new Date();
 año = f.getFullYear();
 mes = '' + (f.getMonth()+1);
 dia = '' + f.getDate();

 if (mes.length <2) 
  mes = "0"+mes;  

 if (dia.length < 2)
   dia = "0"+dia;
 fechaNOW = document.getElementById("fechaPMSalida").value= año+"-"+mes+"-"+dia;

});

                      function validateFormPM(inputField) {
                           var fechaPMSalida = $("#fechaPMSalida").val();
                                               
                              if (fechaPMSalida < fechaNOW ) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaNOW);
                                fechaNOW = document.getElementById("fechaPMSalida").value= año+"-"+mes+"-"+dia;
                              }  
                         document.getElementById("btnEnviarPM").disabled = true;
                          file = $("#CustomFilePM").val();
                           motivo = $("#MotivoPermisoPM").val();
  
                                    while(file.length > 0 && motivo.length > 0){
                                      document.getElementById("btnEnviarPM").disabled = false;
                                      break; 
                                    }
                      }
                    </script>


         @php
         use App\MaterPater;

          $id = Auth::user()->id;
          $genero = empleado::findOrFail($id)->sexo;
                if ($genero == "F") {
                    $val = "";
                     $valM = "none";
                    $numDispo = 3;
                }else{
                    $val = "none";
                     $valM = "";
                } 

                if ($genero == "M") {
                    $valM = "";
                    $numDispo = empleado::findOrFail($id)->dispo_materpater; 
                }else{
                    $valM = "none";
                }  
          @endphp
                  <div class="form-group">
                    <div class="row">
                      <div class="col">
                        <label>Fecha Salida </label>
                          <input  class="form-control" type="date" name="fechaPMSalida" id="fechaPMSalida">
                      </div>
                       <div class="col" style="display: {{$valM}}">
                        <label>Cantidad de Días</label>
          <input class="form-control" type="number" value="{{$numDispo}}"  name="cantDias" id="cantDias" max="{{$numDispo}}" min="1" required>
                          <strong><label>Dias Disponibles: {{$numDispo}} </label></strong>
                      </div>
                    </div>
                   
                  </div>
                 
                <div class="form-group">
                  <label for="exampleInputPassword1">Motivo Permiso</label>
                  <textarea  type="text" class="form-control" name="MotivoPermisoPM" id="MotivoPermisoPM" placeholder="Detalles sobre su permiso" required></textarea>
                </div>
                <div class="custom-file">
                <input type="file" id="CustomFilePM" class="custom-file-input" name="CustomFilePM" required>
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div> <br>

         
          <strong><label style="color: red; display: {{$val}}">*Al momento de realizar esta solicitud, usted esta pidiendo permiso para un lapso de 3 meses a partir de la "Fecha Salida" por maternidad.</label></strong>

          <strong><label style="color: red; display: {{$valM}}">*Al momento de realizar esta solicitud, usted esta pidiendo permiso para dias seguidos, si desea tener los 3 dias distribuidos haga citas por separado.</label></strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="submit" id="btnEnviarPM" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
  </div>
</div>

<!-- Permiso Medico Grave -->
<div class="modal fade" onchange="validateFormMEDG(this)" id="ModaPermisoMedicoGrave" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud para Permiso Medico</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('permiso.store')}}" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <div class="col">
                <div style="display: none">
                  <input type="text" name="IDTipoPermiso" value="MedicoG">
                </div>

              <div class="form-group">
                <div class="row"> 
                  <div class="col">
                    <label for="exampleInputEmail1">Nombre Solicitante</label>
                    <input type="text" class="form-control" name="NombreEmpleado" placeholder="Ej. Juan Perez" value="{{ Auth::user()->name }}" disabled>  
                  </div>
                  <div class="col">
                    <label>Departamento al que pertenece</label>
                    <select class="custom-select" name="departamentoEmpleado" >
                      @php
                      $id = Auth::user()->id;
                      $departamento = empleado::where('cod_empleado','=',$id)->first()->departamento;
                      @endphp
                      <option selected disabled value="">{{$departamento}}</option>
                    </select>   
                  </div>
                  </div>
                </div>


                <div class="form-group">
                  <div class="row">
                    <div class="col">
                         <label>Jefe Inmediato</label>
                             <select class="custom-select" name="jefeEmpleado" >
                              @php                 
                              $id = Auth::user()->id;
                              $jefe = empleado::where('cod_empleado','=',$id)->first()->jefe_inmediato;
                              @endphp
                              <option selected disabled value="">{{$jefe}}</option>
                            </select>
                    </div>
                    <div class="col">
                      <label for="exampleInputPassword1">Cargo que desempeña en la empresa</label>
                    @php                 
                    $id = Auth::user()->id;
                    $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado;
                    @endphp
                  <input type="text" class="form-control" name="CargoPermiso" value="{{$cargo}}" disabled> </input>
                    </div>                
                  </div>
                </div>

                 <div class="form-group">
                  <div class="row">




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                    <script type="text/javascript">
$( document ).ready(function() {
 f = new Date();
 año = f.getFullYear();
 mes = '' + (f.getMonth()+1);
 dia = '' + f.getDate();

 if (mes.length <2) 
  mes = "0"+mes;  

 if (dia.length < 2)
   dia = "0"+dia;
 fechaNOW = document.getElementById("fechaPermisoMEDG").value= año+"-"+mes+"-"+dia;

});
                      function validateFormMEDG(inputField) {
                          var fechaPermisoMEDG = $("#fechaPermisoMEDG").val();
                          var fechaEntradaMEDG = $("#fechaEntradaMEDG").val();

                             
                                               
                              if (fechaPermisoMEDG < fechaNOW && fechaPermisoMEDG.length > 0) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaNOW);
                               document.getElementById("fechaPermisoMEDG").value= año+"-"+mes+"-"+dia;
                                return 0;
                              }

                               if (fechaEntradaMEDG < fechaNOW && fechaEntradaMEDG.length > 0) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaPermisoMEDG);
                              document.getElementById("fechaEntradaMEDG").value= "";
                                  document.getElementById("fechaPermisoMEDG").value= "";
                                return 0;
                              }    

                              if (fechaPermisoMEDG > fechaEntradaMEDG && fechaEntradaMEDG.length > 0) {
                                alert("La Fecha tiene que Salida tiene que ser menor a la Fecha Entrada");
                                 document.getElementById("fechaPermisoMEDG").value= "";
                                 document.getElementById("fechaEntradaMEDG").value= "";
                                return 0;
                              }

                         document.getElementById("btnEnviarMEDG").disabled = true;
                          file = $("#CustomFileMEDG").val();
                           motivo = $("#MotivoPermisoMEDG").val();
  
                                    while(file.length > 0 && motivo.length > 0){
                                      document.getElementById("btnEnviarMEDG").disabled = false;
                                      break; 
                                    }            
                      }
                    </script>

                  <div class="col" >
                    <label>Fecha Permiso</label>
                    <input  class="form-control" type="date" name="fechaPermisoMEDG" id="fechaPermisoMEDG" required>
                  </div>

                    <div class="col">
                      <label>Fecha de Entrada</label>
                       <input class="form-control" type="date" id="fechaEntradaMEDG" name="fechaEntradaMEDG" required>
                    </div>

                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Motivo Permiso</label>
                  <textarea  type="text" class="form-control" name="MotivoPermisoMEDG" id="MotivoPermisoMEDG" placeholder="Detalles sobre su permiso" required></textarea>
                </div>
                <div class="custom-file">
                <input type="file" id="CustomFileMEDG" class="custom-file-input" name="CustomFileMEDG" required>
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="submit" id="btnEnviarMEDG" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
  </div>
</div>




<!-- Permiso Personales -->
<div class="modal fade" onchange="validateFormPER(this)" id="ModaPermisoPersonale" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud para Permiso Personal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('permiso.store')}}" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <div class="col">
                <div style="display: none">
                  <input type="text" name="IDTipoPermiso" value="Personal">
                </div>

              <div class="form-group">
                <div class="row"> 
                  <div class="col">
                    <label for="exampleInputEmail1">Nombre Solicitante</label>
                    <input type="text" class="form-control" name="NombreEmpleado" placeholder="Ej. Juan Perez" value="{{ Auth::user()->name }}" disabled>  
                  </div>
                  <div class="col">
                    <label>Departamento al que pertenece</label>
                    <select class="custom-select" name="departamentoEmpleado" >
                      @php
                      $id = Auth::user()->id;
                      $departamento = empleado::where('cod_empleado','=',$id)->first()->departamento;
                      @endphp
                      <option selected disabled value="">{{$departamento}}</option>
                    </select>   
                  </div>
                  </div>
                </div>


                <div class="form-group">
                  <div class="row">
                    <div class="col">
                         <label>Jefe Inmediato</label>
                             <select class="custom-select" name="jefeEmpleado" >
                              @php                 
                              $id = Auth::user()->id;
                              $jefe = empleado::where('cod_empleado','=',$id)->first()->jefe_inmediato;
                              @endphp
                              <option selected disabled value="">{{$jefe}}</option>
                            </select>
                    </div>
                    <div class="col">
                      <label for="exampleInputPassword1">Cargo que desempeña en la empresa</label>
                    @php                 
                    $id = Auth::user()->id;
                    $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado;
                    @endphp
                  <input type="text" class="form-control" name="CargoPermiso" value="{{$cargo}}" disabled> </input>
                    </div>                
                  </div>
                </div>

                 <div class="form-group">
                  <div class="row">




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                    <script type="text/javascript">
$( document ).ready(function() {
 f = new Date();
 año = f.getFullYear();
 mes = '' + (f.getMonth()+1);
 dia = '' + f.getDate();

 if (mes.length <2) 
  mes = "0"+mes;  

 if (dia.length < 2)
   dia = "0"+dia;
 fechaNOW = document.getElementById("fechaPermisoPER").value= año+"-"+mes+"-"+dia;

});
                      function validateFormPER(inputField) {
                          var fechaPermisoPER = $("#fechaPermisoPER").val();
                          var fechaEntradaPER = $("#fechaEntradaPER").val();

                             
                                               
                              if (fechaPermisoPER < fechaNOW && fechaPermisoPER.length > 0) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaNOW);
                               document.getElementById("fechaPermisoPER").value= año+"-"+mes+"-"+dia;
                                return 0;
                              }

                               if (fechaEntradaPER < fechaNOW && fechaEntradaPER.length > 0) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaPermisoPER);
                              document.getElementById("fechaEntradaPER").value= "";
                                  document.getElementById("fechaPermisoPER").value= "";
                                return 0;
                              }    

                              if (fechaPermisoPER > fechaEntradaPER && fechaEntradaPER.length > 0) {
                                alert("La Fecha tiene que Salida tiene que ser menor a la Fecha Entrada");
                                 document.getElementById("fechaPermisoPER").value= "";
                                 document.getElementById("fechaEntradaPER").value= "";
                                return 0;
                              }

                      
                         
  
                                              
                      }
                    </script>

                  <div class="col" >
                    <label>Fecha Permiso</label>
                    <input  class="form-control" type="date" name="fechaPermisoPER" id="fechaPermisoPER" required>
                  </div>

                    <div class="col">
                      <label>Fecha de Entrada</label>
                       <input class="form-control" type="date" id="fechaEntradaPER" name="fechaEntradaPER" required>
                    </div>

                  </div>
                </div>
           
              </div>     
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="submit" id="btnEnviarPER" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
  </div>
</div>





<!-- Permiso Obligacion -->
<div class="modal fade" onchange="validateFormOBL(this)" id="ModaPermisoObligacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud por Obligaciones de Ciudadano</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('permiso.store')}}" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <div class="col">
                <div style="display: none">
                  <input type="text" name="IDTipoPermiso" value="OBL">
                </div>

              <div class="form-group">
                <div class="row"> 
                  <div class="col">
                    <label for="exampleInputEmail1">Nombre Solicitante</label>
                    <input type="text" class="form-control" name="NombreEmpleado" placeholder="Ej. Juan Perez" value="{{ Auth::user()->name }}" disabled>  
                  </div>
                  <div class="col">
                    <label>Departamento al que pertenece</label>
                    <select class="custom-select" name="departamentoEmpleado" >
                      @php
                      $id = Auth::user()->id;
                      $departamento = empleado::where('cod_empleado','=',$id)->first()->departamento;
                      @endphp
                      <option selected disabled value="">{{$departamento}}</option>
                    </select>   
                  </div>
                  </div>
                </div>


                <div class="form-group">
                  <div class="row">
                    <div class="col">
                         <label>Jefe Inmediato</label>
                             <select class="custom-select" name="jefeEmpleado" >
                              @php                 
                              $id = Auth::user()->id;
                              $jefe = empleado::where('cod_empleado','=',$id)->first()->jefe_inmediato;
                              @endphp
                              <option selected disabled value="">{{$jefe}}</option>
                            </select>
                    </div>
                    <div class="col">
                      <label for="exampleInputPassword1">Cargo que desempeña en la empresa</label>
                    @php                 
                    $id = Auth::user()->id;
                    $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado;
                    @endphp
                  <input type="text" class="form-control" name="CargoPermiso" value="{{$cargo}}" disabled> </input>
                    </div>                
                  </div>
                </div>

                 <div class="form-group">
                  <div class="row">




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                    <script type="text/javascript">
$( document ).ready(function() {
 f = new Date();
 año = f.getFullYear();
 mes = '' + (f.getMonth()+1);
 dia = '' + f.getDate();

 if (mes.length <2) 
  mes = "0"+mes;  

 if (dia.length < 2)
   dia = "0"+dia;
 fechaNOW = document.getElementById("fechaPermisoOBL").value= año+"-"+mes+"-"+dia;

});
                      function validateFormOBL(inputField) {
                          var fechaPermisoOBL = $("#fechaPermisoOBL").val();
                          var fechaEntradaOBL = $("#fechaEntradaOBL").val();

                             
                                               
                              if (fechaPermisoOBL < fechaNOW && fechaPermisoOBL.length > 0) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaNOW);
                               document.getElementById("fechaPermisoOBL").value= año+"-"+mes+"-"+dia;
                                return 0;
                              }

                               if (fechaEntradaOBL < fechaNOW && fechaEntradaOBL.length > 0) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaPermisoOBL);
                              document.getElementById("fechaEntradaOBL").value= "";
                                  document.getElementById("fechaPermisoOBL").value= "";
                                return 0;
                              }    

                              if (fechaPermisoOBL > fechaEntradaOBL && fechaEntradaOBL.length > 0) {
                                alert("La Fecha tiene que Salida tiene que ser menor a la Fecha Entrada");
                                 document.getElementById("fechaPermisoOBL").value= "";
                                 document.getElementById("fechaEntradaOBL").value= "";
                                return 0;
                              }

                         document.getElementById("btnEnviarPER").disabled = true;
                         
                           motivo = $("#MotivoPermisoPER").val();
                           file = $("#CustomFilePER").val();
  
                                    while(motivo.length > 0 && file.length > 0){
                                      document.getElementById("btnEnviarPER").disabled = false;
                                      break; 
                                    }            
                      }
                    </script>

                  <div class="col" >
                    <label>Fecha Permiso</label>
                    <input  class="form-control" type="date" name="fechaPermisoOBL" id="fechaPermisoOBL" required>
                  </div>

                    <div class="col">
                      <label>Fecha de Entrada</label>
                       <input class="form-control" type="date" id="fechaEntradaOBL" name="fechaEntradaOBL" required>
                    </div>

                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Motivo Permiso</label>
                  <textarea  type="text" class="form-control" name="MotivoPermisoOBL" id="MotivoPermisoOBL" placeholder="Detalles sobre su permiso" required></textarea>
                </div>
                 <div class="custom-file">
                <input type="file" id="CustomFileOBL" class="custom-file-input" name="CustomFileOBL" required>
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="submit" id="btnEnviarPER" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
  </div>
</div>





</body>
</html>
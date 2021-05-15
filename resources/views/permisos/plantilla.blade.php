<!DOCTYPE html>
<html>
<head>
	<title> Sistema de Permisos - Inicio</title>
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
    <div class="nav-title">
       <a href="/" style="color: white">Sistema de Permisos</a>
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
      <a href="/verPermisos" >Mis Permisos</a>

@php
use App\empleado;
  $id = Auth::user()->id;
    $roll = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado; 
    if ($roll == 'Secretaria') {
      $valor = '';
    }else{
      $valor = 'none';
    }
@endphp
      <a style="display: {{$valor}}" href="/verPermisosAdmin" >Ver Permisos Empleados </a>
      

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
<div class="modal fade " id="ModaPermisoMedico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud para Permiso Medico</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('permiso.store')}}">
            @csrf
          <div class="row">
            <div class="col">
                <div style="display: none">
                  <input type="text" name="IDTipoPermiso" value="Medica">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Nombre Solicitante</label>
                  <input type="text" class="form-control" name="NombreEmpleado" placeholder="Ej. Juan Perez" value="{{ Auth::user()->name }}">
                </div>

                 <div class="form-group">
                 <label>Departamento al que pertenece</label>
                  <select class="custom-select" name="departamentoEmpleado" >
                    @php
                    $id = Auth::user()->id;
                    $departamento = empleado::where('cod_empleado','=',$id)->first()->departamento;
                    @endphp
                    <option selected disabled value="">{{$departamento}}</option>
                  </select>
                </div>

                <div class="form-group">
                 <label>Jefe Inmediato</label>
                  <select class="custom-select" name="jefeEmpleado" >
                    @php                 
                    $id = Auth::user()->id;
                    $jefe = empleado::where('cod_empleado','=',$id)->first()->jefe_inmediato;
                    @endphp
                    <option selected disabled value="">{{$jefe}}</option>
                  </select>
                </div>

                 <div class="form-group">
                  <label for="exampleInputPassword1">Cargo que desempeña en la empresa</label>
                    @php                 
                    $id = Auth::user()->id;
                    $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado;
                    @endphp
                  <input type="text" class="form-control" name="CargoPermiso" value="{{$cargo}}"> </input>
                </div>

                 <div class="form-group">
                 <label>Cantidad de Tiempo</label>
                  <select class="custom-select" name="tiempoEmpleado" >
                    <option selected disabled value="">Seleccionar Rango de Tiempo</option>
                    <option>Todo el día</option>
                    <option>De 8:00 AM a 12:00 MD</option>
                    <option>De 1:00 PM a 5:00 PM</option>
                    <option>Otros (Especifique en el sigueinte campo)</option>
                  </select>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Motivo Permiso</label>
                  <textarea type="text" class="form-control" name="MotivoPermiso"  placeholder="Detalles sobre su permiso"></textarea>
                </div>
                <div class="custom-file">
                <input type="file" class="custom-file-input" name="validatedInputGroupCustomFile" >
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
  </div>
</div>


<!-- Permiso Fallecimiento --> 
<div class="modal fade " id="ModaPermisoFallecimiento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud de Fallecimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('permiso.store')}}">
          @csrf
          <div class="row">
            <div class="col">
              <div style="display: none">
                  <input type="text" name="IDTipoPermiso" value="Fallecimiento">
                </div>
                <div class="form-group">
                  <label>Nombre Empleado</label>
                  <input type="text" class="form-control" name="NombreEmpleado" placeholder="Ej. Juan Perez" value="{{ Auth::user()->name }}">
                </div>
                <div class="form-group">
                  <label>Nombre del Fallecido</label>
                  <input type="text" class="form-control" name="NombreFallecido" placeholder="Ej. Juan Perez">
                </div>
                  <div class="form-group">
                 <label>Relación</label>
                  <select class="custom-select" name="relacionPariente" required>
                    <option selected disabled value="">Seleccionar Relación</option>
                    <option>Padre</option>
                    <option>Madre</option>
                    <option>Hijos</option>
                    <option>Hermanos</option>
                  </select>
                </div>
                <div class="form-group">
                  <label>Motivo Permiso</label>
                  <textarea type="text" class="form-control" name="MotivoPermiso" placeholder="Detalles sobre su permiso"></textarea>
                </div>
                <div class="custom-file">
                <input type="file" class="custom-file-input" id="validatedInputGroupCustomFile" >
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
  </div>
</div>

<!-- Permiso Matrimonio -->
<div class="modal fade " id="ModaPermisoMatrimonio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud para Matrimonio</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('permiso.store')}}">
           @csrf
          <div class="row">
            <div class="col">
               <div style="display: none">
                  <input type="text" name="IDTipoPermiso" value="Matrimonio">
                </div>
                <div class="form-group">
                  <label>Nombre Empleado</label>
                  <input type="text" class="form-control" name="NombreEmpleado" placeholder="Ej. Juan Perez" value="{{ Auth::user()->name }}">
                </div>
                <div class="form-group">
                  <label>Nombre de la pareja</label>
                  <input type="text" class="form-control" name="NombrePareja" placeholder="Ej. Juan Perez">
                </div>
                 <div class="form-group">
                  <label>Fecha del evento</label>
                  <input type="date" class="form-control" name="FechaEvento"  >
                </div>
                <div class="form-group">
                  <label >Motivo Permiso</label>
                  <textarea type="text" class="form-control" name="MotivoPermiso" placeholder="Detalles sobre su permiso"></textarea>
                </div>
                <div class="custom-file">
                <input type="file" class="custom-file-input" id="validatedInputGroupCustomFile" >
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
  </div>
</div>
</body>
</html>
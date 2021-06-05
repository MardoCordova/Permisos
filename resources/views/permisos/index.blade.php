@extends('permisos.plantilla') 



<!DOCTYPE html>
<html>
<head>
	<title>Sistema de Permisos - Inicio</title>
</head>
<body>

@section('alert')

@if (session('datos'))
  <div class="alert alert-success alert-dismissible fade show" role="alert" align="center">
    {{session('datos')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif

@endsection

@section('contenido')
<div class="container-fluid">
	<div class="card-deck">.


  <div class="card">
    <img src="https://img.freepik.com/vector-gratis/persona-frio_23-2148505009.jpg?size=626&ext=jpg" class="card-img-top" height="300px">
    <div class="card-body">
      <h5 class="card-title">Permiso Medico</h5>
      <p class="card-text">Extienda su permiso por cualquier percanse de salud que se le haya presentado, ya sean una enfermeda o algun accidente que no le permita mobilisarse.</p>
      <p class="card-text row justify-content-center">
      	<button class="btn btn-outline-primary" data-toggle="modal" data-target="#ModaPermisoMedico">Obtener</button>
      </p>
    
    </div>
  </div>


  <div class="card">
    <img src="https://img.freepik.com/foto-gratis/cinta-negra-aislada-fondo-blanco_53089-68.jpg?size=626&ext=jpg" class="card-img-top" height="300px">
    <div class="card-body">
      <h5 class="card-title">Permisos Fallecimiento</h5>
      <p class="card-text">Obtenga su permisos por fallecimiento, es necesario que sea un familiar que sea cercano es decir: Papá, Mamá, Hermanos o Hijos.</p>
       <p class="card-text row justify-content-center">
      	<button class="btn btn-outline-primary" data-toggle="modal" data-target="#ModaPermisoFallecimiento">Obtener</button>
      </p>
    
    </div>
  </div>

  



  @php
  use App\empleado;
   $id = Auth::user()->id;
  $dias = empleado::findOrFail($id)->dispo_materpater;
  if ($dias == 0) {
    $msms = "none";
    $ver ="";
  }else{
    $msms = "";
    $ver = "none";
  }
  @endphp
  <div class="card">
    <img src="https://image.freepik.com/vector-gratis/ilustracion-color-plano-momentos-felices-familiares-cuidado-ninos-paternidad-primeros-pasos-bebe-joven-madre-padre-e-hijo-personajes-dibujos-animados-2d-interior-sala-estar-fondo_151150-3669.jpg" height="300px">
    <div class="card-body">
      <h5 class="card-title">Permiso Maternidad o Paternidad </h5>
      <p class="card-text">Solicite su permisos de materniadad  o paternidad, segun sea su genero se aplicaran las horas en las cuales usted estara solicitando el permiso</p>
       <p class="card-text row justify-content-center">
       <strong><label style=" color: red; display: {{$ver}}">Alcanzo el limite de 3 Días Disponibles</label></strong> 
      	<button style="display: {{$msms}}" class="btn btn-outline-primary" data-toggle="modal" data-target="#ModaPermisoMPaternidad">Obtener</button>
      </p>
     
    </div>
  </div>
</div> <br>




<div class="card-deck">
   <div class="card">
    <img src="https://img.freepik.com/vector-gratis/agente-seguros-resolviendo-accidente-automovilistico_53876-43055.jpg?size=626&ext=jpg" height="300px">
    <div class="card-body">
      <h5 class="card-title">Permiso Medico Grave </h5>
      <p class="card-text">Solicite su permisos de materniadad  o paternidad, segun sea su genero se aplicaran las horas en las cuales usted estara solicitando el permiso</p>
       <p class="card-text row justify-content-center">
       
        <button class="btn btn-outline-primary" data-toggle="modal" data-target="#ModaPermisoMedicoGrave">Obtener</button>
      </p>
     
    </div>
  </div>


   <div class="card">
    <img src="https://img.freepik.com/free-vector/illustration-document-icon_53876-28510.jpg?size=626&ext=jpg" height="300px">
    <div class="card-body">
      <h5 class="card-title"> Permisos Personales</h5>
      <p class="card-text">Solicite su permisos personales sobre cualquier percance o inconveniente que usted este pasando sin necesidad de presentar una evidencia.</p>
       <p class="card-text row justify-content-center">
       
        <button  class="btn btn-outline-primary" data-toggle="modal" data-target="#ModaPermisoPersonale">Obtener</button>
      </p>
     
    </div>
  </div>



   <div class="card">
    <img src="http://www.cpsanjosellanera.es/web/wp-content/uploads/2020/10/VOTACI%C3%93N.jpg" height="300px">
    <div class="card-body">
      <h5 class="card-title">Permisos por Obligaciónes Ciudadana</h5>
      <p class="card-text">Solicite su permisos por obligacion ciudadana, por cualquier evento que requiera hacer de su presencia de manera legal</p>
       <p class="card-text row justify-content-center">
       
        <button  class="btn btn-outline-primary" data-toggle="modal" data-target="#ModaPermisoObligacion">Obtener</button>
      </p>
     
    </div>
  </div>






</div>
</div>



@endsection


</body>
</html>
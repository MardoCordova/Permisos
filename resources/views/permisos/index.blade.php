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
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
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
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>


  <div class="card">
    <img src="https://image.freepik.com/vector-gratis/novia-novio-que-casan_23-2148411572.jpg" height="300px">
    <div class="card-body">
      <h5 class="card-title">Permiso Matrimonio </h5>
      <p class="card-text">Solicite su permisos matrimonial ya sea civil o religioso con dos días sin goce de sueldo segun la ley establecidad.</p>
       <p class="card-text row justify-content-center">
      	<button class="btn btn-outline-primary" data-toggle="modal" data-target="#ModaPermisoMatrimonio">Obtener</button>
      </p>
      <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
    </div>
  </div>


</div>
</div>
@endsection


</body>
</html>
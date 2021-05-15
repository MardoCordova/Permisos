@extends('permisos.plantilla')



@section('contenido')


<div class="container-fluid">
	<div class="col">
	<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
      <th scope="col">Tiempo de permiso</th>
      <th scope="col">Fecha Emisión</th>
      <th scope="col">Estado</th>
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
  	@foreach($datos as $item)
    <tr>
      <th>{{$item->id_solicitud}}</th>
      <td>{{$item->motivo_permiso}}</td>
      <td>{{$item->tiempo_permiso}}</td>
      <td>{{$item->created_at}}</td>
      <td>{{$item->estado_revision}}</td>
      <td><button class="btn btn-success">Modificar</button></td>
       <td><button class="btn btn-danger">Eliminar</button></td>
    </tr>
    @endforeach
  </tbody>
</table>

	</div>

</div>



@endsection
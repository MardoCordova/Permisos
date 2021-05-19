@extends('permisos.plantilla')



@section('contenido')


<div class="container-fluid">
	<div class="col">
	<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
      <th scope="col">Hora Salida</th>
      <th scope="col">Hora Entrada</th>
      <th scope="col">Fecha Emisión</th>
      <th scope="col">Estado</th>
      <th scope="col">Evidencia</th>
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
   
      
   
  	@foreach($datos as $item)
     <form method="POST" action="{{route('permiso.destroy', $item->id_solicitud)}}">
      @csrf
      @method('DELETE')
    <tr>
      <th>{{$item->id_solicitud}}</th>
      <td>{{$item->motivo_permiso}}</td>
       <td>{{$item->hora_salida}}</td>
        <td>{{$item->hora_entrada}}</td>
      <td>{{$item->created_at}}</td>
      <td>{{$item->estado_revision}}</td>
      <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>
      <td><a type="button"  class="btn btn-success" >Modificar</a></td>

      @if($item->estado_revision == "PENDIENTE" )
       <td><button  type="submit" class="btn btn-danger"></i>Eliminar</button></td>
       @endif

    </tr>
      </form>
    @endforeach

  </tbody>
</table>

	</div>

</div>

</form>

@endsection
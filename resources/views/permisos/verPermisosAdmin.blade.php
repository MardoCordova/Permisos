@extends('permisos.plantilla')



@section('contenido')
<div class="container-fluid">
<form class="form-inline" action="/test" id="form1">
  @csrf
    <input style="display: none" id="buscarpor" name="buscarpor1" class="form-control mr-sm-2" type="search" placeholder="Buscar por ID Solicitud" aria-label="Buscar">
  <button style="display: none" class="btn btn-outline-success my-2 my-sm-0" type="button" id="enviar" name="enviar">Buscar Empleado</button>
</form>
</div> <br><br>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script type="text/javascript">


$('#enviar').click(function(event) {  
 
$.ajax({
  url: '/test',
  method: 'POST',
  data: $("#form1").serialize()
})
.done(function(res) {
  alert(res);
 //$('#respuesta').html(res);
})
.fail(function() {
  console.log("error");
})
.always(function() {
  console.log("complete");
});

});

function moverDatos(a) {
  var id = a.id;
  $('#buscarpor').val(id);
  $('#enviar').trigger('click');
}

</script>


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
  <form method="POST" >
    @csrf
      @method('GET')
  <tbody>
  
  	 @foreach ($datos as $item ) 
    <tr onclick="moverDatos(this)" id="{{$item->id_solicitud}}">
      <th>{{$item->id_solicitud}}</th>  
      <td>{{$item->motivo_permiso}}</td>
      <td>{{$item->tiempo_permiso}}</td>
      <td>{{$item->created_at}}</td>
      <td>{{$item->estado_revision}}</td>
      <td><a href="{{route('permiso.show', $item->id_solicitud)}}" type="button" class="btn btn-success">Aceptar</a></td>


       <td><a href="{{route('permiso.edit', $item->id_solicitud)}}" type="button"  class="btn btn-danger">Rechazar</a></td>
    </tr>
    @endforeach
 
  </tbody>
  </form>
</table>

	</div>

</div>

<div id="respuesta" class="container-fluid">
  
</div>




@endsection
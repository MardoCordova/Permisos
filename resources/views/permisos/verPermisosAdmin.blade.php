@extends('permisos.plantilla')



@section('contenido')
<div class="container-fluid">
<form class="form-inline" action="/test" id="form1">
  @csrf
    <input style="display: none" id="buscarpor" name="buscarpor1" class="form-control mr-sm-2" type="search" placeholder="Buscar por ID Solicitud" aria-label="Buscar">
  <button style="display: none" class="btn btn-outline-success my-2 my-sm-0" type="button" id="enviar" name="enviar">Buscar Empleado</button>
</form>
</div> 

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

  @php
$contMedicos = count($datosMedicos);
if ($contMedicos>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
  <label style="display: {{$val}}"><h3>Permisos Medicos</h3></label>
	<div style="display: {{$val}}" class="col">
	<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
      <th scope="col">Hora Salida</th>
      <th scope="col">Hora Entrada</th>
      <th scope="col">Fecha Permiso</th>
      <th scope="col">Fecha Emisión</th>
      <th scope="col">Estado</th>
      <th scope="col">Evidencia</th>
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <form method="POST" >
    @csrf
      @method('GET')
 <tbody >
  	 @foreach ($datosMedicos as $item ) 
    <tr onclick="moverDatos(this)" id="{{$item->cod_users_fk}}">
      <th>{{$item->id_solicitud}}</th>  
      <td>{{$item->motivo_permiso}}</td>
      <td>{{$item->hora_salida}}</td>
      <td>{{$item->hora_entrada}}</td>
      <td>{{$item->fecha_permiso}}</td>
      <td>{{$item->created_at}}</td>
      <td>{{$item->estado_revision}}</td>
       <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>
      <td><a href="{{route('permiso.show', $item->id_solicitud)}}" type="button" class="btn btn-success">Aceptar</a></td>


       <td><a href="{{route('permiso.edit', $item->id_solicitud)}}" type="button"  class="btn btn-danger">Rechazar</a></td>
    </tr>
    @endforeach
 
</tbody>
  </form>
</table>
  </div>


@php
$contFallecidos = count($datosFallecidos);
if ($contFallecidos>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
  <label style="display: {{$val}}"><h3>Permisos Fallecidos</h3></label>
<div style="display: {{$val}}" class="col">
  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
      <th scope="col">Hora Salida</th>
      <th scope="col">Hora Entrada</th>
      <th scope="col">Fecha Permiso</th>
      <th scope="col">Fecha Emisión</th>
      <th scope="col">Estado</th>
      <th scope="col">Evidencia</th>
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <form method="POST" >
    @csrf
      @method('GET')

<tbody style="display: {{$val}}">
     @foreach ($datosFallecidos as $item ) 
    <tr onclick="moverDatos(this)" id="{{$item->cod_users_fk}}">
      <th>{{$item->id_solicitud}}</th>  
      <td>{{$item->motivo_permiso}}</td>
        @php

            $de = new DateTime($item->fecha_permiso);
            $newDate = $de->format('d-M-Y');

            $dr = new DateTime($item->created_at);
            $newDateCreated = $dr->format('d-M-Y');

            $dt =Carbon\Carbon::parse($item->fecha_permiso);
            $dateCarbon = $dt->addDays(2)->format('d-M-Y');
          @endphp
      <td>{{$newDate}}</td>
      <td>{{$dateCarbon}}</td>
      <td>{{$newDateCreated}}</td>
      <td>{{$item->estado_revision}}</td>
       <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>
      <td><a href="{{route('permiso.show', $item->id_solicitud)}}" type="button" class="btn btn-success">Aceptar</a></td>


       <td><a href="{{route('permiso.edit', $item->id_solicitud)}}" type="button"  class="btn btn-danger">Rechazar</a></td>
    </tr>
    @endforeach
 
</tbody>
  </form>
</table>
  </div>





  @php
$contMaterPater = count($datosMaterPater);
if ($contMaterPater>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
  <label style="display: {{$val}}"><h3>Permisos Matrimonio/Paternidad</h3></label>
<div style="display: {{$val}}" class="col">
  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
      <th scope="col">Hora Salida</th>
      <th scope="col">Hora Entrada</th>
      <th scope="col">Fecha Permiso</th>
     
      <th scope="col">Estado</th>
      <th scope="col">Evidencia</th>
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <form method="POST" >
    @csrf
      @method('GET')
<tbody style="display: {{$val}}">
     @foreach ($datosMaterPater as $item ) 
    <tr onclick="moverDatos(this)" id="{{$item->cod_users_fk}}">
      <th>{{$item->id_solicitud}}</th>  
      <td>{{$item->motivo_permiso}}</td>
          @php

            $de = new DateTime($item->fecha_salida);
            $newDate = $de->format('d-M-Y');

            $dr = new DateTime($item->created_at);
            $newDateCreated = $dr->format('d-M-Y');

            $dt =Carbon\Carbon::parse($item->fecha_entrada);
            $dateCarbon = $dt->format('d-M-Y');
          @endphp
      <td>{{$newDate}}</td>
      <td>{{$dateCarbon}}</td>
      <td>{{ $newDateCreated}}</td>
      <td>{{$item->estado_revision}}</td>
       <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>
      <td><a href="{{route('permiso.show', $item->id_solicitud)}}" type="button" class="btn btn-success">Aceptar</a></td>


       <td><a href="{{route('permiso.edit', $item->id_solicitud)}}" type="button"  class="btn btn-danger">Rechazar</a></td>
    </tr>
    @endforeach
  </tbody>
  </form>
</table>
	</div> 



  @php
$contMedicosG = count($datosMedicosG);
if ($contMedicosG>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
  <label style="display: {{$val}}"><h3>Permisos Medico Grave</h3></label>
<div style="display: {{$val}}" class="col">
  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
      <th scope="col">Fecha Salida</th>
      <th scope="col">Fecha Entrada</th>
      <th scope="col">Fecha Emisión</th>
      <th scope="col">Estado</th>
      <th scope="col">Evidencia</th>
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <form method="POST" >
    @csrf
      @method('GET')
<tbody style="display: {{$val}}">
     @foreach ($datosMedicosG as $item ) 
    <tr onclick="moverDatos(this)" id="{{$item->cod_users_fk}}">
      <th>{{$item->id_solicitud}}</th>  
      <td>{{$item->motivo_permiso}}</td>
          @php

            $de = new DateTime($item->fecha_salida);
            $newDate = $de->format('d-M-Y');

            $dr = new DateTime($item->fecha_entrada);
            $newDateCreated = $dr->format('d-M-Y');

            $dt =Carbon\Carbon::parse($item->created_at);
            $dateCarbon = $dt->format('d-M-Y');
          @endphp
      <td>{{$newDate}}</td>
      <td>{{$newDateCreated}}</td>
      <td>{{ $dateCarbon}}</td>
      <td>{{$item->estado_revision}}</td>
       <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>
      <td><a href="{{route('permiso.show', $item->id_solicitud)}}" type="button" class="btn btn-success">Aceptar</a></td>


       <td><a href="{{route('permiso.edit', $item->id_solicitud)}}" type="button"  class="btn btn-danger">Rechazar</a></td>
    </tr>
    @endforeach
  </tbody>
  </form>
</table>
  </div> 

  @php
$contPER = count($datosPersonales);
if ($contPER>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
  <label style="display: {{$val}}"><h3>Permisos Personales</h3></label>
<div style="display: {{$val}}" class="col">
  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
      <th scope="col">Fecha Salida</th>
      <th scope="col">Fecha Entrada</th>
      <th scope="col">Fecha Emisión</th>
      <th scope="col">Estado</th>
      <th scope="col">Evidencia</th>
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <form method="POST" >
    @csrf
      @method('GET')
<tbody style="display: {{$val}}">
     @foreach ($datosPersonales as $item ) 
    <tr onclick="moverDatos(this)" id="{{$item->cod_users_fk}}">
      <th>{{$item->id_solicitud}}</th>  
      <td>{{$item->motivo_permiso}}</td>
          @php

            $de = new DateTime($item->fecha_salida);
            $newDate = $de->format('d-M-Y');

            $dr = new DateTime($item->fecha_entrada);
            $newDateCreated = $dr->format('d-M-Y');

            $dt =Carbon\Carbon::parse($item->created_at);
            $dateCarbon = $dt->format('d-M-Y');
          @endphp
      <td>{{$newDate}}</td>
      <td>{{$newDateCreated}}</td>
      <td>{{ $dateCarbon}}</td>
      <td>{{$item->estado_revision}}</td>
       <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>
      <td><a href="{{route('permiso.show', $item->id_solicitud)}}" type="button" class="btn btn-success">Aceptar</a></td>


       <td><a href="{{route('permiso.edit', $item->id_solicitud)}}" type="button"  class="btn btn-danger">Rechazar</a></td>
    </tr>
    @endforeach
  </tbody>
  </form>
</table>
  </div> 


@php
$contOBL = count($datosObligacion);
if ($contOBL>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
  <label style="display: {{$val}}"><h3>Permisos por Obligacion Ciudadana</h3></label>
<div style="display: {{$val}}" class="col">
  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
      <th scope="col">Fecha Salida</th>
      <th scope="col">Fecha Entrada</th>
      <th scope="col">Fecha Emisión</th>
      <th scope="col">Estado</th>
      <th scope="col">Evidencia</th>
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <form method="POST" >
    @csrf
      @method('GET')
<tbody style="display: {{$val}}">
     @foreach ($datosObligacion as $item ) 
    <tr onclick="moverDatos(this)" id="{{$item->cod_users_fk}}">
      <th>{{$item->id_solicitud}}</th>  
      <td>{{$item->motivo_permiso}}</td>
          @php

            $de = new DateTime($item->fecha_salida);
            $newDate = $de->format('d-M-Y');

            $dr = new DateTime($item->fecha_entrada);
            $newDateCreated = $dr->format('d-M-Y');

            $dt =Carbon\Carbon::parse($item->created_at);
            $dateCarbon = $dt->format('d-M-Y');
          @endphp
      <td>{{$newDate}}</td>
      <td>{{$newDateCreated}}</td>
      <td>{{ $dateCarbon}}</td>
      <td>{{$item->estado_revision}}</td>
       <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>
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
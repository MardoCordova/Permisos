@extends('permisos.plantilla')



@section('contenido')

<div class="container-fluid">

  <div class="row">
    <div class="col-2">
      <a class="btn btn-success" href="/imprimir" type="button" >Imprimir Historial Completo </a>  
    </div>
    <div class="col-3">
      <form method="POST" action="{{route('permisoo.imprimirID')}}">
        @csrf
      <input  name="idSoli" class="form-control" type="search" placeholder="Buscar por ID Solicitud" aria-label="Buscar"> <br>
      <button class="btn btn-success" type="submit" >Imprimir Solicitud</button>
      </form>
    </div>
  </div>
</div>
 <br>




@php
$contMedicos = count($datosMedicos);
if ($contMedicos>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
<div class="accordion" id="accordionExample">
  <div class="card">
    <div class="card-header" id="headingOne"  style="display: {{$val}}">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
         <h3>Permisos Medicos</h3>
        </button>
      </h2>
    </div>
    <div  style="display: {{$val}}" id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
      <div class="card-body"> 
<!-- MEDICO -->
<div class="container-fluid">
  <label style="display: {{$val}}"></label>
  <div class="col" style="display: {{$val}}">
  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
      <th scope="col">Hora Salida</th>
      <th scope="col">Hora Entrada</th>
         <th scope="col">Fecha Solicitante</th>
      <th scope="col">Fecha Emisión</th>
      <th scope="col">Estado</th>
      <th scope="col">Evidencia</th>
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach($datosMedicos as $item)
     <form method="POST" action="{{route('permiso.destroy', $item->id_solicitud)}}">
      @csrf
      @method('DELETE')
    <tr>
      <th>{{$item->id_solicitud}}</th>
      <td>{{$item->motivo_permiso}}</td>
       <td>{{$item->hora_salida}}</td>
        <td>{{$item->hora_entrada}}</td>

          @php
            $de = new DateTime($item->fecha_permiso);
            $newDate = $de->format('d-m-y');

            $dr = new DateTime($item->created_at);
            $newDateCreated = $dr->format('d-m-y');
          @endphp

      <td>{{$newDate}}</td>
      <td>{{$newDateCreated}}</td>
      <td>{{$item->estado_revision}}</td>
      <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>

     

      @if($item->estado_revision == "PENDIENTE" )
      <td><a  href="{{route('permisoo.edit', $item->id_solicitud)}}" class="btn btn-success"  
              >Modificar</a></td>

      
       <td><button  type="submit" class="btn btn-danger"></i>Eliminar</button></td>
       @endif

    </tr>
      </form>
    @endforeach

  </tbody>
</table>
  </div> 

      </div>
    </div>
  </div>

  @php
$contFallecidos = count($datosFallecidos);
if ($contFallecidos>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
  <div class="card">
    <div class="card-header" id="headingTwo" style="display: {{$val}}">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
         <h3>Permisos Fallecidos</h3>
        </button>
      </h2>
    </div>
    <div style="display: {{$val}}" id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#headingTwo">
      <div class="card-body">
  <label style="display: {{$val}}"></label>
  <div class="col" style="display: {{$val}}">
  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
       <th scope="col">Persona Fallecida</th>
        <th scope="col">Relacion Persona</th>
         <th scope="col">Fecha Solicitante</th>
          <th scope="col">Fecha Final</th>
      <th scope="col">Fecha Emisión</th>
      <th scope="col">Estado</th>
      <th scope="col">Evidencia</th>
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach($datosFallecidos as $item)
     <form method="POST" action="{{route('permiso.destroy', $item->id_solicitud)}}">
      @csrf
      @method('DELETE')
    <tr>
      <th>{{$item->id_solicitud}}</th>
        <td>{{$item->motivo_permiso}}</td>
            <td>{{$item->nombre_fallecido}}</td>
        <td>{{$item->relacion_fallecido}}</td>
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
      @if($item->estado_revision == "PENDIENTE" )
      <td><a  href="{{route('permisoo.edit', $item->id_solicitud)}}" class="btn btn-success"  
              >Modificar</a></td>
      
       <td><button  type="submit" class="btn btn-danger"></i>Eliminar</button></td>
       @endif
    </tr>
      </form>
    @endforeach
  </tbody>
</table>
  </div> 
      </div>
    </div>
  </div>





  @php
$contMaterPater = count($datosMaterPater);
if ($contMaterPater>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
  <div class="card">
    <div class="card-header" id="headingThree" style="display: {{$val}}">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          <h3>Permisos Maternidad o Paternidad</h3>
        </button>
      </h2>
    </div>
    <div style="display: {{$val}}" id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#headingThree">
      <div class="card-body">
       


 <label style="display: {{$val}}"></label>
  <div class="col" style="display: {{$val}}">
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
  <tbody>
    @foreach($datosMaterPater as $item)
     <form method="POST" action="{{route('permiso.destroy', $item->id_solicitud)}}">
      @csrf
      @method('DELETE')
    <tr>
      <th>{{$item->id_solicitud}}</th>
      <td>{{$item->motivo_permiso}}</td>

          @php
            $de = new DateTime($item->fecha_salida);
            $newDate = $de->format('d-M-Y');

            $de2 = new DateTime($item->fecha_entrada);
            $newDate2 = $de2->format('d-M-Y');

            $dr = new DateTime($item->created_at);
            $newDateCreated = $dr->format('d-M-Y');
          @endphp

      <td>{{$newDate}}</td>
       <td>{{$newDate2}}</td>
      <td>{{$newDateCreated}}</td>
      <td>{{$item->estado_revision}}</td>
      <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>
      @if(App\MaterPater::where('cod_users_fk','=',$id)->count() >= 1 && $item->estado_revision == "PENDIENTE"  ) 
      <td><a  href="{{route('permisoo.edit', $item->id_solicitud)}}" class="btn btn-success"  
              >Modificar</a></td>
              @endif


          
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
    </div>
  </div>



@php
$contMedicoG = count($datosMedicosG);
if ($contMedicoG>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
<div class="accordion" id="accordionExample12">
  <div class="card">
    <div class="card-header" id="headingOne"  style="display: {{$val}}">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#asddd" aria-expanded="true" aria-controls="asddd">
         <h3>Permisos Medicos Graves</h3>
        </button>
      </h2>
    </div>
    <div  style="display: {{$val}}" id="asddd" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample12">
      <div class="card-body"> 
<!-- MEDICO GRAVE -->
<div class="container-fluid">
  <label style="display: {{$val}}"></label>
  <div class="col" style="display: {{$val}}">
  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
         <th scope="col">Fecha Solicitante</th>
      <th scope="col">Fecha Final</th>
      <th scope="col">Fecha Emision</th>
      <th scope="col">Estado</th>
      <th scope="col">Evidencia</th>
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach($datosMedicosG as $item)
     <form method="POST" action="{{route('permiso.destroy', $item->id_solicitud)}}">
      @csrf
      @method('DELETE')
    <tr>
      <th>{{$item->id_solicitud}}</th>
      <td>{{$item->motivo_permiso}}</td>
          @php
            $de = new DateTime($item->fecha_salida);
            $newDate = $de->format('d-M-Y');

            $dr = new DateTime($item->fecha_entrada);
            $newDateCreated = $dr->format('d-M-Y');

            $df = new DateTime($item->created_at);
            $created_at = $df->format('d-M-Y');
          @endphp

      <td>{{$newDate}}</td>
      <td>{{$newDateCreated}}</td>
      <td>{{$created_at}}</td>
      <td>{{$item->estado_revision}}</td>
      <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>

     

      @if($item->estado_revision == "PENDIENTE" )
      <td><a  href="{{route('permisoo.edit', $item->id_solicitud)}}" class="btn btn-success"  
              >Modificar</a></td>

      
       <td><button  type="submit" class="btn btn-danger"></i>Eliminar</button></td>
       @endif

    </tr>
      </form>
    @endforeach

  </tbody>
</table>
  </div> 

      </div>
    </div>
  </div>








@php
$contPersonales = count($datosPersonales);
if ($contPersonales>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
<div class="accordion" id="accordionExample2">
  <div class="card">
    <div class="card-header" id="headingOne"  style="display: {{$val}}">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#qwe" aria-expanded="true" aria-controls="qwe">
         <h3>Permisos Personales</h3>
        </button>
      </h2>
    </div>
    <div  style="display: {{$val}}" id="qwe" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample2">
      <div class="card-body"> 
<!-- Personal -->
<div class="container-fluid">
  <label style="display: {{$val}}"></label>
  <div class="col" style="display: {{$val}}">
  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
     
         <th scope="col">Fecha Solicitante</th>
      <th scope="col">Fecha Final</th>
      <th scope="col">Fecha Emision</th>
      <th scope="col">Estado</th>
     
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach($datosPersonales as $item)
     <form method="POST" action="{{route('permiso.destroy', $item->id_solicitud)}}">
      @csrf
      @method('DELETE')
    <tr>
      <th>{{$item->id_solicitud}}</th>
    
          @php
            $de = new DateTime($item->fecha_salida);
            $newDate = $de->format('d-M-Y');

            $dr = new DateTime($item->fecha_entrada);
            $newDateCreated = $dr->format('d-M-Y');

            $df = new DateTime($item->created_at);
            $created_at = $df->format('d-M-Y');
          @endphp

      <td>{{$newDate}}</td>
      <td>{{$newDateCreated}}</td>
      <td>{{$created_at}}</td>
      <td>{{$item->estado_revision}}</td>
      

     

      @if($item->estado_revision == "PENDIENTE" )
      <td><a  href="{{route('permisoo.edit', $item->id_solicitud)}}" class="btn btn-success"  
              >Modificar</a></td>

      
       <td><button  type="submit" class="btn btn-danger"></i>Eliminar</button></td>
       @endif

    </tr>
      </form>
    @endforeach

  </tbody>
</table>
  </div> 

      </div>
    </div>
  </div>





@php
$contOBL = count($datosObligacion);
if ($contOBL>0) {
  $val = '';
}else{
  $val = 'none';
}
@endphp
<div class="accordion" id="asd">
  <div class="card">
    <div class="card-header" id="headingOne"  style="display: {{$val}}">
      <h2 class="mb-0">
        <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#ert" aria-expanded="true" aria-controls="ert">
         <h3>Permisos por Obligacion Ciudadana</h3>
        </button>
      </h2>
    </div>
    <div  style="display: {{$val}}" id="ert" class="collapse show" aria-labelledby="headingOne" data-parent="#asd">
      <div class="card-body"> 
<!-- Personal -->
<div class="container-fluid">
  <label style="display: {{$val}}"></label>
  <div class="col" style="display: {{$val}}">
  <table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">ID Solicitud</th>
      <th scope="col">Motivo</th>
         <th scope="col">Fecha Solicitante</th>
      <th scope="col">Fecha Final</th>
      <th scope="col">Fecha Emision</th>
      <th scope="col">Estado</th>
        <th scope="col">Evidencia</th>
     
       <th scope="col"></th>
        <th scope="col"></th>
    </tr>
  </thead>
  <tbody>
    @foreach($datosObligacion as $item)
     <form method="POST" action="{{route('permiso.destroy', $item->id_solicitud)}}">
      @csrf
      @method('DELETE')
    <tr>
      <th>{{$item->id_solicitud}}</th>
      <td>{{$item->motivo_permiso}}</td>
          @php
            $de = new DateTime($item->fecha_salida);
            $newDate = $de->format('d-M-Y');

            $dr = new DateTime($item->fecha_entrada);
            $newDateCreated = $dr->format('d-M-Y');

            $df = new DateTime($item->created_at);
            $created_at = $df->format('d-M-Y');
          @endphp

      <td>{{$newDate}}</td>
      <td>{{$newDateCreated}}</td>
      <td>{{$created_at}}</td>
      <td>{{$item->estado_revision}}</td>
      <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>
      

     

      @if($item->estado_revision == "PENDIENTE" )
      <td><a  href="{{route('permisoo.edit', $item->id_solicitud)}}" class="btn btn-success"  
              >Modificar</a></td>

      
       <td><button  type="submit" class="btn btn-danger"></i>Eliminar</button></td>
       @endif

    </tr>
      </form>
    @endforeach

  </tbody>
</table>
  </div> 

      </div>
    </div>
  </div>






</div>

</div>

</form>

@endsection
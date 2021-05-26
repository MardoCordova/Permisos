
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<div class="container-fluid">

	<h1>Historial de Solicitud de Permisos</h1> <br>
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
	    <tr>
	      <th>{{$item->id_solicitud}}</th>
	      <td>{{$item->motivo_permiso}}</td>
	       <td>{{$item->hora_salida}}</td>
	        <td>{{$item->hora_entrada}}</td>
	      <td>{{$item->created_at}}</td>
	      <td>{{$item->estado_revision}}</td>
	      <td> <a href='/storage/{{$item->id_solicitud}}'>Ver PDF</a></td>
	    </tr>   
	    @endforeach
	  </tbody>
	</table>
	</div>
</div>

</form>


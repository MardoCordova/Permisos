
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>


<style type="text/css">
	.colorText{
		color: #0B779A;
	}	
</style>

<div class="container-fluid">

	<h3 class="colorText">Constancia de Solicitud de Permiso - {{$idSoli->id_solicitud}}</h3> <br>
		
<div class="col">
	<strong><h5 class="colorText">ID Solicitud</h5></strong> 
	<label>{{$idSoli->id_solicitud}}</label>
</div> 

<div class="col">
	<strong><h5 class="colorText">Motivo</h5></strong> 
	<label>{{$idSoli->motivo_permiso}}</label>
</div>

<div class="col">
	<strong><h5 class="colorText">Fecha Salida</h5></strong> 
	<label>{{$idSoli->fecha_salida}}</label>
</div>

<div class="col">
	<strong><h5 class="colorText">Fecha Entrada</h5></strong> 
	<label>{{$idSoli->fecha_entrada}}</label>
</div>


<div class="col">
	<strong><h5 class="colorText">Fecha Emisión de la Solicitud</h5></strong> 
	<label>{{$idSoli->created_at}}</label>
</div>

<div class="col">
	<strong><h5 class="colorText">Fecha Emisión de la Constancia</h5></strong> 
	<label>@php
	date_default_timezone_set('America/El_Salvador');
	$DateAndTime = date('m-d-Y h:i a', time());  
    echo $DateAndTime;
			@endphp
	</label>
</div>

<div class="row "> 
	<div class="float-right">
		<img src="https://upload.wikimedia.org/wikipedia/commons/4/4e/Firma_digital_Jonnatan_Molina_Yanez.png" width="150px" height="100px" >		
	</div>
</div>

</div>

</form>


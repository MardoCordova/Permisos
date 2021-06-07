@extends('permisos.plantilla')



@section('contenido')

<!-- Editar Solicitud -->


<form method="POST" action="{{route('permisoo.update', $estado->id_solicitud)}}">
  @method('PUT')
  @csrf
    <div class="container" onchange="validateFormEdit(this)">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud para Permiso Medico</h5>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('permiso.store')}}" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <div class="col">
                <div style="display: none">
                  <input type="text" name="IDTipoPermiso" value="Medica">
                </div>

              <div class="form-group">
                <div class="row"> 
                  <div class="col">
                    <label for="exampleInputEmail1">Nombre Solicitante</label>
                    <input type="text" class="form-control" name="NombreEmpleado" placeholder="Ej. Juan Perez" value="{{ Auth::user()->name }}">  
                  </div>
                  <div class="col">
                    <label>Departamento al que pertenece</label>
                    <select class="custom-select" name="departamentoEmpleado" >
                      @php
                      use App\empleado;
                      $id = Auth::user()->id;
                      $departamento = empleado::where('cod_empleado','=',$id)->first()->departamento;
                      @endphp
                      <option selected disabled value="">{{$departamento}}</option>
                    </select>   
                  </div>
                  </div>
                </div>


                <div class="form-group">
                  <div class="row">
                    <div class="col">
                         <label>Jefe Inmediato</label>
                             <select class="custom-select" name="jefeEmpleado" >
                              @php                 
                              $id = Auth::user()->id;
                              $jefe = empleado::where('cod_empleado','=',$id)->first()->jefe_inmediato;
                              @endphp
                              <option selected disabled value="">{{$jefe}}</option>
                            </select>
                    </div>
                    <div class="col">
                      <label for="exampleInputPassword1">Cargo que desempeña en la empresa</label>
                    @php                 
                    $id = Auth::user()->id;
                    $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado;
                    @endphp
                  <input type="text" class="form-control" name="CargoPermiso" value="{{$cargo}}"> </input>
                    </div>                
                  </div>
                </div>

                 <div class="form-group">
                  <div class="row">




<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                    <script type="text/javascript">

                     
$( document ).ready(function() {
 f = new Date();
 año = f.getFullYear();
 mes = '' + (f.getMonth()+1);
 dia = '' + f.getDate();

 if (mes.length <2) 
  mes = "0"+mes;  

 if (dia.length < 2)
   dia = "0"+dia;
 fechaNOW = document.getElementById("fechaPermiso").value= año+"-"+mes+"-"+dia;

});

                      function validateFormEdit(inputField) {
                         document.getElementById("btnEnviar").disabled = true;
                        var entrada = $("#horaEntrada").val();
                         var salida = $("#horaSalida").val();
                         var fechaEdit = $("#fechaPermiso").val();
                                               
                              if (fechaEdit < fechaNOW ) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaNOW);
                                fechaNOW = document.getElementById("fechaPermiso").value= año+"-"+mes+"-"+dia;
                              }      

                                     if (entrada) {
                                      if (entrada>salida) {
                                             document.getElementById("btnEnviar").disabled = false;
                                            }else{
                                               document.getElementById("btnEnviar").disabled = true;
                                               alert("La Hora de Entrada tiene que ser mayor que la Hora Salida");
                                               return 0;
                                            }
                                          }else{
                                            document.getElementById("btnEnviar").disabled = false;
                                          }
                      }
                    </script>
                  
                    <div class="col">
                      
                      <label>Hora de Salida</label>

                      @php
                      $horaSalida = $estado->hora_salida;
                      $hSalida  = date("H:i", strtotime($horaSalida)); 
                      @endphp

                       <input  max="16:00" min="08:00"  value="{{$hSalida}}" class="form-control" type="time" name="horaSalida" id="horaSalida" required>
                    </div>
                    
                    <div class="col">
                      <label>Hora de Entrada</label>

                       @php
                      $horaEntrada = $estado->hora_entrada;
                      $hEntrada  = date("H:i", strtotime($horaEntrada)); 
                      @endphp

                      <input  max="16:30" min="08:30"  value="{{$hEntrada}}" class="form-control" type="time" name="horaEntrada" id="horaEntrada" required>
                    </div>   
                  

                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Motivo Permiso</label>
                  <textarea type="text"  class="form-control" name="MotivoPermiso"  placeholder="Detalles sobre su permiso" required>{{$estado->motivo_permiso}}  </textarea>
                </div>
                <div class="custom-file">
                <input  type="file" class="custom-file-input" name="CustomFile" >
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
        <button type="submit" id="btnEnviar" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
</form>

@endsection
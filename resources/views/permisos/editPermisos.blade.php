@extends('permisos.plantilla')



@section('contenido')

<!-- Editar Solicitud -->


<form method="POST" action="{{route('permisoo.update', $estado->id_solicitud)}}">
  @method('PUT')
  @csrf
    <div class="container">
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
                        function validateHhMm(inputField) {
                            var isValid =/^([0-1]?[0-9]|2[0-4]):([0-5][0-9])(:[0-5][0-9])?$/.test(inputField.value);

                            if (isValid) {
                              inputField.style.backgroundColor = 'green';
                            } else {
                              inputField.style.backgroundColor = 'black';
                            }

                            return isValid;
                          }

                    </script>

                  
                    <div class="col">
                      
                      <label>Hora de Salida</label>

                      @php
                      $horaSalida = $estado->hora_salida;
                      $hSalida  = date("H:i", strtotime($horaSalida)); 
                      @endphp

                       <input value="{{$hSalida}}" class="form-control" type="time" name="horaSalida" >
                    </div>
                    
                    <div class="col">
                      <label>Hora de Entrada</label>

                       @php
                      $horaEntrada = $estado->hora_entrada;
                      $hEntrada  = date("H:i", strtotime($horaEntrada)); 
                      @endphp

                      <input value="{{$hEntrada}}" class="form-control" type="time" name="horaEntrada" >
                    </div>   
                  

                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Motivo Permiso</label>
                  <textarea type="text"  class="form-control" name="MotivoPermiso"  placeholder="Detalles sobre su permiso">{{$estado->motivo_permiso}}  </textarea>
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
        <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
</form>

@endsection
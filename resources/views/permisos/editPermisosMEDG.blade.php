@extends('permisos.plantilla')



@section('contenido')

<!-- Editar Solicitud -->


<form method="POST" action="{{route('permisoo.update', $estado->id_solicitud)}}">
  @method('PUT')
  @csrf
    <div class="container" onchange="validateFormMEDGEdit(this)">
      <div class="modal-header" >
        <h5 class="modal-title" id="exampleModalLabel">Solicitud para Permiso Medico Grave</h5>
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
 fechaNOW = document.getElementById("fSalidaMEDG").value= año+"-"+mes+"-"+dia;

});
                      function validateFormMEDGEdit(inputField) {
                          var fSalidaMEDG = $("#fSalidaMEDG").val();
                          var fEntradaMEDG = $("#fEntradaMEDG").val();

                             
                                               
                              if (fSalidaMEDG < fechaNOW && fSalidaMEDG.length > 0) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaNOW);
                               document.getElementById("fSalidaMEDG").value= año+"-"+mes+"-"+dia;
                                return 0;
                              }

                               if (fEntradaMEDG < fechaNOW && fEntradaMEDG.length > 0) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fSalidaMEDG);
                              document.getElementById("fEntradaMEDG").value= "";
                                  document.getElementById("fSalidaMEDG").value= "";
                                return 0;
                              }    

                              if (fSalidaMEDG > fEntradaMEDG && fEntradaMEDG.length > 0) {
                                alert("La Fecha tiene que Salida tiene que ser menor a la Fecha Entrada");
                                 document.getElementById("fSalidaMEDG").value= "";
                                 document.getElementById("fEntradaMEDG").value= "";
                                return 0;
                              }

                      
                                   
                      }
                    </script>

                     @php
                     $edit = new DateTime($estado->fecha_salida);
                    $fechaEdit = $edit->format('Y-m-d');

                    $ee = new DateTime($estado->fecha_entrada);
                    $fEdit = $ee->format('Y-m-d');
                      @endphp
                  
                    <div class="col"> 
                      <label>Fecha de Salida</label>
                       <input value="{{$fechaEdit}}" class="form-control" type="date" id="fSalidaMEDG" name="fSalidaMEDG" required>
                    </div>
                    
                    <div class="col">
                      <label>Fecha de Entrada</label>
                      <input value="{{$fEdit}}" class="form-control" type="date" id="fEntradaMEDG" name="fEntradaMEDG" required>
                    </div>   
                  

                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Motivo Permiso</label>
                  <textarea type="text"  class="form-control" name="MotivoPermisoMEDGedit"  placeholder="Detalles sobre su permiso" required>{{$estado->motivo_permiso}}  </textarea>
                </div>
                <div class="custom-file">
                <input  type="file" class="custom-file-input" name="CustomFileEditMEDG" >
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div>
      </div>
      <div class="modal-footer">
       
        <button type="submit" id="btnEnviarMEDGEdit" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
</form>

@endsection
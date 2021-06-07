@extends('permisos.plantilla')



@section('contenido')

<!-- Editar Solicitud -->


<form method="POST" action="{{route('permisoo.update', $estado->id_solicitud)}}">
  @method('PUT')
  @csrf
    <div class="container" onchange="validateFormOBLEdit(this)">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud por Obligacion Ciudadana</h5>
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
 fechaNOW = document.getElementById("fSalidaOBL").value= año+"-"+mes+"-"+dia;

});
                      function validateFormOBLEdit(inputField) {
                          var fSalidaOBL = $("#fSalidaOBL").val();
                          var fEntradaOBL = $("#fEntradaOBL").val();
                  
                              if (fSalidaOBL < fechaNOW && fSalidaOBL.length > 0) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaNOW);
                               document.getElementById("fSalidaOBL").value= año+"-"+mes+"-"+dia;
                                return 0;
                              }

                               if (fEntradaOBL < fechaNOW && fEntradaOBL.length > 0) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fSalidaOBL);
                              document.getElementById("fEntradaOBL").value= "";
                                  document.getElementById("fSalidaOBL").value= "";
                                return 0;
                              }    

                              if (fSalidaOBL > fEntradaOBL && fEntradaOBL.length > 0) {
                                alert("La Fecha tiene que Salida tiene que ser menor a la Fecha Entrada");
                                 document.getElementById("fSalidaOBL").value= "";
                                 document.getElementById("fEntradaOBL").value= "";
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
                       <input value="{{$fechaEdit}}" class="form-control" type="date" name="fSalidaOBL" id="fSalidaOBL" required>
                    </div>
                    
                    <div class="col">
                      <label>Fecha de Entrada</label>
                      <input value="{{$fEdit}}" class="form-control" type="date" name="fEntradaOBL" id="fEntradaOBL" required>
                    </div>   
                  

                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Motivo Permiso</label>
                  <textarea type="text"  class="form-control" name="MotivoPermisoOBLedit"  placeholder="Detalles sobre su permiso" required>{{$estado->motivo_permiso}}  </textarea>
                </div>
                <div class="custom-file">
                <input  type="file" class="custom-file-input" name="CustomFileEditOBL" >
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div>
      </div>
      <div class="modal-footer">
      
        <button type="submit" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
</form>

@endsection
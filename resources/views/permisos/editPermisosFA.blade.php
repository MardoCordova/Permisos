@extends('permisos.plantilla')



@section('contenido')

<!-- Editar Solicitud -->


<form method="POST" action="{{route('permisoo.update', $estado->id_solicitud)}}">
  @method('PUT')
  @csrf
    <div class="container"  onmousemove="validateFormFAL(this)">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Solicitud para Permiso Fallecimiento</h5>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('permiso.store')}}" enctype="multipart/form-data">
            @csrf
          <div class="row">
            <div class="col">
                <div style="display: none">
                  <input type="text" name="IDTipoPermiso" value="PM">
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
 fechaNOW = document.getElementById("fechaFA").value= año+"-"+mes+"-"+dia;

});

                      function validateFormFAL(inputField) {
                         document.getElementById("btnEnviarFAA").disabled = true;
                          
                           motivo = $("#MotivoPermisoFA").val();
                             var fechaFA = $("#fechaFA").val();
                                               
                              if (fechaFA < fechaNOW ) {
                                alert("La Fecha tiene que ser mayor o igual que: "+ fechaNOW);
                                fechaNOW = document.getElementById("fechaFA").value= año+"-"+mes+"-"+dia;
                              }  
  
                                         
                      }
                    </script>


                    @php
                    $estado->fecha_permiso;
                    $edit = new DateTime($estado->fecha_permiso);
                    $fechaEdit = $edit->format('Y-m-d');
                    @endphp
<div class="form-group">

                    <div class="row">
                        <div class="col">
                          <label>Fecha Permiso </label>
                          <input  class="form-control" value="{{$fechaEdit}}"  type="date" name="fechaFA" id="fechaFA" required>
                          </div>
                    <div class="col"> 
                          <label>Nombre del Fallecido</label>
                          <input  class="form-control" value="{{$estado->nombre_fallecido}}" type="text" name="nombreFallecido" required>
                    </div>
                           <div class="col"> 
                    <label>Relacion con la persona</label>
                      <select class="custom-select" name="relacionFallecido" id="relacionFallecido" required>
                      <option selected value="">Seleccione su relación</option>
                  
                      <option>Madre</option>
                      <option>Padre</option> 
                      <option>Hijos</option> 
                      <option>Conyugue</option>          
                    </select> 
                        </div>                      
                    </div>
                  </div>
                 
                <div class="form-group">
                  <label for="exampleInputPassword1">Motivo Permiso</label>
                  <textarea type="text"  class="form-control" name="MotivoPermisoFA" id="MotivoPermisoFA" placeholder="Detalles sobre su permiso" required>{{$estado->motivo_permiso}}  </textarea>
                </div>
                <div class="custom-file">
                <input  type="file" class="custom-file-input"  >
                <label class="custom-file-label" >Subir Evidencia</label>
              </div>
              </div>     
          </div>
      </div>
      <div class="modal-footer">
      
        <button type="submit" id="btnEnviarFAA" class="btn btn-primary">Enviar Solicitud</button>
      </div>
       </form>
    </div>
</form>

@endsection
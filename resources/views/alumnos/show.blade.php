@extends("../layout.plantilla")

@section("encabezado")
  <a href="{{ route('alumnos.index') }}"><button type="button" class="btn btn-success">Alumnos</button></a>
@endsection("encabezado")

@section("subencabezado")
  <a href="{{ route('alumnos.create') }}"><button type="button" class="btn btn-info">Agregar alumno</button></a>
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
    <div class="col-md-12">
      <!-- Custom Tabs -->
      @if($count_alumno == 0)
      	<div class="alert alert-danger alert-dismissible">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			<h4><i class="icon fa fa-ban"></i> Verificar!</h4>
			 El alumno seleccionado no pertenece al ciclo escolar elegido...
		</div>
      @else 
      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
	        <li style="width: 50%" >
	        	<a href="#" data-toggle="tab"><img src="/images/1.png" alt="" width="50" height="50"><b> {{$alumno->apaterno}} {{$alumno->amaterno}} {{$alumno->nombres}}</b> Grupo actual: <b>{{$alumno->grado_semestre}} {{$alumno->diferenciador_grupo}}</b>&nbsp;&nbsp;status: <b>{{$alumno->status}}</b></a>
	        </li>
          	<li class="active"><a href="#tab_1" data-toggle="tab">Estado de cuenta</a></li>
          	<li><a href="#tab_3" data-toggle="tab">Becas</a></li>          
        </ul>
        <div class="tab-content">
          <a href="/cobros/carnetpagopdf/{{ $alumno->id}}" target="_blank"><img src="/images/pdf.png" alt="pdf" width="42" height="42" style="float:right;">Exportar PDF<br><br></a>
          <!-- /.tab-pane -->
          <div class="tab-pane active" id="tab_1">
            <div class="box">
              <!-- /.box-header -->
              <div class="box-body">
                <table class="table table-bordered">
                  <b><tr>                  
                    <th>Plan de pago</th>
                    <th>Concepto</th>
                    <th>Precio</th>
                    <th>Fecha de vencimiento</th>
                    <th style="width: 40px">Status</th>
                    <th style="width: 70px">Accion</th>
                  </tr></b>
                  <? $planpago = 0;?>
                  @foreach($planespago as $planpago)
                      <tr style=' font: 12px "Comic Sans MS", cursive; color:red;' >
                        <td colspan="6">{{$planpago->descripcion  }}</td>                        
                      </tr>
                    @foreach($cuentaasignadas as $cuentaasignada)
                      @if($cuentaasignada->id_plan_pago == $planpago->id_plan_pago )
                      <tr>
                        <td colspan="2">{{ $cuentaasignada->desc_concepto }}</td>
                        <td>$ {{ number_format($cuentaasignada->cantidad,2) }} <br>
                          @if($cuentaasignada->codigo != '')
                            @if($cuentaasignada->porc_o_cant == 'porcentaje')
                            {{$cuentaasignada->codigo}} <br>
                            <b>$ {{number_format(($cuentaasignada->cantidad * $cuentaasignada->descuento_beca)/100,2)}}</b>
                            @endif
                          @endif
                        </td>
                        <td>{{date('d-m-Y', strtotime($cuentaasignada->periodo_vencimiento))}}</td>
                        <td>
                          @if($cuentaasignada->status_cta == 'pagado')
                            <span class="badge bg-blue">{{$cuentaasignada->status_cta}}</span>
                          @else
                            <span class="badge bg-green">{{$cuentaasignada->status_cta}}</span>
                          @endif
                        </td>
                        <td> 
                          @if($cuentaasignada->status_cta == 'pagado')
                            <a href="/cobros/print-pdf/{{$cuentaasignada->id}}/0" target="_blank"><img src="/images/pdf.png" alt="pdf" width="42" height="42"></a>
                            <a href="/cobros/print-pdf/{{$cuentaasignada->id}}/1" target="_blank"><img src="/images/pdf.png" alt="pdf" width="20" height="20"></a>
                          @else
                            <a class="eliminarcta_asignada" id="{{$cuentaasignada->id}}" href="#" ><span class="badge bg-red">Eliminar</span></a>
                          @endif</td>
                      </tr>
                      @endif
                    @endforeach
                  @endforeach
                </table>
              </div>
              <!-- /.box-body -->
              <div class="box-body">
                <h3 style="color: blue;">Cancelados</h3>
                <table class="table table-bordered">
                  <b>
                    <tr>                  
                      <th>Fecha cancelación</th>
                      <th>Concepto</th>
                      <th>Cantidad pagada</th>
                      <th>Fecha de vencimiento</th>
                      <th style="width: 40px">Status</th>
                      <th style="width: 70px">Accion</th>
                    </tr>
                  </b>                      
                    @foreach($cobros as $cobro)
                    <tr>
                      <td style="background-color: red; color:white;">{{$cobro->updated_at}}</td>
                      <td>{{$cobro->descripcion}} </td>
                      <td>$ {{number_format($cobro->cantidad_pagada,2)}}</td>
                      <td>{{$cobro->periodo_vencimiento}}</td>
                      <td style="color: red;"><b>{{$cobro->status}}</b></td>
                      <td> 
                          <a href="/cobros/printPDFcancelado/{{$cobro->id_cobro}}/{{$cobro->id_cuenta_asignada}}" target="_blank"><img src="/images/pdf.png" alt="pdf" width="40" height="40"></a>                                             
                      </td>
                    </tr>
                    @endforeach
                  
                </table>
              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
          </div>
          <!-- /.tab-pane -->
          <div class="tab-pane" id="tab_3">
            <div class="box">
	            <div class="box-header">
	            	<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modal-success">
                	Agregar beca
              		</button>
	              	<h3>Becas registradas</h3>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body no-padding">
	              <table class="table table-striped">
	                <tr>
	                  <th >Concepto</th>
	                  <th>Aplicado a:</th>
	                  <th>Porcentaje</th>
                    <th>Accion</th>
	                </tr>
	                @foreach($becasasiganadas as $becaasignada)
	                	<tr>
		                  <td>{{$becaasignada->descripcion}}</td>
		                  <td>{{$becaasignada->desc_conceptos}}</td>
		                  <td style="width:50px;"><span class="badge bg-blue">{{$becaasignada->cant_beca}}%</span></td>
                      <td style="width:50px;"><a href="/becaalumno/destroy/{{ $becaasignada->id}}" onclick="return confirm('Desea eliminar el registro');">                            
                            <span class="badge bg-red">Eliminar</span>
                        </a>
                      </td>
		                </tr>
	                @endforeach
	                	
	              </table>
	            </div>
	            <!-- /.box-body -->
	          </div>
          </div>
          <!-- /.tab-pane -->
          <!-- /.modal -->

        <div class="modal modal-success fade" id="modal-success">
          <div class="modal-dialog  modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Asignar beca</h4>
              </div>
              <div class="modal-body">
               	<div class="row">
               		<div class="col-md-4">
		              <div class="form-group">
		                <label>Becas</label>
		                <select id="id_beca" class="form-control select2" style="width: 100%;">
		                	<option value="">Seleccione</option>}		                	
		                  @foreach($opcbecas as $beca)
		                  	<option value="{{$beca->id}}">{{$beca->descripcion}}</option>
		                  @endforeach
		                </select>
		              </div>
		              <!-- /.form-group -->
           			 </div> 
           			 <div class="col-md-8">
				          <p class="lead">Seleccione a los conceptos que se aplicara:</p>

				          <div class="table-responsive">
				            <table class="table">
				              <tbody>
				              	 @foreach($cuentaasignadas as $cuentaasignadaBeca)
			                      <tr>
			                        <td><input type="checkbox" checked name="opciones[]" value="{{$cuentaasignadaBeca->id}}"></td>
			                        <td>{{ $cuentaasignadaBeca->desc_concepto }}</td>
			                        <td>$ {{ $cuentaasignadaBeca->cantidad }}</td>                        
			                        <td><span class="badge bg-green">Pendiente</span></td>
			                      </tr>
			                    @endforeach
				            </tbody></table>
				          </div>
           			 </div>              		
               	</div>
              </div>
              <div class="modal-footer">
              	<input type="hidden" value="{{$alumno->id}}" id="id_alumno">
              	<input type="hidden" value="{{$alumno->id_grupo}}" id="id_grupo">
                <button type="button" class="btn btn-outline pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button"  id="btn-agrega-becas" class="btn btn-outline">Agregar beneficio</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        </div>
        <!-- /.tab-content -->
      </div>
    @endif
      <!-- nav-tabs-custom -->
    </div>
        
    <!--/.col (right) -->
  </div>

@endsection("contenidoprincipal")

@section("scriptpie")
<script type="text/javascript">
  $(document).ready(function(){
    $('.eliminarcta_asignada').on('click', function(event){
      id = $(this).attr('id');
      //alert(id);
      if (confirm('Estas seguro que deseas elimnar esta cuenta asignada?')) {
        $.ajax({
            url:"/cuentasasignadas/destroy/"+id,
            dataType:"json",
            success:function(html){
              alert(html.data);
              location.reload();
            }
        })
      }
    });
    $('#btn-agrega-becas').on('click', function(event){      
      event.preventDefault();
     /* id                      = $('#opcion_asignacion').val();*/
      id_beca                = $('#id_beca').val();
      id_alumno				 = $('#id_alumno').val();
      id_grupo				 = $('#id_grupo').val();
      var selected           = [];

      $("input:checkbox[name='opciones[]']").each(function() {
        if (this.checked) {
          // agregas cada elemento.
          selected.push($(this).val());
        }
      });

        if(selected ==''){
          alert("Seleccione al menos un concepto al que se aplicara la beca.");
        }else if(id_beca==''){
          alert("Seleccione la beca que desee asignar..");
        }else{ 
       // alert("2");        
	        $.ajax({
	         	url:"/becaalumno/guardar/"+id_beca+"/"+selected+"/"+id_alumno+"/"+id_grupo,
	         	dataType:"json",
	         	success:function(html){
              alert(html.data);
	            location.reload();
	         	}
	        })
        }
      
    });

  });
</script>
@endsection("scriptpie")
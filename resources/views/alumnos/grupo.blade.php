@extends("../layout.plantilla")

@section("encabezado")
  <a href="{{ route('alumnos.index') }}"><button type="button" class="btn btn-success">Alumnos</button></a>
  <style type="text/css" >
     .nav-tabs-custom>.nav-tabs>li>a { background-color: #001b4c !important; border-radius: 10px; font: 12px; color: red; }
     .nav-tabs-custom>.nav-tabs>li>a {
      color:white;
     }
     .nav-tabs-custom>.nav-tabs>li.active>a {
      background-color: #3B5FA1 !important; border-radius: 15px; font: 12px;
     }
     .nav-tabs-custom>.nav-tabs>li.active>a, .nav-tabs-custom>.nav-tabs>li.active:hover>a {
      color: white;
     }
     .nav-tabs-custom>.nav-tabs>li{
      background-color: transparent;
     }
     .nav-tabs-custom{
      margin-bottom:5px;
      background: white;border-radius: 15px;
     }
     .form-group{
        margin-bottom:4px;
      }
  </style>
@endsection("encabezado")

@section("subencabezado")
  
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="navhead" style="width: 50%;" >
          <a href="#tab_1" data-toggle="tab" class="navurl"><img src="/images/1.png" alt="" width="50" height="50" style="border-radius: 15px;"><b> {{$alumno->apaterno}} {{$alumno->amaterno}} {{$alumno->nombres}}</b> Grupo actual: <label id="label_grupo">@if($grupoinscrito)<b> {{$grupoinscrito->grado_semestre}} {{$grupoinscrito->diferenciador_grupo}}</b>&nbsp;&nbsp;status: <b>{{$grupoinscrito->status}}@endif</label></b></a>
        </li>
          <li><a href="/alumnos/{{$alumno->id}}/edit" >Datos personales</a></li>
          <li class="active"><a href="#tab_2" data-toggle="tab">Grupo</a></li>
          <li><a href="#tab_3" data-toggle="tab">Cuentas asignadas</a></li>          
      </ul>
      
    </div>
    <div class="tab-content">
      <div class="tab-pane" id="tab_1">
        <!-- left column -->
        <form role="form" method="post" action="/alumnos/{{ $alumno->id}}" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="col-md-6">
          
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Datos del alumno</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Apellido paterno</label>
                      <input type="text" class="form-control" id="apaterno" name="apaterno" required  placeholder="A. paterno" value="{{ $alumno->apaterno }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Apellido materno</label>
                      <input type="text" class="form-control" id="amaterno" name="amaterno" required  placeholder="A. materno" value="{{ $alumno->amaterno }}">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Nombres</label>
                  <input type="text" class="form-control" id="nombres" name="nombres" required  placeholder="Nombre" value="{{ $alumno->nombres }}">
                </div>   
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Género {{$alumno->genero}}</label>
                      <select class="form-control" id="genero" name="genero" required> 
                        
                        <option {{ ($alumno->genero =='Hombre') ? 'selected' : ''}}>Hombre</option>
                        
                        <option {{($alumno->genero =='Mujer') ? 'selected' : ''}}>Mujer</option>

                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha de nacimiento</label>
                      <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" required  value="{{ $alumno->fecha_nac }}">
                    </div>
                  </div>
                </div> 
               <!-- <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Lugar de nacimiento</label>
                      <input type="text" class="form-control" id="lugar_nac" name="lugar_nac" required  value="{{ $alumno->lugar_nac }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Estado civil</label>
                      <input type="text" class="form-control" id="edo_civil" name="edo_civil" required  value="{{ $alumno->edo_civil }}">
                    </div>
                  </div>
                </div>-->
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">CURP</label>
                      <input type="text" class="form-control" id="curp" name="curp" required  placeholder="Clave unica de registro poblacional" value="{{ $alumno->curp }}">
                    </div> 
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">email</label>
                      <input type="text" class="form-control" id="email" name="email"   placeholder="correo electronico" value="{{ $alumno->email }}">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Domicilio</label>
                  <input type="text" class="form-control" id="domicilio" name="domicilio"   placeholder="domicilio" value="{{ $alumno->domicilio }}">
                </div>         
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Ciudad</label>
                      <input type="text" class="form-control" id="ciudad" name="ciudad"   placeholder="Ciudad" value="{{ $alumno->ciudad }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Estado</label>
                      <input type="text" class="form-control" id="estado" name="estado"   placeholder="Estado" value="{{ $alumno->estado }}">
                    </div>
                  </div>
                </div>                
                <div class="row">                  
                  <div class="col-xs-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">C.P.</label>
                      <input type="text" class="form-control" id="cp" name="cp"   placeholder="codigo postal" value="{{ $alumno->cp }}">
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Teléfono de casa</label>
                      <input type="text" class="form-control" id="telefono" name="telefono"   placeholder="telefono" value="{{ $alumno->telefono }}">
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Teléfono móvil</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="telefono2" name="telefono2"  placeholder="telefono2" value="{{ $alumno->telefono2 }}">
                    </div>
                  </div>
                </div>               
              </div>
              <!-- /.box-body -->                       
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-header with-border">
              <h3 class="box-title">Datos del tutor</h3>
            </div>
              <div class="box-body">                                                
                <div class="row">                  
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nombre del tutor</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="nombre_tutor" name="nombre_tutor"  placeholder="Nombre del tutor" value="{{ $alumno->nombre_tutor }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Parentesco del tutor</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="parentesco_tutor" name="parentesco_tutor"  placeholder="Parentesco del tutor" value="{{ $alumno->parentesco_tutor }}">
                    </div>                    
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Teléfono del tutor</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="telefono_tutor" name="telefono_tutor"  placeholder="Telefono del tutor" value="{{ $alumno->telefono_tutor }}">
                    </div>                    
                  </div>              
                </div>    
                <div class="box-header with-border">
                  <b><h3 class="box-title">Datos de facturación</h3></b>
                </div>
                <div class="row">                  
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Razón social</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="razon_social" name="razon_social"  placeholder="Razón social" value="{{ $alumno->razon_social }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">RFC</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="rfc" name="rfc"  placeholder="RFC" value="{{ $alumno->rfc }}">
                    </div>                    
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Uso del CFDI</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="uso_cfdi" name="uso_cfdi"  placeholder="Uso del CFDI" value="{{ $alumno->uso_cfdi }}">
                    </div>                    
                  </div>              
                </div>                                 
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" id="status" name="status" required  value="{{ $alumno->status }}">
                        <option {{($alumno->status== 'activo') ? 'selected' : ''}}>activo</option>
                        <option {{($alumno->status== 'baja temporal') ? 'selected' : ''}}>baja temporal</option>
                        <option {{($alumno->status== 'baja definitiva') ? 'selected' : ''}}>baja definitiva</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputFile">Foto</label>
                      <input type="file" id="foto" name="foto" >
                    </div> 
                  </div>
                </div>                                               
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Guardar cambios</button>
                <a href="{{ route('alumnos.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
              </div>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->         
          <!-- /.box -->
        </div>
        </form>
      </div>
      <div class="tab-pane active" id="tab_2">
        <!-- left column -->
        <div class="col-md-6">
          
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Grupo</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" id="sample_form" id="sample_form" enctype="multipart/form-data">   
             @csrf      
              <div class="box-body">
                <div class="row">
                  <div class="form-group">
                  <input type="hidden" name="id_alumno" id="id_alumno" value="{{$alumno->id}}">
                  <label class="control-label col-md-4" >Grado / Grupo: </label>
                  <div class="col-md-8">
                    <span id="nombre_alumno"></span>
                    <select name="id_grupo" id="id_grupo" class="form-control" required>
                      <option value="">Seleccione una opción</option>
                      @foreach($grupos as $grupo)
                      <option value="{{$grupo->id}}" @if($grupoinscrito){
                        {{($grupo->id ==$grupoinscrito->id_grupo) ? 'selected' : ''}}
                      } @endif>{{$grupo->grado_semestre}} {{$grupo->diferenciador_grupo}} || {{$grupo->denominacion_grado}} || {{$grupo->turno}}</option>
                      @endforeach
                    </select>
                  </div>
                 </div>                
                 <input type="hidden" value="activo" id="status" name="status">
                 <div class="form-group" align="center">
                  <input type="hidden" name="action" id="action" />
                  <input type="hidden" name="hidden_id" id="hidden_id" />
                  <span id="store_image"></span>
                 </div> 
                 <br><br>
                 <div class="form-group" align="center">
                    <div class="col-md-12">
                     <button   name="create_record" id="create_record" class="form-control btn-success">@if($grupoinscrito)
                        Actualizar
                      @else Inscripcion a grupo  @endif</button>
                    </div>
                 </div>        
                </div>  

                  
              </div> 
            </form>                     
          </div>
        </div>
         <div class="col-md-6">
          
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Exportar ficha de inscripción</h3>
            </div>
            <!-- /.box-header -->            
              <div class="box-body">
                <div class="row">
                  <div class="form-group">
                    <div class="col-md-12">
                      @if($grupoinscrito)
                       <a href="/alumnos/print-pdf/{{ $alumno->id}}" target="_blank"><button   name="pdf" id="pdf" class="form-control btn-primary">Exportar datos de inscripción</button></a>
                      @endif
                    </div>
                     
                  </div>
                </div>
              </div>
            </div>
          </div>

      </div>
      <div class="tab-pane" id="tab_3">
        <!-- left column -->
        <div class="col-md-4">
          
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Asignar Cuentas</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="post" id="sample_form2" id="sample_form2" enctype="multipart/form-data">   
             @csrf      
              <div class="box-body">
                <div class="row">          

                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Elige el plan de pagos</label>
                      <select class="form-control select2" id="plan_pago" name="plan_pago" required>
                        <option value="">Seleccione un plan</option>
                        @foreach($planpagos as $planpago)
                          <option value="{{$planpago->id}}">{{$planpago->descripcion}}</option>
                        @endforeach                   
                      </select>                     
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="box box-solid">
                      <div class="box-header with-border">
                        <h3 class="box-title">Seleccione los conceptos para asignar:</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body" id="contenedor_cobros" id="contenedor_cobros">
                        <!-- Contenedor opciones para asginarles cuentas...->
                        
                      </div>
                      <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                  </div>
                  <!--/.col (right) -->
                </div>
                </div>
                <div class="row">                  
                  <div class="col-xs-12">

                    <div class="form-group">
                      <br>
                      <button type="submit" id="btn_registro" class="btn btn-primary">Asignar cuentas por cobrar</button>
                      <a href="{{ route('planpago.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
                        @if($errors->any())
                          @foreach($errors->all() as $error)
                            <h3>{{$error}}</h3>
                          @endforeach
                        @endif    
                      <div id="content"></div>        
                    </div>
                  </div>
                </div>  
              </div> 
            </form>                     
          </div>
        </div>
        <div class="col-md-8">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Cuentas asignadas</h3>
              <a href="/cobros/carnetpagopdf/{{ $alumno->id}}" target="_blank"><img src="/images/pdf.png" alt="pdf" width="42" height="42" style="float:right;"></a>
            </div>
            <!-- /.box-header -->           
            <div class="box-body" id="tb_cuentaasignada">
              <table class="table table-bordered" id="tbcuentas">
                <thead>
                  <b><tr>                  
                    <th>Plan de pago</th>
                    <th>Concepto</th>
                    <th style="width: 100px">Precio</th>
                    <th style="width: 100px">Fecha de vencimiento</th>
                    <th style="width: 40px">Status</th>
                    <th style="width: 40px">Accion</th>
                  </tr></b>
                </thead>
                  <? $planpago = 0;?>
                <tbody>                 
                  @foreach($planespago as $planpago)
                      <tr style=' font: 12px "Comic Sans MS", cursive; color:red;' >
                        <td colspan="5">{{$planpago->descripcion  }}</td>
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
                            <a href="/cobros/print-pdf/{{$cuentaasignada->id}}/0" target="_blank"><img src="../../images/pdf.png" alt="pdf" width="42" height="42" style="float:right;"></a>
                            <br><a href="/cobros/print-pdf/{{$cuentaasignada->id}}/1" target="_blank"><img src="../../images/pdf.png" alt="pdf" width="22" height="22"></a>
                          @else
                            <a class="eliminarcta_asignada" id="{{$cuentaasignada->id}}" href="#" ><span class="badge bg-red">Eliminar</span></a>
                          @endif</td>
                      </tr>
                      @endif
                    @endforeach
                  @endforeach
                </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
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
    $('#sample_form').on('submit', function(event){
      event.preventDefault();    
      $.ajax({
          url:"{{route('grupoalumnos.store')}}",
          method:"POST",
          data: new FormData(this),
          contentType:false,
          cache:false,
          processData:false,
          dataType:"json",
          async:false,
          success: function(data){            
            //alert("2");
            var html = '';
            if(data.errors)
            {
              alert("Ocurrio un error");
            }
            if (data.success="success") {
              alert(data.status);
              $('#label_grupo').html(data.grupo.grado_semestre+" "+data.grupo.diferenciador_grupo);
              //create_record              
              $('.nav-tabs li:eq(3) a').tab('show');
              window.open('/alumnos/print-pdf/'+data.grupo.id_alumno,'_blank');

            }

          }
        })         
    });

    $("#plan_pago" ).change(function() {
      id        = 'alumno';
      opcion    = $('#id_alumno').val();
      planpago  = $('#plan_pago').val();
      $("#contenedor_cobros").empty();
      $.ajax({
       url:"/cuentasasignadas/cuenta_asignada/"+id+"/"+opcion+"/"+planpago,
       dataType:"json",
       success:function(html){
            for (var i = 0; i < html.data.length; i++) 
            {
              $("#contenedor_cobros").append('<p class="text-green"> <img src="/images/billete.png" alt="Avatar" style="width:30px"> <input type="checkbox" checked name="planes_pago[]" value="' + html.data[i].id  +'"> ' + html.data[i].descripcion  +' <br/></p>');              
            }          
       }
      })
    });

    //
    $('#sample_form2').on('submit', function(event){      
      event.preventDefault();
      id                      = 'alumno';
      planpago                = $('#plan_pago').val();
      var selected            = [];
      var conceptosasignados  = [];
      id_alumno               = $('#id_alumno').val();


      selected.push($('#id_alumno').val());

      $("input:checkbox[name='planes_pago[]']").each(function() {
        if (this.checked) {
          // agregas cada elemento.
          conceptosasignados.push($(this).val());
        }
      });
      
        if(conceptosasignados==''){
          alert("Seleccione al menos un concepto");
        }else{
          listar_opcion_asignacion = $('#opcion_asignacion2').val();
        $.ajax({
         url:"/cuentasasignadas/guardar_opcion_asignacion/"+id+"/"+listar_opcion_asignacion+"/"+selected+"/"+planpago+"/"+conceptosasignados,
         dataType:"json",
         success:function(html){
            alert(html.data);
            //location.reload();

            $.ajax({
             url:"/alumnos/ConsultaCuentas/"+id_alumno,
             dataType:"json",
             success:function(html){
                //alert(html.data);
                //location.reload();
                $('#tbcuentas tbody tr').remove();
                jQuery.each(html.planespago, function( i, val ) {
                  //$( "#" + i ).append( document.createTextNode( " - " + val ) );
                  $("#tbcuentas").find('tbody')
                  .append('<tr><td>'+val.descripcion+'</td><td></td><td></td><td></td><td></td><td></td></tr>');
                    jQuery.each(html.cuentaasignadas, function( j, val2 ) {
                      if(val.id_plan_pago == val2.id_plan_pago ){
                        if(val2.status_cta=='pagado'){
                          $("#tbcuentas").find('tbody').append('<tr><td></td><td>'+val2.desc_concepto+'</td><td>'+val2.cantidad+'</td><td>'+val2.periodo_vencimiento+'</td><td><span class="badge bg-blue">'+val2.status_cta+'</span></td><td></td></tr>');
                        }else{
                          $("#tbcuentas").find('tbody').append('<tr><td></td><td>'+val2.desc_concepto+'</td><td>'+val2.cantidad+'</td><td>'+val2.periodo_vencimiento+'</td><td><span class="badge bg-green">'+val2.status_cta+'</span></td><td></td></tr>');
                        }
                      }
                    }); 
                });              
             }
            })

         }
        })
        }      
    });
    //    
  });

</script>
@endsection("scriptpie")
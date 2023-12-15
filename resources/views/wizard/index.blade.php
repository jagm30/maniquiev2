@extends("../layout.plantilla")
<style type="text/css">
  .modal-dialog {
      width: 800px !important;
      margin: 30px auto;
  }
</style>
@section("encabezado")
<a href="{{ route('becas.index') }}"><button type="button" class="btn btn-success">Conceptos de becas</button></a>
@endsection("encabezado")

@section("subencabezado")
  <a href="{{ route('becas.create') }}"><button type="button" class="btn btn-info">Agregar beca</button></a>
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
    <div class="col-xs-12">
      <div class="box">
          <div class="box-header">
            <h3 class="box-title">Wizard </h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">1. Grupos</a></li>
              <li><a href="#tab_2" data-toggle="tab">2. Inscripción</a></li>
              <li><a href="#tab_3" data-toggle="tab">3. Planes de pagos</a></li>
              <li><a href="#tab_4" data-toggle="tab">4. Asignación de cuentas</a></li>                            
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <b>Copiar grupos del ciclo:</b>
                <select class="form-control" id="ciclo_escolar" name="ciclo_escolar">
                  <option>seleccione un ciclo escolar anterior</option>
                  @foreach($cicloescolars as $cicloescolar) 
                    <option value="{{ $cicloescolar->id }}">{{ $cicloescolar->descripcion }}</option>
                  @endforeach
                </select>
                <div class="row">
                  <div class="col-xs-4">
                    <h4>Grupos actuales:</h4>
                    <div class="form-group" style="color:green;" id="contenedorgruposactuales">
                      @foreach($grupos as $grupo)
                        <div class="checkbox"><label>{{ $grupo->clave_identificador }}/ {{ $grupo->grado_semestre }} {{ $grupo->diferenciador_grupo }} {{ $grupo->turno }}</label></div>
                      @endforeach
                    </div>
                  </div>
                  <div class="col-xs-4" >
                    <h4>Seleccione los grupos que desea copiar:</h4>
                    <div class="form-group" id="contenedorgruposant"  name="contenedorgruposant">
                      
                    </div>
                  </div>                   
                  <div class="col-xs-4">
                    <button class="form-control btn-success" id="btn_registrar" name="btn_registrar">Copiar Grupos Vacios</button>

                    <br>
                    <b>Este proceso copiara los grupos hacia el ciclo actual, los grupos se importaran vacios.</b>
                    <br>

                    <div class="col-xs-12" id="mensajediv" name="mensajediv"></div>
                  </div>
                </div>                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                <b>Copiar alumnos del ciclo:</b>
                <select class="form-control" id="ciclo_escolar_ga" name="ciclo_escolar_ga">
                  <option>seleccione un ciclo escolar anterior</option>
                  @foreach($cicloescolars as $cicloescolar) 
                    <option value="{{ $cicloescolar->id }}">{{ $cicloescolar->descripcion }}</option>
                  @endforeach
                </select>
                <div class="row">
                  <div class="col-xs-4">
                    <h4>Grupos anteriores:</h4>
                    <div class="form-group" id="contenedorgruposanta"  name="contenedorgruposanta">
                      <select class="form-control" id="gruposantealum" name="gruposantealum"> 
                          <option>Seleccione un grupo anterior</option>                          
                        </select>
                    </div>
                  </div>
                  <div class="col-xs-4" >
                    <h4> -> Grupo a donde se inscribirán:</h4>
                    <div class="form-group" style="color:green;" id="contenedorgruposactualesa">
                      <select class="form-control" id="grupoactualcopia" name="grupoactualcopia"> 
                        <option>Seleccione un grupo actual</option>
                        @foreach($grupos as $grupo)
                          <option value="{{ $grupo->id_grupo }}">{{ $grupo->clave_identificador }}/ {{ $grupo->grado_semestre }} {{ $grupo->diferenciador_grupo }} {{ $grupo->turno }}</option>
                        @endforeach
                      </select>
                    </div>                                                        
                  </div>                   
                  <div class="col-xs-4">
                    <h4> -> Procesar:</h4>
                    <button class="form-control btn-success" id="btn_registraralumnos" name="btn_registraralumnos">Copiar Grupos Vacios</button>

                    <br>
                    <b>Este proceso copiara los alumnos del grupos anterior hacia el grupo actual seccionado.</b>
                    <br>

                    <div class="col-xs-12" id="mensajediv" name="mensajediv"></div>
                  </div>
                </div>   
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                <b>Copiar grupos del ciclo:</b>
                <select class="form-control" id="ciclo_escolarpp" name="ciclo_escolarpp">
                  <option>seleccione un ciclo escolar anterior</option>
                  @foreach($cicloescolars as $cicloescolar) 
                    <option value="{{ $cicloescolar->id }}">{{ $cicloescolar->descripcion }}</option>
                  @endforeach
                </select>
                <div class="row">                  
                  <div class="col-xs-12" >
                    <table id="tabplanpago" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Periodicidad</th>
                        <th>Funciones</th>
                      </tr>
                      </thead>
                     
                      <tfoot>
                      <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Periodicidad</th>
                        <th>Funciones</th>
                      </tr>
                      </tfoot>
                    </table>
                  </div>                   
                  
                </div>  
              </div>
              <div class="tab-pane" id="tab_4">
                <b>Crear cuentas por cobrar:</b>
                
                <div class="row">                  
                   <form role="form" id="sample_form" name="sample_form" method="post" action="/politicaplanpago"  enctype="multipart/form-data" >
                      @csrf
                      <div class="col-md-4">
                        <!-- general form elements -->
                        <div class="box box-primary">
                          <div class="box-header with-border">
                            <h3 class="box-title">Asignación de cuentas por cobrar</h3>
                          </div>
                          <!-- /.box-header -->
                          <!-- form start -->            
                            <div class="box-body">
                              <div class="row">                  
                                <div class="col-xs-12">
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Elija a quienes desea asignar cuentas por cobrar, para el ciclo seleccionado</label>
                                    <select class="form-control" id="opcion_asignacion" name="opcion_asignacion" required>
                                      <option value="">Seleccione una opción</option>
                                      <option value="nivel">Alumnos de un nivel</option>
                                      <option value="grupo">Alumnos de un grupo</option>
                                      <option value="alumno">Un alumno en particular</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row">                  
                                <div class="col-xs-12">
                                  <br>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Seleccione</label>
                                    <select class="form-control select2" id="opcion_asignacion2" name="opcion_asignacion2" required style="width: 320px;">                     
                                    </select>                     
                                  </div>
                                </div>
                              </div>
                              <div class="row">                  
                                <div class="col-xs-12">
                                  <br>
                                  <div class="form-group">
                                    <label for="exampleInputPassword1">Elige el plan de pagos</label><br>
                                    <select class="form-control select2" id="plan_pago" name="plan_pago" required style="width: 320px;">
                                      <option value="">Seleccione un plan</option>
                                      @foreach($planpagos as $planpago)
                                        <option value="{{$planpago->id}}">{{$planpago->descripcion}}</option>
                                      @endforeach                   
                                    </select>                     
                                  </div>
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
                            <!-- /.box-body -->                       
                        </div>
                        <!-- /.box -->
                        <!-- /.box -->
                      </div>
                      <!--/.col (left) -->
                      <!-- right column -->
                     
                      </form>

                      <div class="col-md-4">
                        <div class="box box-solid">
                          <div class="box-header with-border">
                            <i class="fa fa-text-width"></i>

                            <h3 class="box-title">Seleccione grupo(s) o alumno(s):</h3>
                          </div>
                          <!-- /.box-header -->
                          <div class="box-body" id="contenedorOpcAsig" id="contenedorOpcAsig">
                            <!-- Contenedor opciones para asginarles cuentas...->
                            
                          </div>
                          <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                      </div>
                      <!--/.col (right) -->
                    </div>
                    <div class="col-md-4">
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
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          </div>
          <!-- /.box-body -->
        </div>
    </div>
  </div>
  <div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-title">Verifique la información a copiar</h4>
      </div>
      <span id="form_result"></span>
      <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="form-group">
            <label class="control-label col-md-4" >Codigo: </label>
            <div class="col-md-8">
              <input type="hidden" class="form-control" name="id_plan" id="id_plan" >
              <input type="text" class="form-control" name="codigo_plan" id="codigo_plan" required>
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4" >Descripción: </label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="descripcion_plan" id="descripcion_plan" required>
            </div>
           </div>             
           <div class="form-group">
            <label class="control-label col-md-4" >Periocidad: </label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="periocidad_plan" id="periocidad_plan" required>
            </div>
           </div>  
           <h4>Los conceptos descritos abajo, se le sumaron un año a las fechas de inicio y final de vigencias, posteriormente se pueden realizar ediciones en el apartado de planes de pago/conceptos de cobro.</h4>
          <div class="table-responsive">
              <table id="grupoalumnos_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Concepto del cobro</th>
                  <th>Año </th>
                  <th>Inicia</th>
                  <th>Finaliza</th>
                  <th  width="170">Costo</th>
                </tr>
                </thead>
                <tbody id="contenedorconceptos">
                  
                </tbody>
              </table>
            </div>                                    
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <input type="button" name="action_button" id="action_button" class="btn btn-warning" value="Copiar plan de pagos">
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@endsection("contenidoprincipal")
@section("scriptpie")
<script>
  $(document).ready(function(){
    
    $('#ciclo_escolar').on('change', function() {
        $("#contenedorgruposant").html("");
        $.ajax({
          url:"/grupos/listarxciclo/"+$(this).val(),
          dataType:"json",
          success:function(html){            
            for (var i = 0; i < html.data.length; i++){
              $("#contenedorgruposant").append('<div class="checkbox"><label><input type="checkbox" name="opciones[]" value="'+html.data[i].id_grupo+'">'+html.data[i].clave_identificador+' / '+html.data[i].grado_semestre+'  '+html.data[i].diferenciador_grupo+'  '+html.data[i].turno+'</label></div>');
            }
          }
        });
    });

    $('#btn_registrar').click(function() {      
      var selected            = [];
      var  list = {
        'datos' :[]
      };
      // SE COLOCAN EN UN ARREGLO LOS GRUPOS SELECCIONADOS
      $("input:checkbox[name='opciones[]']").each(function() {
        if (this.checked) {
          // agregas cada elemento.
          // a continuacion se forma un objeto JSON para pasar los datos seleccionados
          list.datos.push({
            "id_grupo": $(this).val()   
          });          
        }
      })
      json = JSON.stringify(list); // aqui tienes la lista de objetos en Json
      var obj = JSON.parse(json); //Parsea el Json al objeto anterior.

      // SE REGISTRAN LOS GRUPOS DEL ARREGLO
      $.ajax({
           url:"/grupos/guardargrupo/"+json,
           dataType:"json",
           async: false,
           contentType: "application/json",
           success:function(html){
              $("#mensajediv").append('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> Alert!</h4>'+html.data+'</div>');
            //actualizar grupos actuales en wizard
              $("#contenedorgruposactuales").html("");
              $.ajax({
                url:"/grupos/listarxciclo/"+{{ session('session_cart') }},
                dataType:"json",
                success:function(html){            
                  for (var i = 0; i < html.data.length; i++){
                    $("#contenedorgruposactuales").append('<div><label>'+html.data[i].clave_identificador+' / '+html.data[i].grado_semestre+'  '+html.data[i].diferenciador_grupo+'  '+html.data[i].turno+'</label></div>');
                      setTimeout(function() { location.reload();}, 1000)
                  }
                }
              });
              //actualizar grupos actuales
           }
        })

    });

    //tab 2
    $('#ciclo_escolar_ga').on('change', function() {
        $("#gruposantealum").html("");
        $.ajax({
          url:"/grupos/listarxciclo/"+$(this).val(),
          dataType:"json",
          success:function(html){            

            for (var i = 0; i < html.data.length; i++){
              $("#gruposantealum").append('<option value="'+html.data[i].id_grupo+'">'+html.data[i].clave_identificador+' / '+html.data[i].grado_semestre+'  '+html.data[i].diferenciador_grupo+'  '+html.data[i].turno+'</option>');
            }
          }
        });
    });
    //funcion para copiar los alumnos de un ciclo a otro
$('#btn_registraralumnos').click(function() {    

    var  grupoanterior  = $('#gruposantealum').val();
    var grupoactual     = $('#grupoactualcopia').val();

    $.ajax({
         url:"/grupos/transferirgrupoalumno/"+grupoanterior+"/"+grupoactual,
         dataType:"json",
         async: false,
         contentType: "application/json",
         success:function(html){
          alert(html.data);
          setTimeout(function() { location.reload();}, 1000)
         }
      })

    });

  //tab 3, planes de pago
    $('#ciclo_escolarpp').on('change', function() {
      var table = $('#tabplanpago').DataTable();
      //clear datatable
      table.clear().draw();
      //destroy datatable
      table.destroy();
      //$("#tabplanpago").empty();        
        $('#tabplanpago').DataTable({
          processing: true,
          serverSide: true,
          ajax:{
            url: "planpago/listarplanxciclo/"+$(this).val()
          },
          columns:[
            {
              data: 'codigo',
              name: 'codigo'
            },
            {
              data: 'descripcion',
              name: 'descripcion'
            },
            {
              data: 'periocidad',
              name: 'periocidad'
            },
            {
            data: 'action',
            name: 'action',
            orderable: false
            }
          ]
        });
    });

    //al dar clic en el boton copiar plan de pagos, despegar la ventana modal
    $(document).on('click', '.edit', function(){
      var id = $(this).attr('id');
      $("#contenedorconceptos").html("");
      $('#form_result').html('');
      $.ajax({
       url:"/planpago/"+id,
       dataType:"json",
       success:function(html){
        
        $('#id_plan').val(id);
        $('#codigo_plan').val(html.data.codigo);
        $('#descripcion_plan').val(html.data.descripcion);
        $('#periocidad_plan').val(html.data.periocidad);
        

        for (var i = 0; i < html.conceptos.length; i++){

          var fecha = html.conceptos[i].periodo_inicio;
          var fecha_split = fecha.split('-');
          var nueva_fecha = new Date(fecha_split[0], fecha_split[1]-1, fecha_split[2]);
          var fecha = new Date(nueva_fecha);
          fecha.setFullYear(fecha.getFullYear() + 1);
          fecha = fecha.yyyymmdd();

          var fecha2 = html.conceptos[i].periodo_vencimiento;
          var fecha_split2 = fecha2.split('-');
          var nueva_fecha2 = new Date(fecha_split2[0], fecha_split2[1]-1, fecha_split2[2]);
          var fecha2 = new Date(nueva_fecha2);
          fecha2.setFullYear(fecha2.getFullYear() + 1);
          fecha2 = fecha2.yyyymmdd();

          $("#contenedorconceptos").append('<tr><td style="font-size:9pt;">'+html.conceptos[i].descripcion+ '</td><td>'+(html.conceptos[i].anio_corresponde+1)+ '</td><td style="width:100px;">'+fecha+ '</td><td style="width:100px;">'+fecha2+ '</td><td>'+html.conceptos[i].cantidad+ '</td></tr>');
        }
       }
      })     
     });

    //
    //al dar clic en el boton copiar, despegar la ventana modal
    $(document).on('click', '#action_button', function(){
      var id_plan           = $('#id_plan').val();
      var codigo_plan       = $('#codigo_plan').val();
      var descripcion_plan  = $('#descripcion_plan').val();
      var periocidad_plan   = $('#periocidad_plan').val();
        $.ajax({
       url:"/planpago/clonar/"+id_plan+"/"+codigo_plan+"/"+descripcion_plan+"/"+periocidad_plan,
       dataType:"json",
       success:function(html){
        alert("Conceptos copiados correctamente...");        
        setTimeout(function() { location.reload();}, 1000)
       }
      })
     });
    
    Date.prototype.yyyymmdd = function() {
      var mm = this.getMonth() + 1; // getMonth() is zero-based
      var dd = this.getDate();

      return [this.getFullYear()+'-',
              (mm>9 ? '' : '0') + mm +'-',
              (dd>9 ? '' : '0') + dd
             ].join('');
    };
    
    //funciones para asignar cuentas
    $('#sample_form').on('submit', function(event){      
      event.preventDefault();
      id                      = $('#opcion_asignacion').val();
      planpago                = $('#plan_pago').val();
      var selected            = [];
      var conceptosasignados  = [];

      $("input:checkbox[name='opciones[]']").each(function() {
        if (this.checked) {
          // agregas cada elemento.
          selected.push($(this).val());
        }
      });

      $("input:checkbox[name='planes_pago[]']").each(function() {
        if (this.checked) {
          // agregas cada elemento.
          conceptosasignados.push($(this).val());
        }
      });
      if(id =='grupo'){
        if(selected ==''){
          alert("Seleccione al menos una persona para asignar las cuentas");
        }else if(conceptosasignados==''){
          alert("Seleccione al menos un concepto");
        }else{
          listar_opcion_asignacion = $('#opcion_asignacion2').val();
        
        $.ajax({
         url:"/cuentasasignadas/guardar_opcion_asignacion/"+id+"/"+listar_opcion_asignacion+"/"+selected+"/"+planpago+"/"+conceptosasignados,
         dataType:"json",
         success:function(html){
            alert(html.data);
            location.reload();
         }
        })
        }
      }
      if(id =='nivel'){
        if(selected ==''){
          alert("Seleccione al menos un nivel escolar");
        }else if(conceptosasignados==''){
          alert("Seleccione al menos un concepto");
        }else{
          listar_opcion_asignacion = $('#opcion_asignacion2').val();
        $.ajax({
         url:"/cuentasasignadas/guardar_opcion_asignacion/"+id+"/"+listar_opcion_asignacion+"/"+selected+"/"+planpago+"/"+conceptosasignados,
         dataType:"json",
         success:function(html){
            alert(html.data);
            location.reload();
         }
        })
        }
      }
      if(id =='alumno'){
        if(selected ==''){
          alert("Seleccione al menos un alumno");
        }else if(conceptosasignados==''){
          alert("Seleccione al menos un concepto");
        }else{
          listar_opcion_asignacion = $('#opcion_asignacion2').val();
        $.ajax({
         url:"/cuentasasignadas/guardar_opcion_asignacion/"+id+"/"+listar_opcion_asignacion+"/"+selected+"/"+planpago+"/"+conceptosasignados,
         dataType:"json",
         success:function(html){
            alert(html.data);
            location.reload();

         }
        })
        }
      }
    });

    $('.select2').select2({
      placeholder: "Seleccione una opción",
    });
    $('.select2').select2().on('select2:open', function(e){
        $('.select2-search__field').attr('placeholder', 'Ingrese un texto');
    })

    $("#opcion_asignacion" ).change(function() {
      //alert($('#opcion_asignacion').val());
      id = $('#opcion_asignacion').val();
      $("#opcion_asignacion2").empty();
      $.ajax({
       url:"/cuentasasignadas/opcion_asignacion/"+id,
       dataType:"json",
       success:function(html){
          //alert(html.data);
          if(id=="nivel"){
            $("#contenedorOpcAsig").empty();
            $("#opcion_asignacion2").append('<option value="">Seleccione el nivel</option>');
            for (var i = 0; i < html.data.length; i++) 
            {
              $("#opcion_asignacion2").append('<option value="' + html.data[i].id + '">' + html.data[i].clave_identificador +' /'+ html.data[i].denominacion_grado+'</option>');

            }
          }
          if(id=="grupo"){
             $("#opcion_asignacion2").append('<option value="">Seleccione el grupo</option>');
            for (var j = 0; j < html.data.length; j++) 
            {
              $("#opcion_asignacion2").append('<option value=' + html.data[j].id_grupo+ '>' + html.data[j].grado_semestre +' '+html.data[j].diferenciador_grupo+' / '+ html.data[j].denominacion_grado +' /' + html.data[j].turno +'</option>');
            }  
          }
          if(id=="alumno"){
            $("#contenedorOpcAsig").empty();
             $("#opcion_asignacion2").append('<option value="">Seleccione el alumno</option>');
            for (var k = 0; k < html.data.length; k++) 
            {
              $("#opcion_asignacion2").append('<option value=' + html.data[k].id + '>' + html.data[k].apaterno +' '+html.data[k].amaterno+' '+html.data[k].nombres+' </option>');
            }  
          }
       }
      })
    });

    $("#opcion_asignacion2" ).change(function() {
      //alert($('#opcion_asignacion').val());
      //alert("aca");
      id = $('#opcion_asignacion').val();
      listar_opcion_asignacion = $('#opcion_asignacion2').val();
      $("#contenedor_cobros").empty();
      $('#plan_pago').prop('selectedIndex',0);
      $('.select2').select2();
      $("#contenedorOpcAsig").empty();
      $.ajax({
       url:"/cuentasasignadas/listar_opcion_asignacion/"+id+"/"+listar_opcion_asignacion,
       dataType:"json",
       success:function(html){
          //alert(html.data[0].full_name);
          if(id=="grupo"){  
            for (var i = 0; i < html.data.length; i++) 
            {
              $("#contenedorOpcAsig").append('<p class="text-green"> <img src="/images/1.png" alt="Avatar" style="width:30px"> <input type="checkbox" checked name="opciones[]" value="'+html.data[i].id_alumno+'"> ' + html.data[i].full_name  +' <br/></p>');              
            }
          }
          if(id=="nivel"){  
            for (var i = 0; i < html.data.length; i++) 
            {
              $("#contenedorOpcAsig").append('<p class="text-green"> <img src="/images/grupo.png" alt="Avatar" style="width:30px"> <input type="checkbox" checked name="opciones[]" value="'+html.data[i].id_grupo+'"> ' + html.data[i].grado_semestre +' / '+ html.data[i].diferenciador_grupo  +'/'+html.data[i].denominacion_grado+' '+html.data[i].turno+' <br/></p>');              
            }
          }
          if(id=="alumno"){  
            for (var i = 0; i < html.data.length; i++) 
            {
              $("#contenedorOpcAsig").append('<p class="text-green"> <img src="/images/' + html.data[i].foto +'" alt="Avatar" style="width:30px"> <input type="checkbox" checked name="opciones[]" value="'+html.data[i].id+'"> ' + html.data[i].full_name +' <br/> CURP:'+html.data[i].curp+'<br> Grupo: '+html.data[i].grado_semestre+' '+html.data[i].diferenciador_grupo+' </p>');              
            }
          }
       }
      })
    });
    $("#plan_pago" ).change(function() {
      id        = $('#opcion_asignacion').val();
      opcion    = $('#opcion_asignacion2').val();
      planpago  = $('#plan_pago').val();
      $("#contenedor_cobros").empty();
      $.ajax({
       url:"/cuentasasignadas/cuenta_asignada/"+id+"/"+opcion+"/"+planpago,
       dataType:"json",
       success:function(html){
            for (var i = 0; i < html.data.length; i++) 
            {
              $("#contenedor_cobros").append('<p class="text-green"> <img src="/images/billete.png" alt="Avatar" style="width:30px"> <input type="checkbox" checked name="planes_pago[]" value="' + html.data[i].id  +'"> ' + html.data[i].descripcion  +'-' + html.data[i].cantidad  +' <br/></p>');              
            }          
       }
      })
    });

  });

</script>
@endsection("scriptpie")
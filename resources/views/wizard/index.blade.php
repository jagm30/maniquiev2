@extends("../layout.plantilla")

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
              <li class="active"><a href="#tab_1" data-toggle="tab">Grupos vacios</a></li>
              <li><a href="#tab_2" data-toggle="tab">Inscribir alumnos</a></li>
              <li><a href="#tab_3" data-toggle="tab">Planes de pagos</a></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  Dropdown <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                  <li role="presentation" class="divider"></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                </ul>
              </li>
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
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
        <h4 class="modal-title" id="modal-title">Default Modal</h4>
      </div>
      <span id="form_result"></span>
      <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
        <div class="modal-body">
          <div class="table-responsive">
              <table id="grupoalumnos_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Concepto del cobro</th>
                  <th>Año al que corresponde</th>
                  <th>Mes a pagar</th>
                  <th>Costo</th>
                  <th  width="170">Funciones</th>
                </tr>
                </thead>
                <tbody>
                  
                </tbody>
              </table>
            </div>
          <div class="form-group">
            <label class="control-label col-md-4" >Concepto: </label>
            <div class="col-md-8">
              <span id="nombre_alumno"></span>
              <select name="id_concepto_cobro" id="id_concepto_cobro" class="form-control" required >
                <option value="">Seleccione una opción</option>
               
              </select>
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4" >Año al que corresponde: </label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="anio_corresponde" id="anio_corresponde" required>
            </div>
           </div> 
           <div class="form-group">
            <label class="control-label col-md-4" >Mes a pagar: </label>
            <div class="col-md-8">
              <select class="form-control" name="mes_pagar" id="mes_pagar" required>
                <option value="">Seleccione</option>
                <option>ENERO</option>
                <option>FEBRERO</option>
                <option>MARZO</option>
                <option>ABRIL</option>
                <option>MAYO</option>
                <option>JUNIO</option>
                <option>JULIO</option>
                <option>AGOSTO</option>
                <option>SEPTIEMBRE</option>
                <option>OCTUBRE</option>
                <option>NOVIEMBRE</option>
                <option>DICIEMBRE</option>
              </select>
            </div>
           </div>  
           <div class="form-group">
            <label class="control-label col-md-4" >Parcialidad: </label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="no_parcialidad" id="no_parcialidad" required>
            </div>
           </div>  
           <div class="form-group">
            <label class="control-label col-md-4" >Periodo de inicio: </label>
            <div class="col-md-8">
              <input type="date" class="form-control" name="periodo_inicio" id="periodo_inicio" required>
            </div>
           </div> 
           <div class="form-group">
            <label class="control-label col-md-4" >Periodo de vencimiento: </label>
            <div class="col-md-8">
              <input type="date" class="form-control" name="periodo_vencimiento" id="periodo_vencimiento" required>
            </div>
           </div> 
           <div class="form-group">
            <label class="control-label col-md-4" >Cantidad a pagar: </label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="cantidad" id="cantidad" required>
            </div>
           </div>                      

            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Agregar">
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

    //al dar clic en el boton copiar, despegar la ventana modal
    $(document).on('click', '.edit', function(){
      var id = $(this).attr('id');
      alert(id);
      $('#form_result').html('');
     // $('#inputId').prop('readonly', true);
     // $("#id_alumno").attr("readonly","readonly");
      //$("#id_alumno").hide();
      //$("#nombre_alumno").show();
     // $("#cont_grupo").show();    
    /*  $.ajax({
       url:"/planpagoconcepto/"+id+"/edit",
       dataType:"json",
       success:function(html){
          $('#id_concepto_cobro').val(html.data.id_concepto_cobro);
          $('#anio_corresponde').val(html.data.anio_corresponde);
          $('#mes_pagar').val(html.data.mes_pagar);
          $('#no_parcialidad').val(html.data.no_parcialidad);
          $('#periodo_inicio').val(html.data.periodo_inicio);
          $('#periodo_vencimiento').val(html.data.periodo_vencimiento);
          $('#cantidad').val(html.data.cantidad);
          $('#hidden_id').val(html.data.id);
          $('#modal-title').text("Editar concepto");
          $('#action_button').val("Guardar");
          $('#action').val("Edit");          
       }
      })*/
     });


  });

</script>
@endsection("scriptpie")
@extends("../layout.plantilla")

@section("encabezado")
  <style type="text/css">
    .container {
    width: 100%;
}
  </style>
@endsection("encabezado")
  
@section("contenidoprincipal")
	<div class="row">
        <input type="hidden" name="id_session_ciclo" id="id_session_ciclo" value="{{ $id_session_ciclo }}">
        <input type="hidden" name="id_usuario" id="id_usuario" value="{{ Auth::user()->id }}">
        <input type="hidden" name="fecha_actual" id="fecha_actual" value="{{$fecha_actual}}">
        <!-- left column -->
        <form role="form" id="sample_form" name="sample_form" method="post" action=""  enctype="multipart/form-data" >
        @csrf
        <div class="col-md-4">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">                  
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Buscar alumno</label>
                      <select class="form-control select2" id="opcion_asignacion2" name="opcion_asignacion2" required>
                        <option value="">Seleccione</option>
                        @foreach($alumnos as $alumno)
                          <option value="{{$alumno->id}}">{{$alumno->apaterno}} {{$alumno->amaterno}} {{$alumno->nombres}}</option>
                        @endforeach
                      </select>                     
                    </div>
                  </div>
                </div>
               <div class="row">                  
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label >Forma de pago</label>
                      <select class="form-control select2" id="forma_pago" name="forma_pago" required>
                        <option value="efectivo">Efectivo</option>
                        <option value="trasferencia">Transferencia</option>
                        <option value="tarjeta">Tarjeta</option>
                      </select>                     
                    </div>
                  </div>
                </div>
                <div class="row">                  
                  <div class="col-xs-12">
                    <div class="form-group">
                      <br>
                      <h3 style="color: red; ">TOTAL A PAGAR  $</h3>
                      <input type="text" id="total_pagar" readonly class="form-control" style="color:red; font-size: 16pt; text-align: right;"> 
                    </div>
                  </div>
                </div> 
                <div class="row">                  
                  <div class="col-xs-12">

                    <div class="form-group" >
                      <br>
                      <button type="button" style="width:85px" class="btn btn-info" data-toggle="modal" data-target="#modal-success">
                        Descuento
                      </button>
                      <a href="{{ route('politicaplanpago.index') }}"><button type="button" style="width:75px" id="btn_registro" class="btn btn-warning">Cancelar</button></a>
                      <button type="button" id="btn_registrar" style="width:100px; float:right;" id="btn_registro" class="btn btn-success">Cobrar</button>
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
        <div class="modal fade" id="modal-success">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="formmodal" name="formmodal">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title"><b>Asignar descuento</b></h4>
                </div>
                <div class="modal-body">
                  <div class="box box-info"><br>
                    <label>Seleccione una cuenta a la que se aplicara el descuento</label>
                    <select class="form-control" id="id_cuenta_asignada" required>
                      <option value="">seleccione</option>
                    </select>
                    <label>Motivo deel descuento</label>
                    <input class="form-control"  type="text" id="descripcion_descuento"  placeholder="Ingrese el motivo del descuento">
                    <label>Cantidad a descontar</label>
                    <input class="form-control"  type="number" id="cantidad_descuento" placeholder="Ingrese el monto de descuento">
                    <label>Fecha</label>
                    <input class="form-control"  type="date" id="fecha_descuento" value="{{$fecha_actual}}" readonly>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cancelar</button>
                  <button type="button"  class="btn btn-primary pull-right" onclick="registrarDescuento();">Registrar</button>
                </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
        <div class="col-md-8">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-check"></i>

              <h3 class="box-title">Seleccione los conceptos a pagar:</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="contenedorOpcAsig" id="contenedorOpcAsig">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>-</th>
                <th>Concepto</th>
                <th>Cantidad</th>
                <th>Desc. P.P.</th>
                <th>Descuento</th>
                <th>Recargos</th>
                <th>Subtotal</th>
                <th>Status</th>
              </tr>
              </thead>
              <tbody id="conttable" name="conttable">

              </tbody>
              <tfoot>
              <tr>
                <th>-</th>
                <th>Concepto</th>
                <th>Cantidad</th>
                <th>Desc. P.P.</th>
                <th>Descuento</th>
                <th>Recargos</th>
                <th>Subtotal</th>
                <th>Status</th>              
              </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>

        <!--/.col (right) -->
      </div>

      <!-- /.modal -->

        <div class="modal fade" id="modal-info">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Registro de abono a cuentas</h4>
              </div>
              <div class="modal-body">
                <form id="form_modal" name="form_modal">
                <div class="callout callout-success">
                  <h4>Importe total: $ <span id="cuenta_inicial" name="cuenta_inicial"></span></h4>
                </div>
                <div class="box box-info">
                  <input type="hidden" name="subtotal_fpago" id="subtotal_fpago" class="form-control">
                  <input type="hidden" name="id_cuentaasignada" id="id_cuentaasignada" class="form-control">
                  <input type="hidden" name="cantidad_ini_fpago" id="cantidad_ini_fpago" class="form-control"
                  >
                  <input type="hidden" name="desc_pp_fpago" id="desc_pp_fpago" class="form-control"
                  >
                  <input type="hidden" name="desc_con_fpago" id="desc_con_fpago" class="form-control"
                  >
                  <input type="hidden" name="recargo_fpago" id="recargo_fpago" class="form-control"
                  >
                  
                  
                  <div class="box-body">                                                          
                    <div class="input-group">
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-danger" style="width:150px;">Cantidad Restante:</button>
                      </div>
                      <input type="hidden" readonly class="form-control" id="cantidad_abonada" name="cantidad_abonada">
                       <input type="text" readonly class="form-control" id="cantidad_restante" name="cantidad_restante">
                    </div>
                    <br>
                    <div class="input-group">
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-danger" style="width:150px;">Monto a abonar:</button>
                      </div>
                      <input type="text" class="form-control" id="cantidad_abono" name="cantidad_abono" required>
                    </div>
                    <br>
                    <div class="input-group">
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-danger" style="width:150px;">Fecha de abono:</button>
                      </div>
                      <input type="date" class="form-control" value="{{$fecha_actual}}" id="fecha_abono" name="fecha_abono" readonly>
                    </div>

                  </div>
                  <!-- /.box-body -->
                </div>
              </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary pull-right" onclick="registrarAbono();">Registrar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <div class="modal modal-cancel fade" id="modal-cancel">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cancelacion de cobro</h4>
              </div>
              <div class="modal-body">
                <form id="form_modal2" name="form_modal2">                
                <div class="box box-info">
                  <input type="hidden" name="subtotal_fpago" id="subtotal_fpago" class="form-control">
                  <input type="hidden" name="id_cuenta_asignada_e" id="id_cuenta_asignada_e" class="form-control">
                  <input type="hidden" name="cantidad_ini_fpago" id="cantidad_ini_fpago" class="form-control"
                  >
                  <input type="hidden" name="desc_pp_fpago" id="desc_pp_fpago" class="form-control"
                  >
                  <input type="hidden" name="desc_con_fpago" id="desc_con_fpago" class="form-control"
                  >
                  <input type="hidden" name="recargo_fpago" id="recargo_fpago" class="form-control"
                  >
                  
                  
                  <div class="box-body">                                                          
                   <div class="input-group">
                      <div class="input-group-btn">
                        <button type="button" class="btn btn-danger" style="width:150px;">Motivo:</button>
                      </div>
                      <input type="text" class="form-control" id="motivo_cancelacion" name="motivo_cancelacion" required>
                    </div>

                  </div>
                  <!-- /.box-body -->
                </div>
              </form>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-primary pull-left" data-dismiss="modal">Salir</button>
                <button type="button" class="btn btn-primary pull-right" onclick="guardaformcancelar();">Cancelar cobro</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        
@endsection("contenidoprincipal")
@section("scriptpie")
<script type="text/javascript">
  $(document).ready(function(){        
    $('#conttable').on('change', 'input[type=checkbox]', function() {
      var selected            = [];
      var  list = {
        'datos' :[]
      };
      var total_pagar = 0;
      $("input:checkbox[name='opciones[]']").each(function() {
        if (this.checked) {
          // agregas cada elemento.
          // a continuacion se forma un objeto JSON para pasar los datos seleccionados
          list.datos.push({
            "subtotal":$('#subtotal'+$(this).val()).val(),
            "id_alumno":$('#opcion_asignacion2').val(),
            "id_usuario":$('#id_usuario').val(),          
            "id_cuenta_asignada":$(this).val(),                                  
            "id_planpagoconceptos":$('#id_planpagoconceptos'+$(this).val()).val(),
            "cantidad_inicial":$('#mensualidad'+$(this).val()).val(),
            "descuento_pp":$('#descuento_pp'+$(this).val()).val(),
            "descuento_adicional":$('#descuento_condonacion'+$(this).val()).val(),
            "recargo":$('#recargo'+$(this).val()).val(),
            "fecha_pago":$('#fecha_actual').val(),

          });
          total_pagar = parseFloat(total_pagar) + parseFloat($('#subtotal'+$(this).val()).val());
        }
      });
      json = JSON.stringify(list); // aqui tienes la lista de objetos en Json
      var obj = JSON.parse(json); //Parsea el Json al objeto anterior.
      //alert(json);
      //alert(total_pagar);
      $('#total_pagar').val(total_pagar);
      //alert(obj.datos[0].id); Aca se obtiene los datos que se deseen...
    });
    //////////////
    $('#btn_registrar').click(function() {
      var selected            = [];
      var  list = {
        'datos' :[]
      };
      var total_pagar = 0;
      $("input:checkbox[name='opciones[]']").each(function() {
        if (this.checked) {
          // agregas cada elemento.
          // a continuacion se forma un objeto JSON para pasar los datos seleccionados
          list.datos.push({
            "subtotal":$('#subtotal'+$(this).val()).val(),
            "id_alumno":$('#opcion_asignacion2').val(),
            "id_usuario":$('#id_usuario').val(),          
            "id_cuenta_asignada":$(this).val(),                                  
            "id_planpagoconceptos":$('#id_planpagoconceptos'+$(this).val()).val(),
            "cantidad_inicial":$('#mensualidad'+$(this).val()).val(),
            "descuento_pp":$('#descuento_pp'+$(this).val()).val(),
            "descuento_adicional":$('#descuento_condonacion'+$(this).val()).val(),
            "recargo":$('#recargo'+$(this).val()).val(),
            "cantidad":$('#subtotal'+$(this).val()).val(),
            "forma_pago":$('#forma_pago').val(),
            "fecha_pago":$('#fecha_actual').val()
          });          
        }
      });
      json = JSON.stringify(list); // aqui tienes la lista de objetos en Json
      var obj = JSON.parse(json); //Parsea el Json al objeto anterior.
      //alert(json);
      //Guarda cobro y abre reporte de pdf, ficha de pago o recibo de pago
      $.ajax({
         url:"/cobros/guardarcobro/"+json,
         dataType:"json",
         async: false,
         contentType: "application/json",
         success:function(html){
            alert(html.data);
            for (var i = 0; i<list.datos.length;i++) {
                //alert("Subtotal: " + list.datos[i].subtotal);
                window.open('cobros/print-pdf/'+list.datos[i].id_cuenta_asignada+'/0','_blank');
             }
            actualizaTabla();            
            //
            //$("#formmodal")[0].reset();
           // $('#modal-success').modal('toggle');
         }
      })

    });
    ////////////////
     $("#opcion_asignacion2" ).change(function() {  
      //alert($('#fecha_actual').val());
      actualizaTabla();

    });
    

    $('.select2').select2({
      placeholder: "Ingrese el nombre",
    });
    $('.select2').select2().on('select2:open', function(e){
        $('.select2-search__field').attr('placeholder', 'Ingrese un texto');
    })
    number_format = function (number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);

        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

        return x1 + x2;
    }    
  });
  function cargaformpago(id_cuentaasignada){
    //alert(id_cuentaasignada);
    event.preventDefault();

    id_alumno             = $('#opcion_asignacion2').val();
    id_ciclo_escolar      = $('#id_session_ciclo').val();
    observaciones         = $('#descripcion_descuento').val();
    id_usuario            = $('#id_usuario').val();    
    $("#form_modal")[0].reset()

    $.ajax({
       url:"/cobros/parcialidad/"+id_cuentaasignada,
       async: false,
       dataType:"json",
       success:function(html){
        //alert("colocar cuanto a abonado");
        //  alert(html.abono[0].total_abonado);
        //  alert(html.abono[0].total_abonos);
          $('#cuenta_inicial').text($('#subtotal'+id_cuentaasignada).val());
          $('#subtotal_fpago').val($('#subtotal'+id_cuentaasignada).val());
          $('#id_cuentaasignada').val(id_cuentaasignada);
          $('#cantidad_ini_fpago').val(html.dato.cantidad);
          $('#desc_pp_fpago').val($('#descuento_pp'+id_cuentaasignada).val());
          $('#desc_con_fpago').val($('#descuento_condonacion'+id_cuentaasignada).val());
          $('#recargo_fpago').val($('#recargo'+id_cuentaasignada).val());  
          if(html.contabono==0){
            total_abonado = 0;
          }else{
            total_abonado = html.abono[0].total_abonado;
            $('#cantidad_abonada').val(html.abono[0].total_abonado);            
          }          
          $('#cantidad_restante').val($('#subtotal'+id_cuentaasignada).val() - total_abonado);  
       }
    })
  }
  function registrarAbono(){
    id_ciclo_escolar      = $('#id_session_ciclo').val();
    id_usuario            = $('#id_usuario').val();
    id_cuentaasignada     = $('#id_cuentaasignada').val();
    id_alumno             = $('#opcion_asignacion2').val();
    cantidad_abono        = $('#cantidad_abono').val();
    fecha_abono           = $('#fecha_abono').val();
    cantidad_ini_fpago    = $('#cantidad_ini_fpago').val();
    desc_pp_fpago         = $('#desc_pp_fpago').val();
    desc_con_fpago        = $('#desc_con_fpago').val();
    recargo_fpago         = $('#recargo_fpago').val();
    subtotal_fpago        = $('#subtotal_fpago').val();
    cantidad_abonada      = $('#cantidad_abonada').val();
    forma_pago            = $('#forma_pago').val();    
    cantidad_faltante     = subtotal_fpago - cantidad_abonada;
    residuo               = cantidad_faltante - cantidad_abono;
    status_abono          = 'abonado';
   // alert(cantidad_faltante);
    if(residuo==0){
      status_abono = 'pagado';
    }
    //observaciones         = $('#descripcion_descuento').val();    
    var data = {id_usuario:id_usuario,id_cuentaasignada : id_cuentaasignada, id_alumno : id_alumno ,cantidad_abono:cantidad_abono,fecha_abono:fecha_abono,cantidad_ini_fpago:cantidad_ini_fpago,desc_pp_fpago:desc_pp_fpago,desc_con_fpago:desc_con_fpago,recargo_fpago:recargo_fpago,subtotal_fpago:subtotal_fpago,residuo:residuo,status_abono:status_abono,forma_pago:forma_pago};
    json = JSON.stringify(data); 
   // alert(data.subtotal_fpago);
    if( $('#id_session_ciclo').val()<= 0){
      alert("Seleccione un ciclo escolar..");
      return false; 
    }
    if( $('#id_usuario').val()<= 0){
      alert("Inicie sesion..");
      return false; 
    }
    if(cantidad_abono > cantidad_faltante){
      alert("El pago excede el faltante...");
      return false; 
    }
    if(cantidad_abono < 1){
      alert("Ingrese el abono");
      $( "#cantidad_abono" ).focus();
      return false; 
    }
    
    $.ajax({
       url:"/cobroparcial/registroabono/"+json,
       dataType:"json",
       contentType: "application/json",
       success:function(html){
          alert(html.dato);
          window.open('cobros/print-pdf/'+id_cuentaasignada+'/0','_blank');
          actualizaTabla();
          $("#form_modal")[0].reset();
          $('#modal-info').modal('toggle');
       }
    })
  }
  function registrarDescuento(){
    id_cuentaasignada     = $('#id_cuenta_asignada').val();
    id_alumno             = $('#opcion_asignacion2').val();
    fecha_descuento       = $('#fecha_descuento').val();
    id_ciclo_escolar      = $('#id_session_ciclo').val();
    cantidad              = $('#cantidad_descuento').val();
    observaciones         = $('#descripcion_descuento').val();
    id_usuario            = $('#id_usuario').val();            
    

    if( $('#id_session_ciclo').val()<= 0){
      alert("Seleccione un ciclo escolar..");
      return false; 
    }
    if( $('#id_usuario').val()<= 0){
      alert("Inicie sesion..");
      return false; 
    }
    if( $('#id_cuenta_asignada').val().length<= 0){
      $('#id_cuenta_asignada').css("border", "solid 2px #FA5858");
      return false; 
    }
   /* if( $('#descripcion_descuento').val().length<= 0){
      $('#descripcion_descuento').css("border", "solid 2px #FA5858");
      return false; 
    }*/
    if( $('#cantidad_descuento').val().length<= 0){
      $('#cantidad_descuento').css("border", "solid 2px #FA5858");
      return false; 
    }
    if( $('#fecha_descuento').val().length<= 0){
      $('#fecha_descuento').css("border", "solid 2px #FA5858");
      return false; 
    }
    $.ajax({
       url:"/descuentos/guardar_descuento/"+id_cuentaasignada+"/"+id_alumno+"/"+fecha_descuento+"/"+cantidad+"/"+observaciones+"/"+id_usuario,
       dataType:"json",
       success:function(html){
          alert(html.data);
          actualizaTabla();
          $("#formmodal")[0].reset();
          $('#modal-success').modal('toggle');
       }
    })
    }
    function cargaformcancelar(id_cuentaasignada){
    	//alert("formcancelar"+id_cuentaasignada); //se modifico por el id de cobro 06-09-2022
      event.preventDefault();
      $("#form_modal2")[0].reset();      
      id_alumno             = $('#opcion_asignacion2').val();
      id_ciclo_escolar      = $('#id_session_ciclo').val();
      observaciones         = $('#descripcion_descuento').val();
      id_usuario            = $('#id_usuario').val();    
      //alert("ok");
     // alert(id_cuentaasignada);
      $.ajax({
         url:"/cobros/parcialidad/"+id_cuentaasignada,
         async: false,
         dataType:"json",
         success:function(html){
            $("#id_cuenta_asignada_e").val(html.cobro_consulta.id);
         }
      })
    }
    function guardaformcancelar(){
      id_cuentaasignada     = $('#id_cuenta_asignada_e').val(); //id_cobro 06-09-2022
      motivo_cancelacion    = $('#motivo_cancelacion').val();
      //$("#form_modal2")[0].reset();      
     // alert("guardaform"+id_cuentaasignada);

      if(motivo_cancelacion.length < 1){
        alert("Ingrese el motivo");
        $( "#motivo_cancelacion" ).focus();
        return false; 
      }
      $.ajax({
         url:"/cobros/cancelar/"+id_cuentaasignada+'/'+motivo_cancelacion,
         async: false,
         dataType:"json",
         success:function(html){
            alert(html.data);
            $('#modal-cancel').modal('toggle');
            actualizaTabla();
            //$("#formmodal2")[0].reset();
            
         }
      })

    }
    function actualizaTabla(){
      id = $('#opcion_asignacion2').val();
      $('#total_pagar').val(0);
      $('.select2').select2();
      $("#conttable").empty();
      $("#id_cuenta_asignada").empty();      
      $.ajax({
       url:"/cobros/"+id,
       dataType:"json",
       success:function(html){
          dias_limite_pronto_pago = 0;
          valor_descuento         = 0;
          valor_recargo           = 0;
          descuento_beca          = 0;
          $("#id_cuenta_asignada").append('<option value="">Seleccione</option>');          
          for (var i = 0; i < html.data.length; i++) 
          { 
            descuento     = 0;
            recargos      = 0;
            descuento_pp  = 0;
            subtotal      = 0;           
            if(html.politica.length > 0){           
              for (var k = 0; k < html.politica.length; k++) 
              {
                if(html.data[i].id_plan_pago == html.politica[k].id_plan_pagcta){
                  dias_limite_pronto_pago = html.politica[k].dias_limite_pronto_pago;
                  valor_descuento_pp = html.politica[k].valor_descuento;
                  valor_recargo = html.politica[k].valor_recargo;
                  break; //agreggue el break para salir cuando el for encuentre la concidencia de la politica, toma el valor de descuento y de recargos 08-01-2019
                }else{
                  dias_limite_pronto_pago = 0;
                  valor_descuento_pp = 0;
                  valor_recargo = 0;
                }
              }
            }else{
              dias_limite_pronto_pago = 0;
              valor_descuento_pp = 0;
              valor_recargo = 0;
            }
            
            id_planpagoconceptos = html.data[i].id_planpagoconceptos;
            if(html.data[i].porc_o_cant=='porcentaje'){
              descuento = (html.data[i].cant_desc_beca* html.data[i].cantidad)/100;
              signo_descuento = '- '+html.data[i].cant_desc_beca+' % ';
            } 
            else if(html.data[i].porc_o_cant=='cantidad'){
              descuento = html.data[i].cantidad - html.data[i].cant_desc_beca ;
              signo_descuento = '- $ '+html.data[i].cant_desc_beca;
            }else{
              descuento = 0;
              signo_descuento = '';
            }
            //alert(descuento);
            if(html.data[i].cant_desc_beca==null) {
              descuento_beca = 0;
            }else{
              descuento_beca = descuento;
            }
           // alert("Desc. Beca"+descuento_beca);
            descuento_condonacion = 0;
            for (var j = 0; j < html.descuento.length; j++) 
            {
              if(html.data[i].id == html.descuento[j].id_cuentaasignada){
                descuento_condonacion = html.descuento[j].cant_desc;
              }
            }
            //fechas de pago
            fecha_pago        =  html.data[i].periodo_inicio;
            fecha_actual      = $('#fecha_actual').val();
            //
            aF1 = fecha_pago.split("-");
            aF2 = fecha_actual.split("-");
            

            numMeses1 = (aF2[0]*12) + (aF2[1]*1);
            numMeses2 = (aF1[0]*12) + (aF1[1]*1);
            numMeses = numMeses1 - numMeses2;
            //alert(numMeses);
            if(numMeses>=1){
                recargos = numMeses * valor_recargo;          
            }
            //
            var fecha_actual = new Date(fecha_actual).getTime();
            var fecha_pago   = new Date(fecha_pago).getTime();
            var diff =  fecha_actual-fecha_pago;
            diferencia_dias = diff/(1000*60*60*24);

            if(diferencia_dias<dias_limite_pronto_pago)
            {
              if(html.data[i].cant_desc_beca<1){
                  descuento_pp = valor_descuento_pp;
              }else{
                descuento_pp = 0;
              }
            }
            
            if(html.data[i].status_cta=='pagado'){

              $.ajax({
                 url:"/cobros/cuentapagada/"+html.data[i].id,
                 dataType:"json",
                 success:function(html2){
                  subtotal   = parseFloat(html2.dato.cantidad_inicial+html2.dato.recargo);
                  descuentos = parseFloat(html2.dato.descuento_pp+html2.dato.descuento_adicional+descuento_beca);
                  subtotal   = parseFloat(html2.dato.cantidad);
                  
                  id_cta_asiganada    = html2.dato2.id_cta_asiganada;
                  desc_concepto       = html2.dato2.desc_concepto;
                  periodo_inicio      = html2.dato2.periodo_inicio;
                  periodo_vencimiento = html2.dato2.periodo_vencimiento;
                  cantidad_inicial    = html2.dato.cantidad_inicial;
                  descuento_1         = descuento;
                  descuento_pp        = html2.dato.descuento_pp;
                  descuento_condonacion = html2.dato.descuento_adicional;
                  recargos            = html2.dato.recargo;
                  status_cta          = "pagado";
                  /*Descuento de becas*/
                  if(html2.dato2.porc_o_cant=='porcentaje'){
                    descuento_beca = (html2.dato2.cant_desc_beca* html2.dato2.cantidad)/100;
                    signo_descuento = '- '+html2.dato2.cant_desc_beca+' % ';
                  } 
                  else if(html2.dato2.porc_o_cant=='cantidad'){
                    descuento_beca = html2.dato2.cantidad - html2.dato2.cant_desc_beca ;
                    signo_descuento = '- $ '+html2.dato2.cant_desc_beca;
                  }else{
                    descuento_beca = 0;
                    signo_descuento = '';
                  }
                  /*formato a fechas: */
                  let date = new Date(periodo_inicio);
                  let formatted_date = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                  let date2 = new Date(periodo_vencimiento);
                  let formatted_date2 = date2.getDate() + "-" + (date2.getMonth() + 1) + "-" + date2.getFullYear();
                  /*formato a fechas: */

                    $("#conttable").append('<tr data-id="'+i+'" class="success"><td><input type="checkbox"  name="opciones[]" value="'+id_cta_asiganada+'" onclick="return false;"></td><td>'+desc_concepto+ '<br> inicia: ' + formatted_date+ '<br>Vencimiento: ' + formatted_date2+ '</td><td>$ ' + cantidad_inicial+ ' <br>'+signo_descuento+'<br><b>'+ number_format(cantidad_inicial-descuento_beca,2, '.', ',') +'</b></td><td>$ ' + descuento_pp+ '</td><td>$ ' + descuento_condonacion+ '</td><td>$ ' + recargos+ '</td><td>$ '+number_format(subtotal,2,'.',',')+'<input type="hidden" id="subtotal'+id_cta_asiganada+'" value="'+subtotal+'" ></td><td><b>'+status_cta+'</b><br><a href="/cobros/print-pdf/'+id_cta_asiganada+'/0" target="_blank"><img src="images/pdf.png" alt="pdf" width="42" height="42"></a><br><a href="/cobros/print-pdf/'+id_cta_asiganada+'/1" target="_blank"><img src="images/pdf.png" alt="pdf" width="22" height="22"></a><?php if(Auth::user()->hasRole("admin")){ ?><br><button type="button" class="btn btn-block btn-danger btn-xs" data-toggle="modal" data-target="#modal-cancel" id="editModalBtn" name="editModalBtn" onclick="cargaformcancelar('+id_cta_asiganada+');">Cancelar</button><?php } ?></td></tr>');
                 }
              });
             

            }else{

              

              id_cta_asiganada    = html.data[i].id;
              desc_concepto       = html.data[i].desc_concepto;
              periodo_inicio      = html.data[i].periodo_inicio;
              periodo_vencimiento = html.data[i].periodo_vencimiento;
              cantidad_inicial    = parseFloat(html.data[i].cantidad);
              descuento_1         = descuento;
              descuento_pp        = descuento_pp;
              descuento_condonacion = descuento_condonacion;
              recargos            = recargos;
              status_cta          = html.data[i].status_cta;            

              if(recargos > 0){
                estilo_back = 'red';
                estilo_font = 'white';
                status_pago = 'vencido';
              }else{
                estilo_back = 'white';
                estilo_font = 'black';
                status_pago = 'activo';
                funcion_radio =  '';
              }
              if(html.data[i].status_cta=='abonado'){
                estilo_back = 'blue';
                estilo_font = 'white';
                status_pago = 'abonado';
                funcion_radio =  'onclick="return false;"';
                link_pago   = '<a href="/cobros/print-pdf/'+html.data[i].id+'/0" target="_blank"><img src="images/pdf.png" alt="pdf" width="30" height="30"></a><br><a href="/cobros/print-pdf/'+html.data[i].id+'/1" target="_blank"><img src="images/pdf.png" alt="pdf" width="15" height="15"></a>';
                recargos= 0;
                for (var l = 0; l < html.abonos.length; l++){
                  if(html.abonos[l].id_cuenta_asignada == id_cta_asiganada){
                    fecha_pago        =  html.data[i].periodo_inicio;
                    fecha_actual      = $('#fecha_actual').val();
                    //
                    aF1 = fecha_pago.split("-");
                    aF2 = html.abonos[l].fecha_pago.split("-");
                    

                    numMeses1 = (aF2[0]*12) + (aF2[1]*1);
                    numMeses2 = (aF1[0]*12) + (aF1[1]*1);
                    numMeses = numMeses1 - numMeses2;
                    if(numMeses>=1){
                        recargos = numMeses * valor_recargo;          
                    }
                  }
                }
                /*
                //fechas de pago
                  fecha_pago        =  html.data[i].periodo_inicio;
                  fecha_actual      = $('#fecha_actual').val();
                  //
                  aF1 = fecha_pago.split("-");
                  aF2 = fecha_actual.split("-");
                  

                  numMeses1 = (aF2[0]*12) + (aF2[1]*1);
                  numMeses2 = (aF1[0]*12) + (aF1[1]*1);
                  numMeses = numMeses1 - numMeses2;
                  //alert(numMeses);
                  if(numMeses>=1){
                      recargos = numMeses * valor_recargo;          
                  }
                  //
                */
              }else{
                funcion_radio =  '';
                link_pago     =  '';
              }

              subtotal            = parseFloat(html.data[i].cantidad) + parseFloat(recargos);
              descuentos          = parseFloat(descuento) + parseFloat(descuento_condonacion) + parseFloat(descuento_pp);
              subtotal            = parseFloat(subtotal) - parseFloat(descuentos);
              /*formato a fechas: */
                  let date = new Date(periodo_inicio);
                  let formatted_date = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
                  let date2 = new Date(periodo_vencimiento);
                  let formatted_date2 = date2.getDate() + "-" + (date2.getMonth() + 1) + "-" + date2.getFullYear();
              /*formato a fechas: */              
             $("#conttable").append('<tr data-id="'+i+'" style="background-color:'+estilo_back+'; color:'+estilo_font+';"><td><input type="checkbox" '+funcion_radio+' name="opciones[]" value="'+id_cta_asiganada+'"  ></td><td>' + desc_concepto+ '<br> inicia: ' + formatted_date+ '<br>Vencimiento: ' + formatted_date2+ '</td><td>$ ' + number_format(cantidad_inicial,2,'.',',')+ ' <br>' +signo_descuento + '<br> <b>$' + number_format(cantidad_inicial,2,'.',',')+ '</b><input type="hidden" id="mensualidad'+id_cta_asiganada+'" value="'+cantidad_inicial+'" > </td><td>$ '+descuento_pp+'<input type="hidden" id="descuento_pp'+id_cta_asiganada+'" value="'+descuento_pp+'" ></td><td><b>$ '+descuento_condonacion+'<input type="hidden" id="descuento_condonacion'+id_cta_asiganada+'" value="'+descuento_condonacion+'" ></b></td><td>$ '+number_format(recargos,2,'.',',')+'<input type="hidden" id="recargo'+id_cta_asiganada+'" value="'+recargos+'" ></td><td>$ '+number_format(subtotal,2,'.',',')+'<input type="hidden" id="subtotal'+id_cta_asiganada+'" value="'+subtotal+'" ></td><td><p class="text">'+status_pago+'</p><input type="hidden" id="id_planpagoconceptos'+id_cta_asiganada+'" value="'+id_planpagoconceptos+'">'+link_pago+'<button type="button" class="btn btn-block btn-primary btn-xs" data-toggle="modal" data-target="#modal-info" id="editModalBtn" name="editModalBtn" onclick="cargaformpago('+id_cta_asiganada+');">Abonar</button></td></tr>');
             $("#id_cuenta_asignada").append('<option value=' + id_cta_asiganada+ '>' + desc_concepto +' '+cantidad_inicial + '</option>');
            
            /* $("#conttable").append('<tr data-id="'+i+'" style="background-color:'+estilo_back+'; color:'+estilo_font+';"><td><input type="checkbox"  name="opciones[]" value="'+id_cta_asiganada+'"></td><td>' + desc_concepto+ '<br> inicia: ' + periodo_inicio+ '<br>Vencimiento: ' + periodo_vencimiento+ '</td><td>$ ' + cantidad_inicial+ ' <br>' +signo_descuento + '<br> <b>$' + (cantidad_inicial)+ '</b><input type="hidden" id="mensualidad'+id_cta_asiganada+'" value="'+cantidad_inicial+'" > </td><td>$ '+descuento_pp+'<input type="hidden" id="descuento_pp'+id_cta_asiganada+'" value="'+descuento_pp+'" ></td><td><b>$ '+descuento_condonacion+'<input type="hidden" id="descuento_condonacion'+id_cta_asiganada+'" value="'+descuento_condonacion+'" ></b></td><td>$ '+number_format(recargos,2,'.',',')+'<input type="hidden" id="recargo'+id_cta_asiganada+'" value="'+recargos+'" ></td><td>$ '+subtotal+'<input type="hidden" id="subtotal'+id_cta_asiganada+'" value="'+subtotal+'" ></td><td><p class="text-green">'+status_cta+'</p><br><input type="hidden" id="id_planpagoconceptos'+id_cta_asiganada+'" value="'+id_planpagoconceptos+'"></td></tr>');
              $("#id_cuenta_asignada").append('<option value=' + id_cta_asiganada+ '>' + desc_concepto +' '+cantidad_inicial + '</option>');*/
            }             
          } 
       }
      })
    }
</script>
@endsection("scriptpie")
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
        
        <!-- left column -->
        <form role="form" id="sample_form" name="sample_form" method="post" action=""  enctype="multipart/form-data" >
        @csrf
       <!-- <div class="col-md-12">
          
          <div class="box box-primary">
          
              <div class="box-body">
                <div class="row">                  
                  <div class="col-xs-3">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha inicial</label>
                      <input class="form-control" id="fecha1" name="fecha1" required type="date">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha final</label>
                      <input class="form-control" id="fecha2" name="fecha2" required type="date">
                    </div>
                  </div>
                </div>
                <div class="row">                  
                  <div class="col-xs-12">

                    <div class="form-group">
                      <br>                     
                      <button type="button" style="width:75px" id="btn_buscar" class="btn btn-warning">BUSCAR</button>
                      <button type="button" id="btn_registrar" style="width:60px" id="btn_registro" class="btn btn-success">RESET</button>
                      <br>
                      <br>
                      
                    </div>
                  </div>
                </div>                                                                
              </div>

          </div>

        </div> -->
        <!--/.col (left) -->
        <!-- right column -->    
        </form>
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-check"></i>
              <h3 class="box-title">Resultados de la consulta:</h3>
              <div style="float: right;"><a href="/cobros/exceldeudores/" target="_blank"><img src="/images/excel.png" alt="pdf" width="42" height="42"></a><a href="/cobros/reportedeudoresPDF/" target="_blank"><img src="/images/pdf.png" alt="pdf" width="42" height="42"></a></div>
              <div id="cont_btn_exp">
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="contenedorOpcAsig" id="contenedorOpcAsig">
              <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>#</th>
                <th>ALUMNO</th>
                <th>CONCEPTO</th>
                <th>VENCIMIENTO</th>
                <th>CANTIDAD</th>
                <th>BECA</th>
                <th>CANT - BECA</th>                
                <th>RECARGOS</th>
                <th>TOTAL</th>
                <th>STATUS</th>
              </tr>
              </thead>
              <tbody id="conttable" name="conttable">
                <?php $contador = 0;?>
                @foreach($deudores as $deudor)
                <?php
                  $cant_cbeca = 0;
                  if($deudor->porc_o_cant == 'cantidad'){
                    $cant_cbeca = $deudor->cantidad - $deudor->cant_beca;
                  }else{
                    $descuento_b = $deudor->cantidad * $deudor->cant_beca;
                    $descuento_b = $descuento_b / 100;
                    $cant_cbeca  = $deudor->cantidad - $descuento_b;
                  }

                  //se extrae la fecha y se pasa a un array, para poder realizar las operaciones de las fechas, se multiplica el año X 12, para saber la cantidad de meses que exiten en la fecha, se le suma el mes actual y se procede hacer lo mismo con la fecha2, para despues realizar la resta correspondiente.
                  $splitName  = explode('-', $deudor->periodo_vencimiento);
                  $splitName2 = explode('-', $fecha_actual);
                  $numMeses1  = ($splitName[0]*12) + ($splitName[1]*1);
                  $numMeses2  = ($splitName2[0]*12) + ($splitName2[1]*1);
                  $numMeses   = $numMeses2 - $numMeses1;

                  $recargos   = $numMeses*$deudor->valor_recargo;
                  $subtotal   = $cant_cbeca + $recargos;
                  $originalDate = $deudor->periodo_vencimiento;
                  $newDate = date("d-m-Y", strtotime($originalDate));
                ?>
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$deudor->apaterno}} {{$deudor->amaterno}} {{$deudor->nombres}}</td>
                  <td>{{$deudor->descripcion}}</td>
                  <td>{{$newDate}}</td>
                  <td>$ {{number_format($deudor->cantidad,2)}}</td>
                  <td>{{$deudor->desc_beca}}</td>
                  <td>$ {{number_format($cant_cbeca,2)}}</td>
                  <td>$ {{number_format($numMeses*$deudor->valor_recargo,2)}}</td>
                  <td>$ {{number_format($subtotal,2)}}</td>
                  <td style="color: red;"><b>vencido</b></td>
                </tr>      
                  <?php $contador = $loop->count;?>
                @endforeach                
              </tbody>
              <tfoot>
              <tr style="font-size:10pt;">
                <th>#</th>
                <th>ALUMNO</th>
                <th>CONCEPTO</th>
                <th>VENCIMIENTO</th>
                <th>CANTIDAD</th>
                <th>BECA</th>
                <th>CANT - BECA</th>                
                <th>RECARGOS</th>
                <th>TOTAL</th>
                <th>STATUS</th>              
              </tr>
              </tfoot>
            </table>
            Total de registros: {{$contador}}
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>

        <!--/.col (right) -->
      </div>

@endsection("contenidoprincipal")
@section("scriptpie")
<script type="text/javascript">
  $(document).ready(function(){


    //////////////
    $('#btn_buscar').click(function() {
      fecha1   = $('#fecha1').val();
      fecha2   = $('#fecha2').val();
      $("#conttable").empty();
      $("#cont_btn_exp").empty();
      if(fecha1.length < 1) {  
        alert("Fecha inicial obligatoria...");  
        $('#fecha1').focus(); 
        return false;  
      }  
      if(fecha2.length < 1) {  
        alert("Fecha final obligatoria...");  
        $('#fecha2').focus();  
        return false;  
      }  
      $.ajax({
        url:"/cobros/reporteCobros/"+fecha1+"/"+fecha2,
        dataType:"json",
        contentType: "application/json",
        success:function(html){
          for (var i = 0; i < html.cobros.length; i++) 
            { 
              if(html.cobros[i].porc_o_cant=='porcentaje'){
                signodesc = '%';
              }else{signodesc = '-';}
              if(html.cobros[i].codigo){
                codigo    = html.cobros[i].codigo;
                cant_beca = html.cobros[i].cant_beca;
              }else{
                codigo    = '0';
                cant_beca = '';
                signodesc = '';
              }
            
              total = html.cobros[i].cantidad_inicial - html.cobros[i].descuento_pp - html.cobros[i].descuento_adicional;
              total  = parseFloat(total);
              recargos = parseFloat(html.cobros[i].recargo);
              total2 = total + recargos;
              $("#conttable").append('<tr style="font-size:9pt;"><td>'+html.cobros[i].id_cobro+'</td><td>'+html.cobros[i].apaterno+' '+html.cobros[i].amaterno+' '+html.cobros[i].nombres+'</td><td>'+html.cobros[i].descripcion+'</td><td>'+html.cobros[i].fecha_pago+'</td><td>'+html.cobros[i].cantidad+'</td><td>'+codigo+'<br> '+cant_beca+ ' ' +signodesc+'</td><td>'+html.cobros[i].cantidad_inicial+'</td><td>'+html.cobros[i].descuento_pp+'</td><td>'+html.cobros[i].descuento_adicional+'</td><td>'+html.cobros[i].recargo+'</td><td>$ '+number_format(total2,2,'.',',') +'</td><td>'+html.cobros[i].status+'</td></tr>');
            }
            $("#cont_btn_exp").append('<a href="/cobros/reporteCobrosPDF/'+fecha1+'/'+fecha2+'" target="_blank" style="float:right;"><img src="/images/pdf.png" alt="pdf" width="42" height="42"></a>');
            $("#cont_btn_exp").append('<a href="/cobros/excel/'+fecha1+'/'+fecha2+'" target="_blank" style="float:right;"><img src="/images/excel.png" alt="pdf" width="42" height="42"></a>');  
        }
      });
    });
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
    $('#example1').DataTable({
      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
      },
      "search": {
            "addClass": 'form-control input-lg col-xs-12'
      },
      "fnDrawCallback":function(){
        $("input[type='search']").attr("id", "searchBox");            
        $('#searchBox').css("width", "400px").focus();
      }
    })
})
</script>
@endsection("scriptpie")

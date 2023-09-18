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
        <div class="col-md-2">
          <!-- general form elements -->
          <div class="box box-primary">
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">                  
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha inicial</label>
                      <input class="form-control" id="fecha1" name="fecha1" required type="date" value="{{$fecha_actual}}">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha final</label>
                      <input class="form-control" id="fecha2" name="fecha2" required type="date" value="{{$fecha_actual}}">
                    </div>
                  </div>
                </div>
                <div class="row">                  
                  <div class="col-xs-12">

                    <div class="form-group">
                      <br>                     
                      <button type="button" style="width:80px" id="btn_buscar" class="btn btn-warning">BUSCAR</button>
                      <button type="button" id="btn_registrar" style="width:80px" id="btn_registro" class="btn btn-success">LIMPIAR</button>
                      <br>
                      <br>
                      
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
        <div class="col-md-10">
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-check"></i>
              <h3 class="box-title">Resultados de la consulta:</h3>
              <div id="cont_btn_exp">
                
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="contenedorOpcAsig" id="contenedorOpcAsig">
              <table id="example1" class="table table-bordered table-condensed">
              <thead>
              <tr style="font-size:10pt;">
                <th>-</th>
                <th>ALUMNO</th>
                <th style="width:200px">CONCEPTO</th>
                <th>FECHA</th>
                <th>CANTIDAD</th>
                <th>BECA</th>
                <th>DESC. P.P.</th>
                <th>DESC. ADIC.</th>
                <th>RECARGOS</th>
                <th>TIPO DE PAGO</th>
                <th>TOTAL</th>
                <th>FORMA DE PAGO</th>
                <th>STATUS</th>
                <th>ACCION</th>
              </tr>
              </thead>
              <tbody id="conttable" name="conttable">

              </tbody>
              <tfoot>
              <tr style="font-size:10pt;">
                <th>#</th>
                <th>ALUMNO</th>
                <th>CONCEPTO</th>
                <th>FECHA</th>
                <th>CANTIDAD</th>
                <th>BECA</th>
                <th>DESC. P.P.</th>
                <th>DESC. ADIC.</th>
                <th>RECARGOS</th>
                <th>TIPO DE PAGO</th>
                <th>TOTAL</th>
                <th>FORMA DE PAGO</th>
                <th>STATUS</th>
                <th>ACCION</th>              
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
              }else{
                signodesc = '-';
              }
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
              cantidad_pagada = parseFloat(html.cobros[i].cantidad_pagada);
              total2 = total + recargos;
              /*formato a fechas: */
                let date = new Date(html.cobros[i].fecha_pago);
                let formatted_date = date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear();
              /*formato a fechas: */
              if(html.cobros[i].status=='cancelado'){
                estilo = 'background-color:red; color:white';
                linkcacelar = '';
              }else{
                estilo='';
                linkcacelar = '<a href="/cobros/cancelar/'+html.cobros[i].id_cobro+'/system">cancelar</a>';
              }
              $("#conttable").append('<tr style="font-size:9pt;'+estilo+'"><td>'+html.cobros[i].id_cobro+'</td><td>'+html.cobros[i].apaterno+' '+html.cobros[i].amaterno+' '+html.cobros[i].nombres+'</td><td>'+html.cobros[i].descripcion+'</td><td>'+formatted_date+'</td><td>$ '+number_format(parseFloat(html.cobros[i].cantidad),2,'.',',')+'</td><td>'+codigo+'<br> '+cant_beca+ ' ' +signodesc+'</td><td>'+html.cobros[i].descuento_pp+'</td><td>'+html.cobros[i].descuento_adicional+'</td><td>'+html.cobros[i].recargo+'</td><td>'+html.cobros[i].tipo_pago+'</td><td style="width:100px;">$ '+number_format(cantidad_pagada,2,'.',',') +'</td><td style="width:80px;">'+html.cobros[i].forma_pago+'</td><td>'+html.cobros[i].status+'</td><td>'+linkcacelar+'</td></tr>');
              	 
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
})


    

</script>
@endsection("scriptpie")
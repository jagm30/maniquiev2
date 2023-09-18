<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title></title>
    <style>
            /** 
            * Set the margins of the PDF to 0
            * so the background image will cover the entire page.
            **/
            @page {
                margin: 0cm 0cm;
            }

            /**
            * Define the real margins of the content of your PDF
            * Here you will fix the margins of the header and footer
            * Of your background image.
            **/
            body {
                margin-top:    4cm;
                margin-bottom: 1cm;
                margin-left:   1cm;
                margin-right:  1cm;
                font-family: "Tahoma", serif;
            }

            /** 
            * Define the width, height, margins and position of the watermark.
            **/
            #watermark {
                position: fixed;
                bottom:   0px;
                left:     0px;
                top:     0px;
                /** The width and height may change 
                    according to the dimensions of your letterhead
                **/
                width:    21cm;
                height:   28cm;

                /** Your watermark should be behind every content**/
                z-index:  -1000;
            }
            table {
               border-collapse: collapse;
               border:1px solid black;
              width: 100%;
            }

            th, td {
              text-align: left;
              padding: 5px;
              border:1px solid black;
            }

            /*tr:nth-child(even){background-color: #f2f2f2}*/

            th {
              background-color: #ECEDED;
              color: black;
            }
            .verticalText {
                writing-mode: vertical-lr;
                transform: rotate(180deg);
            }
        </style>
</head>
<body>
     <div id="watermark">
           <img src="{{ public_path().'/images/formato3.jpg' }}" width="100%" height="100%">             
      </div>     
      <p style="position: fixed;
                bottom:   0px;
                left:     38px;
                top:     117px;
                font-size: 10pt;">Reporte del {{date('d-m-Y', strtotime($fecha1))}}  al  {{date('d-m-Y', strtotime($fecha2))}}</p>  
        <main>          
          <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr style="font-size:7pt;">
                <th style="width:10px">#</th>
                <th style="width:135px">ALUMNO</th>
                <th style="width:135px">CONCEPTO</th>
                <th style="width:45px">FECHA</th>
                <th style="width:35px;font-size:5pt;">COLEGIATURA</th>
                <th style="width:35px">BECA</th>
                <th style="width:35px">DESC. P.P.</th>
                <th style="width:45px">DESC. ADIC.</th>
                <th style="width:35px">RECARGO</th>
                <th style="width:40px">PAGO</th>
                <th style="width:30px">FORMA DE PAGO</th>
              </tr>
              </thead>
              <tbody id="conttable" name="conttable">
                <?php $total_gral = 0; $contador=0;
                      $total_efectivo       = 0;
                      $total_transferencia  = 0;
                      $total_tarjeta        = 0;
                ?>
                @foreach ($cobros as $cobro) 
                      @if($cobro->porc_o_cant=='porcentaje')
                        <?php $signodesc = '%'; ?>
                        @else
                        <?php $signodesc = '-'; ?>
                      @endif                      
                      @if($cobro->codigo)
                        <?php $codigo    = $cobro->codigo; ?>
                        <?php $cant_beca = $cobro->cant_beca; ?>
                        @else
                        <?php $codigo    = '0'; ?>
                        <?php $cant_beca = ''; ?>
                        <?php $signodesc = ''; ?>
                      @endif
                      <?php //$total = $cobro->cantidad_inicial - $cobro->descuento_pp - $cobro->descuento_adicional;?>
                      <?php //$total2 = $total + $cobro->recargo;?>
                      @if($cobro->status!= 'cancelado')  
                        {{$total_gral += $cobro->cantidad_pagada}}
                      @endif  
                      @if($cobro->forma_pago=='efectivo' && $cobro->status!= 'cancelado')  
                        {{$total_efectivo += $cobro->cantidad_pagada}}
                      @endif
                      @if($cobro->forma_pago== 'trasferencia' && $cobro->status!= 'cancelado')  
                        {{$total_transferencia += $cobro->cantidad_pagada}}
                      @endif  
                      @if($cobro->forma_pago== 'tarjeta' && $cobro->status!= 'cancelado')  
                        {{$total_tarjeta += $cobro->cantidad_pagada}}
                      @endif                      
                      <tr style="font-size:7pt;@if($cobro->status== 'cancelado') background-color:red;color @endif" >
                        <td>{{$cobro->id_cobro}}</td>
                        <td>{{$cobro->apaterno}} {{$cobro->amaterno}} {{$cobro->nombres}}</td>
                        <td>{{$cobro->descripcion}}</td>
                        <td>{{date('d-m-Y', strtotime($cobro->fecha_pago))}}</td>
                        <td>$ {{number_format($cobro->cantidad,2)}}</td>
                        <td>{{$cobro->codigo}} <br>
                            {{$cant_beca}} {{$signodesc}}
                        </td>
                        <td>{{$cobro->descuento_pp}}</td>
                        <td>{{$cobro->descuento_adicional}}</td>
                        <td>{{$cobro->recargo}}</td>
                        <td><b>$ {{number_format($cobro->cantidad_pagada,2)}}</b></td>
                        <td>{{$cobro->forma_pago}} 
                          @if($cobro->status== 'cancelado')
                            {{$cobro->status}}
                          @endif </td>
                        {{$contador = $loop->count}}
                      </tr>                                                              
                @endforeach
                  <tr style="font-size:8pt;">
                    <td  colspan="9" style="text-align: right;"><b>Efectivo:</b></td>                    
                    <td colspan="2"><b>$ {{number_format($total_efectivo,2)}}</b></td>
                  </tr>
                  <tr style="font-size:8pt;">
                    <td  colspan="9" style="text-align: right;"><b>Transferencia:</b></td>                    
                    <td colspan="2"><b>$ {{number_format($total_transferencia,2)}}</b></td>
                  </tr>
                  <tr style="font-size:8pt;">
                    <td  colspan="9" style="text-align: right;"><b>Tarjeta:</b></td>                    
                    <td colspan="2"><b>$ {{number_format($total_tarjeta,2)}}</b></td>
                  </tr>
                  <tr style="font-size:8pt;">
                    <td  colspan="9" style="text-align: right;"><b>Total</b></td>                    
                    <td colspan="2"><b>$ {{number_format($total_gral,2)}}</b></td>
                  </tr>
              </tbody>
              <p><b>Total de registros: {{$contador}}</b></p>              
            </table>
        </main>         
        <!--<br><table style='page-break-after:always;'></br></table><br>   //Salto de pagina -->
</body>
</body>
</html>
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
                font-size: 10pt;">Reporte generado el: {{date('d-m-Y', strtotime($fecha_actual))}}</p> 
      <main>
         <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr style="font-size: 7pt">
                <th>#</th>
                <th style="width: 140px">ALUMNO</th>
                <th style="width: 120px">CONCEPTO</th>
                <th>VENCIMIENTO</th>
                <th>CANTIDAD</th>
                <th>BECA</th>
                <th style="width: 45px">CANT - BECA</th>                
                <th style="width: 45px">RECARGOS</th>
                <th style="width: 45px">TOTAL</th>
                
              </tr>
              </thead>
              <tbody id="conttable" name="conttable">
                <?php $contador = 0; $total=0;?>
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
                <tr style="font-size: 7pt">
                  <td>{{$loop->iteration}}</td>
                  <td>{{$deudor->apaterno}} {{$deudor->amaterno}} {{$deudor->nombres}}</td>
                  <td>{{$deudor->descripcion}}</td>
                  <td>{{$newDate}}</td>
                  <td>$ {{number_format($deudor->cantidad,2)}}</td>
                  <td>{{$deudor->desc_beca}}</td>
                  <td>$ {{number_format($cant_cbeca,2)}}</td>
                  <td>$ {{number_format($numMeses*$deudor->valor_recargo,2)}}</td>
                  <td>$ {{number_format($subtotal,2)}}</td>

                </tr>      
                  <?php $contador = $loop->count; $total= $total + $subtotal;?>
                @endforeach  
                <tr style="font-size: 7pt">
                  <td colspan="7" style="text-align: right;"><b>SUMATORIA TOTAL</b></td>
                  <td colspan="2">$ <b>{{number_format($total,2)}}</b></td>                  
                </tr>            
              </tbody>

            </table>
            Total de registros: {{$contador}}
        </main>         
        <!--<br><table style='page-break-after:always;'></br></table><br>   //Salto de pagina -->
</body>
</body>
</html>
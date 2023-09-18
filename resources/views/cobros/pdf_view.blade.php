<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>Estado de cuenta</title>
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
                margin-top:    3.5cm;
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
                width:    21.8cm;
                height:   28cm;

                /** Your watermark should be behind every content**/
                z-index:  -1000;
            }
            .page-break {
                page-break-after: always;
            }
        </style> 
</head>
<body>
  <?php
  $total_abonado = $total_pagado->total_pagado;
  $ultimo_abono  = 0;
  ?>
      @foreach($cobro as $cobroi)
        <?php          
          $descuentos_sub = 0;
          $subtotal = 0;
          $descuento_beca = 0;
          $signo_descuento = '';
          $descuento_beca = ($alumno->descuento_beca / 100)*$cobroi->cantidad_inicial;// se agrego esta linea para descontar el monto de becas, 14-04-2021
          //suma de recargos y descuentos
          $descuentos_sub = $cobroi->descuento_pp + $cobroi->descuento_adicional + $descuento_beca;
          $subtotal       = $cobroi->cantidad_inicial + $cobroi->recargo;
          $subtotal       = $subtotal - $descuentos_sub;

          if($loop->iteration == 1){
            $deuda_pendiente  = $subtotal - $total_abonado;
            $total_abonado    = $total_abonado - $cobroi->cantidad;
          }else{
            $deuda_pendiente  = $subtotal - $total_abonado;
            $total_abonado    = $total_abonado - $cobroi->cantidad;
          }
        ?>
     <div id="watermark">
          @if($bandera == 1)
          <img src="{{ public_path().'/images/formato2.jpg' }}" width="100%" height="100%">
          @endif
             
        </div>

        <main> 
            <p style="font:10pt; font-family: sans-serif ; position: fixed; left: 180mm; top:45mm; right: 0px; height: 300px;  color:red;">{{$cobroi->id}}</p>
            <p style="font:10pt;  font-family: sans-serif ; position: fixed; left: 40mm; top:37mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$datoalumno->apaterno}}  {{$datoalumno->amaterno}}  {{$datoalumno->nombres}}</p>
            <p style="font:10pt;  font-family: sans-serif ; position: fixed; left: 40mm; top:42mm; right: 0px; height: 150px;  color:#2F4F4F;">NIVEL: {{$alumno->denominacion_grado}} </p>      
            <p style="font:10pt;  font-family: sans-serif ; position: fixed; left: 40mm; top:47mm; right: 0px; height: 150px;  color:#2F4F4F;">MODALIDAD: {{$alumno->turno}} &nbsp;&nbsp;&nbsp; GRADO: {{$alumno->grado_semestre}} &nbsp;&nbsp;   GRUPO: {{$alumno->diferenciador_grupo}}   </p>                        
            <p style="font:10pt; font-family: sans-serif ; position: fixed; left: 168mm; top:50mm; right: 0px; height: 300px;  color:red;">{{date('d  -   m    -  Y', strtotime($cobroi->fecha_pago))}}</p>
            <p style="font:10pt; font-family: sans-serif ; position: fixed; left: 20mm; top: 68mm; right: 0px; height: 150px; width: 400px;  color:#2F4F4F;">{{$alumno->desc_concepto}}</p>
            <p style="font:10pt; font-family: sans-serif ; position: fixed; left: 133mm; top: 68mm; right: 0px; height: 150px;  color:#2F4F4F;">Pago normal
              <br>Recargos:
              <br>+Descuento PP 
              <br>-Condonacion
              <br>-Beca
              <br>-Subtotal</p>
              <p style="font:10pt; font-family: sans-serif ; position: fixed; left: 163mm; top: 68mm; right: 0px; height: 150px;  color:#2F4F4F;">$ {{number_format($cobroi->cantidad_inicial,2,'.',',')}}
              <br>$ {{$cobroi->recargo}}
              <br>$ {{$cobroi->descuento_pp}}
              <br>$ {{$cobroi->descuento_adicional}}
              <br>$ {{($alumno->descuento_beca / 100)*$cobroi->cantidad_inicial}}
              <br>$ {{number_format($subtotal,2,'.',',')}}</p>
            <p style="font:10pt;  font-family: sans-serif ; position: fixed; left: 20mm; top:112mm; right: 0px; height: 500px;  color:#2F4F4F;">{{Convertidor::numtoletras($cobroi->cantidad)}} </p>
            <p style="font:10pt;  font-family: sans-serif ; position: fixed; left: 165mm; top:112mm; right: 0px; height: 150px;  color:#2F4F4F;">$ {{number_format($cobroi->cantidad,2,'.',',')}} </p>
            @if($cobroi->tipo_pago == 'parcial')
              <p style="font:10pt; font-family: sans-serif ; position: fixed; left: 40mm; top: 88mm; right: 0px; height: 150px;  color:red;">Pago: {{$cobroi->tipo_pago}} <br> Pendiente: $ {{number_format($deuda_pendiente,2)}}<br>pago {{$loop->count - $loop->iteration + 1}} / {{$loop->count}}</p>
            @endif
        @if($bandera == 1)

        <!-- Copia de pago   -->
            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 40mm; top:176mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$datoalumno->apaterno}}  {{$datoalumno->amaterno}}  {{$datoalumno->nombres}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 180mm; top:180mm; right: 0px; height: 150px;  color:red;">{{$cobroi->id}}</p>            
            <p style="font:10pt;  font-family: sans-serif ; position: fixed; left: 40mm; top:181mm; right: 0px; height: 150px;  color:#2F4F4F;">NIVEL: {{$alumno->denominacion_grado}} </p>      
            <p style="font:10pt;  font-family: sans-serif ; position: fixed; left: 40mm; top:186mm; right: 0px; height: 150px;  color:#2F4F4F;">MODALIDAD: {{$alumno->turno}} &nbsp;&nbsp;&nbsp; GRADO: {{$alumno->grado_semestre}} &nbsp;&nbsp;   GRUPO: {{$alumno->diferenciador_grupo}}   </p>                        
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 168mm; top:190mm; right: 0px; height: 150px;  color:red;">{{date('d  -   m    -  Y', strtotime($cobroi->fecha_pago))}}</p>
            <p style="font:10pt; font-family: sans-serif ; position: fixed; left: 20mm; top: 210mm; right: 0px; height: 150px; width: 400px;  color:#2F4F4F;">{{$alumno->desc_concepto}}</p
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 134mm; top: 205mm; right: 0px; height: 150px;  color:#2F4F4F;">Pago normal
              <br>+Recargos:
              <br>-Descuento PP 
              <br>-Beca
              <br>-Condonacion
              <br>Subtotal</p>
              <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 165mm; top: 205mm; right: 0px; height: 150px;  color:#2F4F4F;">$ {{number_format($cobroi->cantidad_inicial,2,'.',',')}}
              <br>$ {{$cobroi->recargo}}
              <br>$ {{$cobroi->descuento_pp}}
              <br>$ {{$cobroi->descuento_adicional}}
              <br>$ {{($alumno->descuento_beca / 100)*$cobroi->cantidad_inicial}}
              <br>$ {{number_format($subtotal,2,'.',',')}}</p>
            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 20mm; top:250mm; right: 0px; height: 500px;  color:#2F4F4F;">{{ Convertidor::numtoletras($cobroi->cantidad)}} </p>
            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 165mm; top:250mm; right: 0px; height: 150px;  color:#2F4F4F;">$ {{number_format($cobroi->cantidad,2,'.',',')}} </p>
            @if($cobroi->tipo_pago == 'parcial')
              <p style="font:10pt; font-family: sans-serif ; position: fixed; left: 40mm; top: 227mm; right: 0px; height: 150px;  color:red;">Pago: {{$cobroi->tipo_pago}} <br> Pendiente: $ {{number_format($deuda_pendiente,2)}}<br>pago {{$loop->count - $loop->iteration + 1}} / {{$loop->count}}</p>
            @endif
        @endif    
        </main> 
          @if(!$loop->last)
            <div class="page-break"></div>
          @endif
        @endforeach
        <!--<br><table style='page-break-after:always;'></br></table><br>   //Salto de pagina -->
</body>
</body>
</html>
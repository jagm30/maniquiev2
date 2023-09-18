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
        </style>
</head>
<body>
     <div id="watermark">
             <img src="{{ public_path().'/images/formato2.jpg' }}" width="100%" height="100%">
        </div>

        <main> 
            

            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 20mm; top:48mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$datoalumno->apaterno}}  {{$datoalumno->amaterno}}  {{$datoalumno->nombres}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 180mm; top:40mm; right: 0px; height: 150px;  color:red;">{{$cobro->id}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 172mm; top:48mm; right: 0px; height: 150px;  color:red;">{{$cobro->fecha_pago}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 20mm; top: 65mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->desc_concepto}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 137mm; top: 65mm; right: 0px; height: 150px;  color:#2F4F4F;">Pago normal
              <br>Recargos:
              <br>Descuento PP 
              <br>Condonacion
              <br>Subtotal</p>
              <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 165mm; top: 65mm; right: 0px; height: 150px;  color:#2F4F4F;">$ {{number_format($cobro->cantidad_inicial,2,'.',',')}}
              <br>$ {{$cobro->recargo}}
              <br>$ {{$cobro->descuento_pp}}
              <br>$ {{$cobro->descuento_adicional}}
              <br>$ {{number_format($cobro->cantidad_inicial + $cobro->recargo - $cobro->descuento_pp - $cobro->descuento_adicional,2,'.',',')}}</p>
            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 20mm; top:110mm; right: 0px; height: 500px;  color:#2F4F4F;">{{Convertidor::numtoletras($cobro->cantidad_inicial + $cobro->recargo - $cobro->descuento_pp - $cobro->descuento_adicional)}} </p>
            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 165mm; top:110mm; right: 0px; height: 150px;  color:#2F4F4F;">$ {{number_format($cobro->cantidad_inicial + $cobro->recargo - $cobro->descuento_pp - $cobro->descuento_adicional,2,'.',',')}} </p>

        <!-- Copia de pago   -->
            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 20mm; top:185mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$datoalumno->apaterno}}  {{$datoalumno->amaterno}}  {{$datoalumno->nombres}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 180mm; top:180mm; right: 0px; height: 150px;  color:red;">{{$cobro->id}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 172mm; top:188mm; right: 0px; height: 150px;  color:red;">{{$cobro->fecha_pago}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 20mm; top: 205mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->desc_concepto}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 137mm; top: 205mm; right: 0px; height: 150px;  color:#2F4F4F;">Pago normal
              <br>Recargos:
              <br>Descuento PP 
              <br>Condonacion
              <br>Subtotal</p>
              <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 165mm; top: 205mm; right: 0px; height: 150px;  color:#2F4F4F;">$ {{number_format($cobro->cantidad_inicial,2,'.',',')}}
              <br>$ {{$cobro->recargo}}
              <br>$ {{$cobro->descuento_pp}}
              <br>$ {{$cobro->descuento_adicional}}
              <br>$ {{number_format($cobro->cantidad_inicial + $cobro->recargo - $cobro->descuento_pp - $cobro->descuento_adicional,2,'.',',')}}</p>
            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 20mm; top:250mm; right: 0px; height: 500px;  color:#2F4F4F;">{{ Convertidor::numtoletras($cobro->cantidad_inicial + $cobro->recargo - $cobro->descuento_pp - $cobro->descuento_adicional)}} </p>
            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 165mm; top:250mm; right: 0px; height: 150px;  color:#2F4F4F;">$ {{number_format($cobro->cantidad_inicial + $cobro->recargo - $cobro->descuento_pp - $cobro->descuento_adicional,2,'.',',')}} </p>
        </main> 

        <!--<br><table style='page-break-after:always;'></br></table><br>   //Salto de pagina -->
</body>
</body>
</html>
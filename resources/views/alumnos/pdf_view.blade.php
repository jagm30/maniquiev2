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
                width:    21cm;
                height:   28cm;

                /** Your watermark should be behind every content**/
                z-index:  -1000;
            }
        </style>
</head>
<body>
     <div id="watermark">
             <img src="{{ public_path().'/images/formato.jpg' }}" width="100%" height="100%">
        </div>

        <main> 
            <?php
                $originalDate = $alumno->created_at;
                $fecha_creacion = date("d-m-Y", strtotime($originalDate));

                $originalDate2 = $alumno->fecha_nac;
                $fecha_nacimiento = date("d-m-Y", strtotime($originalDate2));
            ?>

            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 55mm; top:73mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$fecha_creacion}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 140mm; top: 69mm; right: 0px; height: 150px;  color:#2F4F4F;"></p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 194mm; top: 69mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->genero}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 55mm; top: 76mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->apaterno}} {{$alumno->amaterno}} {{$alumno->nombres}}</p>
            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 55mm; top:83mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$fecha_nacimiento}} </p>
            <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 140mm; top:83mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->curp}} </p>
            
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 55mm; top: 90mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->domicilio}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 33mm; top: 97mm; right: 0px; height: 150px;  color:#2F4F4F;"></p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 55mm; top: 97mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->ciudad}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 160mm; top: 97mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->estado}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 55mm; top: 105mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->telefono}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 160mm; top: 105mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->telefono2}}</p>


            <!-- SEGUNDA COLUMNA -->
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 55mm; top: 126mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->nombre_tutor}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 45mm; top: 133mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->parentesco_tutor}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 160mm; top: 133mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->telefono_tutor}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 55mm; top: 147mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->razon_social}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 44mm; top: 154mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->rfc}}</p>
            <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 115mm; top: 154mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$alumno->uso_cfdi}}</p>
           
           <!-- -->
           <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 35mm; top: 170mm; right: 0px; height: 150px;  color:#2F4F4F;">{{$grupoinscrito->denominacion_grado}}</p>

           <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 200mm; top: 170mm; right: 0px; height: 150px;  color:#2F4F4F;">@if($grupoinscrito->turno=='Semiescolarizado') X @endif</p>
           <p style="font:10pt; font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 160mm; top: 170mm; right: 0px; height: 150px;  color:#2F4F4F;">@if($grupoinscrito->turno=='Escolarizado') X @endif</p>
        </main> 

        <!--<br><table style='page-break-after:always;'></br></table><br>   //Salto de pagina -->
</body>
</body>
</html>
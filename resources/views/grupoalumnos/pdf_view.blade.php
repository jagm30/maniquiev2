<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title>{{ $title }}</title>
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
                font-size: 12px;
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
    <main> 
       <!-- <p style="font:10pt;  font-family: Tahoma,Verdana,Segoe,sans-serif ; position: fixed; left: 8mm; top:93mm; right: 0px; height: 150px;  color:#2F4F4F;">34 - 34 - 34</p>-->

        <h2  align="center">{{ $nomgrupo->grado_semestre}}  {{ $nomgrupo->diferenciador_grupo}} {{$nomgrupo->denominacion_grado}}<br>  Modalida: {{$nomgrupo->turno}}</h2>
        <div id="contenido" class="contenido">
            <table width="100%" style="width:100%" >             
                <tr>
                    <th style="width:0.5cm;" rowspan="2">#</th>
                    <th style="width:6.5cm;" rowspan="2">NOMBRE COMPLETO</th>
                    <th style="width:11cm;" colspan="20"> <B>REGISTRO DE ASISTENCIA</B> </th>
                    
                </tr>
                <tr>
                    
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                    <th style="height:1.5cm;"></th>
                </tr>
                                  
                @foreach($alumno as $alumn)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{$alumn->full_name}} </td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                @endforeach         
            </table>        
        </div>
    </main> 
        <!--<br><table style='page-break-after:always;'></br></table><br>   //Salto de pagina -->
</body>
</body>

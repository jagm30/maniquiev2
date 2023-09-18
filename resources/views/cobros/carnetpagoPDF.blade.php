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
             <img src="{{ public_path().'/images/formato3.jpg' }}" width="100%" height="100%">
        </div>

        <main> 
            <h4  align="center">{{ $title}} | {{ $datoalumno->apaterno }} {{ $datoalumno->amaterno }} {{ $datoalumno->nombres }}</h4>
        <div id="contenido" class="contenido">
            <table width="100%" style="width:100%" >             
                <tr>                    
                    <th>#</th>
                    <th>Concepto de pago</th>
                    <th>Costo</th>
                    <th>Vencimiento</th>
                    <th>Status</th>                    
                </tr>                                            
                @foreach($alumno as $alumn)
                <?php 
                    $originalDate = $alumn->periodo_vencimiento;
                    $newDate = date("d-m-Y", strtotime($originalDate));
                ?>
                <tr style="font-size:10pt;">
                    <td>{{ $loop->iteration }}</td>
                    <td >{{$alumn->desc_concepto}} </td>
                    <td>$ {{number_format($alumn->cantidad,2)}} <br>
                      @if($alumn->codigo != '')
                        @if($alumn->porc_o_cant == 'porcentaje')
                        {{$alumn->codigo}} <br>
                        <b>$ {{number_format(($alumn->cantidad * $alumn->descuento_beca)/100,2)}}</b>
                        @endif
                      @endif          
                    </td>
                    <td>{{$newDate}} </td>
                    <td>{{$alumn->status_cta}} </td>
                </tr>
                @endforeach         
            </table>        
        </div>

        </main> 

        <!--<br><table style='page-break-after:always;'></br></table><br>   //Salto de pagina -->
</body>
</body>
</html>
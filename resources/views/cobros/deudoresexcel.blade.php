<table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr >
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

            </table>
            
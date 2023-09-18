<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr >
                <th>#</th>
                <th>ALUMNO</th>
                <th>CONCEPTO</th>
                <th>FECHA</th>
                <th>CANTIDAD</th>
                <th>BECA</th>
                <th>DESC. P.P.</th>
                <th>DESC. ADIC.</th>
                <th>RECARGOS</th>
                <th>TOTAL</th>
                <th>FORMA DE PAGO</th>
              </tr>
              </thead>
              <tbody id="conttable" name="conttable">
                <?php 
                  $total_gral = 0;
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
                      <?php $total = $cobro->cantidad_inicial - $cobro->descuento_pp - $cobro->descuento_adicional;?>
                      <?php $total2 = $total + $cobro->recargo;?>
                      @if($cobro->status!= 'cancelado')  
                        {{$total_gral += $cobro->cantidad_pagada}}
                      @endif 
                      @if($cobro->forma_pago=='efectivo' && $cobro->status!= 'cancelado' )  
                        {{$total_efectivo += $cobro->cantidad_pagada}}
                      @endif
                      @if($cobro->forma_pago== 'trasferencia' && $cobro->status!= 'cancelado')  
                        {{$total_transferencia += $cobro->cantidad_pagada}}
                      @endif  
                      @if($cobro->forma_pago== 'tarjeta' && $cobro->status!= 'cancelado')  
                        {{$total_tarjeta += $cobro->cantidad_pagada}}
                      @endif 
                      <tr>
                        <td @if($cobro->status== 'cancelado') style="background-color: #FF0000;" @endif>{{$cobro->id_cobro}}</td>
                        <td @if($cobro->status== 'cancelado') style="background-color: #FF0000;" @endif>{{$cobro->apaterno}} {{$cobro->amaterno}} {{$cobro->nombres}}</td>
                        <td @if($cobro->status== 'cancelado') style="background-color: #FF0000;" @endif>{{$cobro->descripcion}}</td>
                        <td @if($cobro->status== 'cancelado') style="background-color: #FF0000;" @endif>{{date('d-m-Y', strtotime($cobro->fecha_pago))}}</td>
                        <td @if($cobro->status== 'cancelado') style="background-color: #FF0000;" @endif>${{number_format($cobro->cantidad)}}</td>
                        <td @if($cobro->status== 'cancelado') style="background-color: #FF0000;" @endif>{{$cobro->codigo}} <br>
                            {{$cant_beca}} {{$signodesc}}
                        </td>
                        <td @if($cobro->status== 'cancelado') style="background-color: #FF0000;" @endif>${{$cobro->descuento_pp}}</td>
                        <td @if($cobro->status== 'cancelado') style="background-color: #FF0000;" @endif>${{number_format($cobro->descuento_adicional)}}</td>
                        <td @if($cobro->status== 'cancelado') style="background-color: #FF0000;" @endif>${{$cobro->recargo}}</td>
                        <td @if($cobro->status== 'cancelado') style="background-color: #FF0000;" @endif><b>${{number_format($cobro->cantidad_pagada,2)}}</b></td>
                        <td @if($cobro->status== 'cancelado') style="background-color: #FF0000;" @endif>{{$cobro->forma_pago}}
                          @if($cobro->status== 'cancelado')
                            ({{$cobro->status}})
                          @endif
                        </td>
                      </tr>                                                                 
                @endforeach
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Efectivo:</b></td>
                    <td><b>$ {{number_format($total_efectivo,2)}}</b></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Transferencia:</b></td>
                    <td><b>$ {{number_format($total_transferencia,2)}}</b></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Tarjeta:</b></td>
                    <td><b>$ {{number_format($total_tarjeta,2)}}</b></td>
                    <td></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>Total:</b></td>
                    <td><b>$ {{number_format($total_gral,2)}}</b></td>
                    <td></td>
                  </tr>
              </tbody>

            </table>
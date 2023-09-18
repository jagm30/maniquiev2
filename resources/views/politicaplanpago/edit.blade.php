@extends("../layout.plantilla")

@section("encabezado")
  <a href="{{ route('politicaplanpago.index') }}"><button type="button" class="btn btn-success">Políticas</button></a>
@endsection("encabezado")
  
@section("subencabezado")
  
@endsection("subencabezado")

@section("contenidoprincipal")
  <div class="row">
        <!-- left column -->
        <form role="form" method="post" action="/politicaplanpago/{{$politicaplanpago->id}}" >
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="PUT">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editar política</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">                  
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Plan de pagos</label>
                      <select class="form-control" id="id_plan_pago" name="id_plan_pago" required>
                        <option value="">Seleccione una opcion</option>
                        @foreach($planpagos as $planpago)
                          <option value="{{$planpago->id}}" {{($politicaplanpago->id_plan_pago==$planpago->id) ? 'selected' : ''}}>{{ $planpago->descripcion  }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Días limite de pronto pago</label>
                      <input placeholder="Dias" class="form-control" required type="number" name="dias_limite_pronto_pago" id="dias_limite_pronto_pago" value="{{ $politicaplanpago->dias_limite_pronto_pago }}" >
                    </div>
                  </div>
                </div>
                <div class="row">                  
                  <div class="col-xs-6">   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Cantidad o porcentaje de Desc.</label>
                      <select class="form-control" id="cant_porc_descuento" name="cant_porc_descuento" required>
                        <option value="cantidad" {{($politicaplanpago->cant_porc_descuento=='cantidad') ? 'selected' : ''}}>cantidad</option>
                      </select>
                    </div>   
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Valor de descuento:</label>
                      <input type="number" step="any" class="form-control" id="valor_descuento" name="valor_descuento" required placeholder="Descuento" value="{{ $politicaplanpago->valor_descuento }}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Cantidad o porcentaje de recargos:</label>
                      <select class="form-control" id="cant_porc_recargo" name="cant_porc_recargo" required>
                        <option value="cantidad" {{($politicaplanpago->cant_porc_recargo=='cantidad') ? 'selected' : ''}}>cantidad</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Costo de recargos x mes</label>
                      <input type="number" step="any" class="form-control" id="valor_recargo" name="valor_recargo" required placeholder="Recargos" value="{{ $politicaplanpago->valor_recargo }}">
                    </div>
                  </div>
                </div> 
                <div class="row">
                  <div class="col-xs-6">
                    
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <br>
                      <button type="submit" class="btn btn-primary">Guardar</button>
                      <a href="{{ route('politicaplanpago.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
                        @if($errors->any())
                          @foreach($errors->all() as $error)
                            <h3>{{$error}}</h3>
                          @endforeach
                        @endif
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
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body"> 
                                                             
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
              </div>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->         
          <!-- /.box -->
        </div>
        </form>
        <!--/.col (right) -->
      </div>

@endsection("contenidoprincipal")
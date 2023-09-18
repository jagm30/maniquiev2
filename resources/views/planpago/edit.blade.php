@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('planpago.index') }}"><button type="button" class="btn btn-success">Planes de pago</button></a>
@endsection("encabezado")

@section("subencabezado")
 
@endsection("subencabezado")

@section("contenidoprincipal")
  <div class="row">
        <!-- left column -->
        <form role="form" method="post" action="/planpago/{{$planpago->id}}"  enctype="multipart/form-data" >
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editar plan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Código</label>
                      <input type="text" class="form-control" id="codigo" name="codigo" required placeholder="Código" value="{{ $planpago->codigo }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Descripción</label>
                      <input type="text" class="form-control" id="descripcion" name="descripcion" required placeholder="Descripción" value="{{ $planpago->descripcion }}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Periodicidad</label>
                      <select class="form-control" id="periocidad" name="periocidad"  placeholder="Periodicidad" required>
                        <option {{($planpago->periocidad=='MENSUAL') ? 'selected' : ''}}>MENSUAL</option>
                        <option {{($planpago->periocidad=='BIMESTRAL') ? 'selected' : ''}}>BIMESTRAL</option>
                      </select>
                    </div>
                  </div>
                 <!-- <div class="col-xs-6">   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Impuesto</label>
                      <input type="text" class="form-control" id="impuesto" name="impuesto" required placeholder="Impuesto">
                    </div>   
                  </div>-->
                </div>
                <div class="row">
                  <div class="col-xs-6">
                   <!-- <div class="form-group">
                      <label>Unidad de medida</label>
                      <input type="text" class="form-control" id="unidad_medida" name="unidad_medida" required placeholder="Unidad de medida">
                    </div>-->
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <br>
                      <button type="submit" class="btn btn-primary">Guardar</button>
                      <a href="{{ route('planpago.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
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
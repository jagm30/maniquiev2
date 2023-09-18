@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('becas.index') }}"><button type="button" class="btn btn-success">Conceptos de becas</button></a>
@endsection("encabezado")

@section("subencabezado")
  
@endsection("subencabezado")

@section("contenidoprincipal")
  <div class="row">
        <!-- left column -->
        <form role="form" method="post" action="/becas/{{$becas->id}}"  enctype="multipart/form-data" >
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editar beca</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Código</label>
                      <input type="text" class="form-control" id="codigo" name="codigo" required placeholder="Código" value="{{ $becas->codigo }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Descripción</label>
                      <input type="text" class="form-control" id="descripcion" name="descripcion" required placeholder="Descripción" value="{{ $becas->descripcion }}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Porcentaje o cantidad</label>
                      <select class="form-control" id="porc_o_cant" name="porc_o_cant" required="">
                        <option value="porcentaje" {{($becas->porc_o_cant =='porcentaje') ? 'selected' : ''}}>porcentaje</option>
                        <option value="cantidad" {{($becas->porc_o_cant =='cantidad') ? 'selected' : ''}}>cantidad</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Valor de descuento</label>
                      <input type="text" class="form-control" id="cantidad" name="cantidad" required placeholder="Impuesto" value="{{ $becas->cantidad }}">
                    </div>   
                  </div>
               <!--   <div class="col-xs-6">   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nivel al que aplica la beca</label>
                      <select class="form-control" id="id_nivel" name="id_nivel" required >
                        <option value="">Seleccione</option>
                        @foreach($nivelescolars as $nivelescolar)
                          <option value="{{ $nivelescolar->id }}" {{($becas->id_nivel ==$nivelescolar->id) ? 'selected' : ''}}>{{ $nivelescolar->denominacion_grado }}</option>
                        @endforeach
                      </select>
                    </div>   
                  </div> -->
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
                      <a href="{{ route('becas.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
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
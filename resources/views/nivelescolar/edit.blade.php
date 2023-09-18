@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('nivelescolar.index') }}"><button type="button" class="btn btn-success">Niveles escolares</button></a>
@endsection("encabezado")

@section("subencabezado")
  <a href="{{ route('nivelescolar.create') }}"><button type="button" class="btn btn-info">Agregar nivel</button></a>
@endsection("subencabezado")

@section("contenidoprincipal")
  <div class="row">
        <!-- left column -->
        <form role="form" method="post" action="/nivelescolar/{{$nivelescolar->id}}"  enctype="multipart/form-data" >
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editar registro</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Clave identificador</label>
                      <input type="text" class="form-control" id="clave_identificador" name="clave_identificador" required value="{{ $nivelescolar->clave_identificador }}" placeholder="Clave identificador">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Acuerdo / Incorporación</label>
                      <input type="text" class="form-control" id="acuerdo_incorporacion" name="acuerdo_incorporacion" required value="{{ $nivelescolar->acuerdo_incorporacion }}" placeholder="Acuerdo / Incoporación">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha de incorporación</label>
                      <input type="date" class="form-control" id="fecha_incorporacion" name="fecha_incorporacion" required value="{{ $nivelescolar->fecha_incorporacion }}" >
                    </div>
                  </div>
                  <div class="col-xs-6">   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Zona escolar</label>
                      <input type="text" class="form-control" id="zona_escolar" name="zona_escolar" required value="{{ $nivelescolar->zona_escolar }}" placeholder="Zona escolar">
                    </div>   
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Descripción del nivel</label>
                      <input type="text" class="form-control" id="denominacion_grado" name="denominacion_grado" required value="{{ $nivelescolar->denominacion_grado }}" placeholder="Descripción del nivel">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <br>
                      <button type="submit" class="btn btn-primary">Guardar</button>
                      <a href="{{ route('nivelescolar.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
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
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
        <form role="form" method="post" action="/alumnos" >
        @csrf
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Registro nuevo</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Apellido paterno</label>
                      <input type="text" class="form-control" id="apaterno" name="apaterno" readonly placeholder="A. paterno" value="{{ $alumno->apaterno }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Apellido materno</label>
                      <input type="text" class="form-control" id="amaterno" name="amaterno" readonly placeholder="A. materno" value="{{ $alumno->amaterno }}">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Nombres</label>
                  <input type="text" class="form-control" id="nombres" name="nombres" readonly placeholder="Nombre" value="{{ $alumno->nombres }}">
                </div>   
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Genero</label>
                      <select class="form-control" id="genero" name="genero"> readonly
                        <option>Hombre</option>
                        <option>Mujer</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha de nacimiento</label>
                      <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" readonly value="{{ $alumno->fecha_nac }}">
                    </div>
                  </div>
                </div> 
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Lugar de nacimiento</label>
                      <input type="text" class="form-control" id="lugar_nac" name="lugar_nac" readonly value="{{ $alumno->lugar_nac }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Estado civil</label>
                      <input type="text" class="form-control" id="edo_civil" name="edo_civil" readonly value="{{ $alumno->edo_civil }}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">CURP</label>
                      <input type="text" class="form-control" id="curp" name="curp" readonly placeholder="Clave unica de registro poblacional" value="{{ $alumno->curp }}">
                    </div> 
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">email</label>
                      <input type="text" class="form-control" id="email" name="email" readonly placeholder="correo electronico" value="{{ $alumno->email }}">
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
                <div class="form-group">
                  <label for="exampleInputPassword1">Domicilio</label>
                  <input type="text" class="form-control" id="domicilio" name="domicilio" readonly placeholder="domicilio" value="{{ $alumno->domicilio }}">
                </div>         
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Ciudad</label>
                      <input type="text" class="form-control" id="ciudad" name="ciudad" readonly placeholder="Ciudad" value="{{ $alumno->ciudad }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Estado</label>
                      <input type="text" class="form-control" id="estado" name="estado" readonly placeholder="Estado" value="{{ $alumno->estado }}">
                    </div>
                  </div>
                </div>                
                <div class="row">                  
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">C.P.</label>
                      <input type="text" class="form-control" id="cp" name="cp" readonly placeholder="codigo postal" value="{{ $alumno->cp }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Telefono</label>
                      <input type="text" class="form-control" id="telefono" name="telefono" readonly placeholder="telefono" value="{{ $alumno->telefono }}">
                    </div>
                  </div>
                </div>                
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" id="status" name="status" readonly value="{{ $alumno->status }}">
                        <option>activo</option>
                        <option>aspirante</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputFile">File input</label>
                      <input type="file" id="exampleInputFile">

                      <p class="help-block">Example block-level help text here.</p>
                    </div> 
                  </div>
                </div>                                               
              </div>
              <!-- /.box-body -->
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->         
          <!-- /.box -->
        </div>
        </form>
        <form role="form" method="post" action="/alumnos/{{ $alumno->id}}" >
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="DELETE">
          <input type="submit" value="Eliminar registro">
        </form>
        <!--/.col (right) -->
      </div>

@endsection("contenidoprincipal")
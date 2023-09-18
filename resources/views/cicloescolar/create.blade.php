@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('cicloescolar.index') }}"><button type="button" class="btn btn-success">Ciclos escolares</button></a>
@endsection("encabezado")

@section("subencabezado")
  <a href="{{ route('cicloescolar.create') }}"><button type="button" class="btn btn-info">Agregar ciclo</button></a>
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
        <!-- left column -->
        <form role="form" method="post" action="/cicloescolar"  enctype="multipart/form-data" >
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
               <!-- <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Año inicio</label>
                      <input type="text" class="form-control" id="anio_inicio" name="anio_inicio" required placeholder="Año de inicio">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Año final</label>
                      <input type="text" class="form-control" id="anio_fin" name="anio_fin" required placeholder="Año de conclusion">
                    </div>
                  </div>
                </div> -->
                <div class="row">
                  <!--<div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Periodo</label>
                      <input type="text" class="form-control" id="periodo" name="periodo" required placeholder="Periodo">
                    </div>
                  </div>-->
                  <div class="col-xs-6">   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Descripción del ciclo</label>
                      <input type="text" class="form-control" id="descripcion" name="descripcion" required placeholder="Descripción del ciclo">
                    </div>   
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Denominación del periodo (opcional)</label>
                      <select class="form-control" id="denominacion" name="denominacion" required>
                        <option value="Año">Año</option>
                        <option value="Semestre">Semestre</option>
                        <option value="Bimestre">Bimestre</option>
                        <option value="Cuatrimestre">Cuatrimestre</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">            
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha de inicio</label>
                      <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" required>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha de conclusión</label>
                      <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" required>
                    </div>
                  </div>
                </div> 
                <div class="row">                  
                  <div class="col-xs-6">
                    <div class="form-group">
                      <br>
                      <button type="submit" class="btn btn-primary">Registrar</button>
                        @if($errors->any())
                          @foreach($errors->all() as $error)
                            <h3>{{$error}}</h3>
                          @endforeach
                        @endif
                    </div>                     
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <br>
                      <a href="{{ route('cicloescolar.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
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
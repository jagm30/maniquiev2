@extends("../layout.plantilla")

@section("encabezado")
  <a href="{{ route('grupos.index') }}"><button type="button" class="btn btn-success">Grupos</button></a>
@endsection("encabezado")
  
@section("subencabezado")

@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
        <!-- left column -->
        <form role="form" method="post" action="/grupos"  enctype="multipart/form-data" >
        @csrf
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Grupo nuevo</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Ciclo escolar</label>
                      <select class="form-control" id="id_ciclo_escolar" name="id_ciclo_escolar" required>
                        <option value="">Seleccione una opción</option>
                        @foreach($cicloescolars as $cicloescolar)
                          <option value="{{$cicloescolar->id}}">{{ $cicloescolar->descripcion  }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <!--<div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Cupo maximo</label>
                      
                    </div>
                  </div>-->
                </div>
                <input type="hidden" class="form-control" id="cupo_maximo" name="cupo_maximo" required placeholder="cupo maximo del grupo" value="25">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Modalidad</label>
                      <select id="turno" name="turno" class="form-control">
                        <option>Escolarizado</option>
                        <option>Semiescolarizado</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nivel escolar</label>
                      <select class="form-control" id="id_nivel_escolar" name="id_nivel_escolar" required>
                        <option value="">Seleccione una opción</option>
                        @foreach($nivelescolars as $nivelescolar)
                          <option value="{{$nivelescolar->id}}">{{ $nivelescolar->denominacion_grado  }}</option>
                        @endforeach
                      </select>
                    </div>   
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Grado o semestre</label>
                      <input type="text" class="form-control" id="grado_semestre" name="grado_semestre" required placeholder="Grado o semestre">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Grupo/Descripción</label>
                      <input type="text" class="form-control" id="diferenciador_grupo" name="diferenciador_grupo" required placeholder="Ejemplo: A, B, Amarillo, etc.">
                    </div>
                  </div>
                </div> 
                <div class="row">
                  <div class="col-xs-6">
                    
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <br>
                      <button type="submit" class="btn btn-primary">Registrar</button>
                      <a href="{{ route('grupos.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
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
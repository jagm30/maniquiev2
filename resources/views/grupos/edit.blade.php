@extends("../layout.plantilla")

@section("encabezado")
  <a href="{{ route('grupos.index') }}"><button type="button" class="btn btn-success">Grupos</button></a>
@endsection("encabezado")
  
@section("subencabezado")
  
@endsection("subencabezado")

@section("contenidoprincipal")
  <div class="row">
        <!-- left column -->
        <form role="form" method="post" action="/grupos/{{ $grupo->id_grupo}}" >
          {{ csrf_field() }}
          <input type="hidden" name="_method" value="PUT">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editar</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Ciclo escolar</label>
                      <select class="form-control" id="id_ciclo_escolar" name="id_ciclo_escolar" required>
                        <option value="">Seleccione una opcion</option>
                        @foreach($cicloescolares as $cicloescolar)
                          <option value="{{$cicloescolar->id}}" {{($grupo->id_ciclo_escolar ===$cicloescolar->id) ? 'selected' : ''}}>{{ $cicloescolar->anio_inicio  }}-{{ $cicloescolar->anio_fin  }}, Periodo: {{ $cicloescolar->periodo  }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  
                </div>

                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Modalidad</label>
                      <select id="turno" name="turno" class="form-control">
                        <option {{('Escolarizado' ===$grupo->turno) ? 'selected' : ''}}>Escolarizado</option>
                        <option {{('Semiescolarizado' ===$grupo->turno) ? 'selected' : ''}}>Semiescolarizado</option>
                      </select>
                      
                    </div>
                  </div>
                  <div class="col-xs-6">   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nivel escolar</label>
                      <select class="form-control" id="id_nivel_escolar" name="id_nivel_escolar" required>
                        <option value="">Seleccione una opcion</option>
                        @foreach($nivelescolares as $nivelescolar)
                          <option value="{{$nivelescolar->id}}" 
                            {{($grupo->id_nivel_escolar ===$nivelescolar->id) ? 'selected' : ''}} > {{ $nivelescolar->clave_identificador  }} 
                          </option>
                        @endforeach
                      </select>
                    </div>   
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">

                    <div class="form-group">
                      <label>Grado o semestre</label>
                      <input type="text" class="form-control" id="grado_semestre" name="grado_semestre" required placeholder="Grado o semestre" value="{{ $grupo->grado_semestre }}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Grupo/Descripción</label>
                      <input type="text" class="form-control" id="diferenciador_grupo" name="diferenciador_grupo" required placeholder="Ejemplo: A, B, Amarillo, etc." value="{{ $grupo->diferenciador_grupo }}">
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
@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('becas.index') }}"><button type="button" class="btn btn-success">Conceptos de becas</button></a>
@endsection("encabezado")

@section("subencabezado")
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
        <!-- left column -->
        <form id="sample_form" name="sample_form" role="form" method="post" action="/becas"  enctype="multipart/form-data" >
        @csrf
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Nueva beca</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Código</label>
                      <input type="text" class="form-control" id="codigo" name="codigo" required placeholder="Código">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Descripción</label>
                      <input type="text" class="form-control" id="descripcion" name="descripcion" required placeholder="Descripción">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Porcentaje o cantidad</label>
                      <select class="form-control" id="porc_o_cant" name="porc_o_cant" required="">
                        <option value="porcentaje">porcentaje</option>
                        <option value="cantidad">cantidad</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Valor de descuento</label>
                      <input type="text" class="form-control" id="cantidad" name="cantidad" required placeholder="Impuesto">
                    </div>   
                  </div>
               <!--   <div class="col-xs-6">   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nivel al que aplica la beca</label>
                      <select class="form-control" id="id_nivel" name="id_nivel" required >
                        <option value="">Seleccione</option>
                        @foreach($nivelescolars as $nivelescolar)
                          <option value="{{ $nivelescolar->id }}">{{ $nivelescolar->denominacion_grado }}</option>
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
                      <button type="submit" class="btn btn-primary">Registrar</button>
                      <a href="{{ route('conceptocobro.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
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
@section("scriptpie")
<script type="text/javascript">
  $(document).ready(function(){
      $('#sample_form').on('submit', function(event){
        //
        var id_ciclo = $("#id_ciclo").val();
        if(id_ciclo==0){
          alert("Elija un ciclo escolar...");
          event.preventDefault();
          return;
        }
      }
      );
    }
  );
</script>
@endsection("scriptpie")
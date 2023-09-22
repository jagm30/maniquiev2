@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('becas.index') }}"><button type="button" class="btn btn-success">Conceptos de becas</button></a>
@endsection("encabezado")

@section("subencabezado")
  <a href="{{ route('becas.create') }}"><button type="button" class="btn btn-info">Agregar beca</button></a>
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
    <div class="col-xs-12">
      <div class="box">
          <div class="box-header">
            <h3 class="box-title">Wizard </h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Grupos vacios</a></li>
              <li><a href="#tab_2" data-toggle="tab">Inscribir alumnos</a></li>
              <li><a href="#tab_3" data-toggle="tab">Asignar cuentas</a></li>
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                  Dropdown <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                  <li role="presentation" class="divider"></li>
                  <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                </ul>
              </li>
              <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active" id="tab_1">
                <b>Copiar grupos del ciclo:</b>
                <select class="form-control" id="ciclo_escolar" name="ciclo_escolar">
                  <option>seleccione un ciclo escolar anterior</option>
                  @foreach($cicloescolars as $cicloescolar) 
                    <option value="{{ $cicloescolar->id }}">{{ $cicloescolar->descripcion }}</option>
                  @endforeach
                </select>
                <div class="row">
                  <div class="col-xs-4">
                    <h4>Grupos actuales:</h4>
                    <div class="form-group" style="color:green;" id="contenedorgruposactuales">
                      @foreach($grupos as $grupo)
                        <div class="checkbox"><label>{{ $grupo->clave_identificador }}/ {{ $grupo->grado_semestre }} {{ $grupo->diferenciador_grupo }} {{ $grupo->turno }}</label></div>
                      @endforeach
                    </div>
                  </div>
                  <div class="col-xs-4" >
                    <h4>Seleccione los grupos que desea copiar:</h4>
                    <div class="form-group" id="contenedorgruposant"  name="contenedorgruposant">
                      
                    </div>
                  </div>                   
                  <div class="col-xs-4">
                    <button class="form-control btn-success" id="btn_registrar" name="btn_registrar">Copiar Grupos Vacios</button>

                    <br>
                    <b>Este proceso copiara los grupos hacia el ciclo actual, los grupos se importaran vacios.</b>
                    <br>

                    <div class="col-xs-12" id="mensajediv" name="mensajediv"></div>
                  </div>
                </div>                
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_2">
                The European languages are members of the same family. Their separate existence is a myth.
                For science, music, sport, etc, Europe uses the same vocabulary. The languages only differ
                in their grammar, their pronunciation and their most common words. Everyone realizes why a
                new common language would be desirable: one could refuse to pay expensive translators. To
                achieve this, it would be necessary to have uniform grammar, pronunciation and more common
                words. If several languages coalesce, the grammar of the resulting language is more simple
                and regular than that of the individual languages.
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="tab_3">
                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                like Aldus PageMaker including versions of Lorem Ipsum.
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          </div>
          <!-- /.box-body -->
        </div>
    </div>
  </div>

@endsection("contenidoprincipal")
@section("scriptpie")
<script>
  $(document).ready(function(){
    $('#ciclo_escolar').on('change', function() {
        $("#contenedorgruposant").html("");
        $.ajax({
          url:"/grupos/listarxciclo/"+$(this).val(),
          dataType:"json",
          success:function(html){            
            for (var i = 0; i < html.data.length; i++){
              $("#contenedorgruposant").append('<div class="checkbox"><label><input type="checkbox" name="opciones[]" value="'+html.data[i].id_grupo+'">'+html.data[i].clave_identificador+' / '+html.data[i].grado_semestre+'  '+html.data[i].diferenciador_grupo+'  '+html.data[i].turno+'</label></div>');
            }
          }
        });
    });

    $('#btn_registrar').click(function() {      
      var selected            = [];
      var  list = {
        'datos' :[]
      };
      // SE COLOCAN EN UN ARREGLO LOS GRUPOS SELECCIONADOS
      $("input:checkbox[name='opciones[]']").each(function() {
        if (this.checked) {
          // agregas cada elemento.
          // a continuacion se forma un objeto JSON para pasar los datos seleccionados
          list.datos.push({
            "id_grupo": $(this).val()   
          });          
        }
      })
      json = JSON.stringify(list); // aqui tienes la lista de objetos en Json
      var obj = JSON.parse(json); //Parsea el Json al objeto anterior.

      // SE REGISTRAN LOS GRUPOS DEL ARREGLO
      $.ajax({
           url:"/grupos/guardargrupo/"+json,
           dataType:"json",
           async: false,
           contentType: "application/json",
           success:function(html){
              $("#mensajediv").append('<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button> <h4><i class="icon fa fa-check"></i> Alert!</h4>'+html.data+'</div>');
            //actualizar grupos actuales en wizard
              $("#contenedorgruposactuales").html("");
              $.ajax({
                url:"/grupos/listarxciclo/"+{{ session('session_cart') }},
                dataType:"json",
                success:function(html){            
                  for (var i = 0; i < html.data.length; i++){
                    $("#contenedorgruposactuales").append('<div><label>'+html.data[i].clave_identificador+' / '+html.data[i].grado_semestre+'  '+html.data[i].diferenciador_grupo+'  '+html.data[i].turno+'</label></div>');
                  }
                }
              });
              //actualizar grupos actuales
           }
        })

    });
  });

</script>
@endsection("scriptpie")
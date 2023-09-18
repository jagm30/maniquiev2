@extends("../layout.plantilla")

@section("encabezado")
  
@endsection("encabezado")
  
@section("subencabezado")
  
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
        <!-- left column -->
        <form role="form" id="sample_form" name="sample_form" method="post" action="/politicaplanpago"  enctype="multipart/form-data" >
        @csrf
        <div class="col-md-4">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Asignación de cuentas por cobrar</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">                  
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Elija a quienes desea asignar cuentas por cobrar, para el ciclo seleccionado</label>
                      <select class="form-control" id="opcion_asignacion" name="opcion_asignacion" required>
                        <option value="">Seleccione una opción</option>
                        <option value="nivel">Alumnos de un nivel</option>
                        <option value="grupo">Alumnos de un grupo</option>
                        <option value="alumno">Un alumno en particular</option>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="row">                  
                  <div class="col-xs-12">
                    <br>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Seleccione</label>
                      <select class="form-control select2" id="opcion_asignacion2" name="opcion_asignacion2" required>                     
                      </select>                     
                    </div>
                  </div>
                </div>
                <div class="row">                  
                  <div class="col-xs-12">
                    <br>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Elige el plan de pagos</label>
                      <select class="form-control select2" id="plan_pago" name="plan_pago" required>
                        <option value="">Seleccione un plan</option>
                        @foreach($planpagos as $planpago)
                          <option value="{{$planpago->id}}">{{$planpago->descripcion}}</option>
                        @endforeach                   
                      </select>                     
                    </div>
                  </div>
                </div>
                <div class="row">                  
                  <div class="col-xs-12">

                    <div class="form-group">
                      <br>
                      <button type="submit" id="btn_registro" class="btn btn-primary">Asignar cuentas por cobrar</button>
                      <a href="{{ route('planpago.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
                        @if($errors->any())
                          @foreach($errors->all() as $error)
                            <h3>{{$error}}</h3>
                          @endforeach
                        @endif    
                      <div id="content"></div>        
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
       
        </form>

        <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-header with-border">
              <i class="fa fa-text-width"></i>

              <h3 class="box-title">Seleccione grupo(s) o alumno(s):</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="contenedorOpcAsig" id="contenedorOpcAsig">
              <!-- Contenedor opciones para asginarles cuentas...->
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
      <div class="col-md-4">
          <div class="box box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Seleccione los conceptos para asignar:</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body" id="contenedor_cobros" id="contenedor_cobros">
              <!-- Contenedor opciones para asginarles cuentas...->
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>

@endsection("contenidoprincipal")
@section("scriptpie")
<script type="text/javascript">
  $(document).ready(function(){
    $('#sample_form').on('submit', function(event){      
      event.preventDefault();
      id                      = $('#opcion_asignacion').val();
      planpago                = $('#plan_pago').val();
      var selected            = [];
      var conceptosasignados  = [];

      $("input:checkbox[name='opciones[]']").each(function() {
        if (this.checked) {
          // agregas cada elemento.
          selected.push($(this).val());
        }
      });

      $("input:checkbox[name='planes_pago[]']").each(function() {
        if (this.checked) {
          // agregas cada elemento.
          conceptosasignados.push($(this).val());
        }
      });
      if(id =='grupo'){
        if(selected ==''){
          alert("Seleccione al menos una persona para asignar las cuentas");
        }else if(conceptosasignados==''){
          alert("Seleccione al menos un concepto");
        }else{
          listar_opcion_asignacion = $('#opcion_asignacion2').val();
        
        $.ajax({
         url:"/cuentasasignadas/guardar_opcion_asignacion/"+id+"/"+listar_opcion_asignacion+"/"+selected+"/"+planpago+"/"+conceptosasignados,
         dataType:"json",
         success:function(html){
            alert(html.data);
            location.reload();
         }
        })
        }
      }
      if(id =='nivel'){
        if(selected ==''){
          alert("Seleccione al menos un nivel escolar");
        }else if(conceptosasignados==''){
          alert("Seleccione al menos un concepto");
        }else{
          listar_opcion_asignacion = $('#opcion_asignacion2').val();
        $.ajax({
         url:"/cuentasasignadas/guardar_opcion_asignacion/"+id+"/"+listar_opcion_asignacion+"/"+selected+"/"+planpago+"/"+conceptosasignados,
         dataType:"json",
         success:function(html){
            alert(html.data);
            location.reload();
         }
        })
        }
      }
      if(id =='alumno'){
        if(selected ==''){
          alert("Seleccione al menos un alumno");
        }else if(conceptosasignados==''){
          alert("Seleccione al menos un concepto");
        }else{
          listar_opcion_asignacion = $('#opcion_asignacion2').val();
        $.ajax({
         url:"/cuentasasignadas/guardar_opcion_asignacion/"+id+"/"+listar_opcion_asignacion+"/"+selected+"/"+planpago+"/"+conceptosasignados,
         dataType:"json",
         success:function(html){
            alert(html.data);
            location.reload();

         }
        })
        }
      }
    });

    $('.select2').select2({
      placeholder: "Seleccione una opción",
    });
    $('.select2').select2().on('select2:open', function(e){
        $('.select2-search__field').attr('placeholder', 'Ingrese un texto');
    })

    $("#opcion_asignacion" ).change(function() {
      //alert($('#opcion_asignacion').val());
      id = $('#opcion_asignacion').val();
      $("#opcion_asignacion2").empty();
      $.ajax({
       url:"/cuentasasignadas/opcion_asignacion/"+id,
       dataType:"json",
       success:function(html){
          //alert(html.data);
          if(id=="nivel"){
            $("#contenedorOpcAsig").empty();
            $("#opcion_asignacion2").append('<option value="">Seleccione el nivel</option>');
            for (var i = 0; i < html.data.length; i++) 
            {
              $("#opcion_asignacion2").append('<option value="' + html.data[i].id + '">' + html.data[i].clave_identificador +' /'+ html.data[i].denominacion_grado+'</option>');

            }
          }
          if(id=="grupo"){
             $("#opcion_asignacion2").append('<option value="">Seleccione el grupo</option>');
            for (var j = 0; j < html.data.length; j++) 
            {
              $("#opcion_asignacion2").append('<option value=' + html.data[j].id_grupo+ '>' + html.data[j].grado_semestre +' '+html.data[j].diferenciador_grupo+' / '+ html.data[j].denominacion_grado +' /' + html.data[j].turno +'</option>');
            }  
          }
          if(id=="alumno"){
            $("#contenedorOpcAsig").empty();
             $("#opcion_asignacion2").append('<option value="">Seleccione el alumno</option>');
            for (var k = 0; k < html.data.length; k++) 
            {
              $("#opcion_asignacion2").append('<option value=' + html.data[k].id + '>' + html.data[k].apaterno +' '+html.data[k].amaterno+' '+html.data[k].nombres+' </option>');
            }  
          }
       }
      })
    });

    $("#opcion_asignacion2" ).change(function() {
      //alert($('#opcion_asignacion').val());
      //alert("aca");
      id = $('#opcion_asignacion').val();
      listar_opcion_asignacion = $('#opcion_asignacion2').val();
      $("#contenedor_cobros").empty();
      $('#plan_pago').prop('selectedIndex',0);
      $('.select2').select2();
      $("#contenedorOpcAsig").empty();
      $.ajax({
       url:"/cuentasasignadas/listar_opcion_asignacion/"+id+"/"+listar_opcion_asignacion,
       dataType:"json",
       success:function(html){
          //alert(html.data[0].full_name);
          if(id=="grupo"){  
            for (var i = 0; i < html.data.length; i++) 
            {
              $("#contenedorOpcAsig").append('<p class="text-green"> <img src="/images/1.png" alt="Avatar" style="width:30px"> <input type="checkbox" checked name="opciones[]" value="'+html.data[i].id_alumno+'"> ' + html.data[i].full_name  +' <br/></p>');              
            }
          }
          if(id=="nivel"){  
            for (var i = 0; i < html.data.length; i++) 
            {
              $("#contenedorOpcAsig").append('<p class="text-green"> <img src="/images/grupo.png" alt="Avatar" style="width:30px"> <input type="checkbox" checked name="opciones[]" value="'+html.data[i].id_grupo+'"> ' + html.data[i].grado_semestre +' / '+ html.data[i].diferenciador_grupo  +'/'+html.data[i].denominacion_grado+' '+html.data[i].turno+' <br/></p>');              
            }
          }
          if(id=="alumno"){  
            for (var i = 0; i < html.data.length; i++) 
            {
              $("#contenedorOpcAsig").append('<p class="text-green"> <img src="/images/' + html.data[i].foto +'" alt="Avatar" style="width:30px"> <input type="checkbox" checked name="opciones[]" value="'+html.data[i].id+'"> ' + html.data[i].full_name +' <br/> CURP:'+html.data[i].curp+'<br> Grupo: '+html.data[i].grado_semestre+' '+html.data[i].diferenciador_grupo+' </p>');              
            }
          }
       }
      })
    });
    $("#plan_pago" ).change(function() {
      id        = $('#opcion_asignacion').val();
      opcion    = $('#opcion_asignacion2').val();
      planpago  = $('#plan_pago').val();
      $("#contenedor_cobros").empty();
      $.ajax({
       url:"/cuentasasignadas/cuenta_asignada/"+id+"/"+opcion+"/"+planpago,
       dataType:"json",
       success:function(html){
            for (var i = 0; i < html.data.length; i++) 
            {
              $("#contenedor_cobros").append('<p class="text-green"> <img src="/images/billete.png" alt="Avatar" style="width:30px"> <input type="checkbox" checked name="planes_pago[]" value="' + html.data[i].id  +'"> ' + html.data[i].descripcion  +'-' + html.data[i].cantidad  +' <br/></p>');              
            }          
       }
      })
    });

  });
</script>
<style type="text/css">
  .select2-search { background-color: #DFDFDF; border-width: thin;}
</style>
@endsection("scriptpie")
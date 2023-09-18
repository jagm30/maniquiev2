@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('grupos.index') }}"><button type="button" class="btn btn-success">Grupos</button></a>  <span id="nombre_gr"> {{$nomgrupo->grado_semestre}} {{$nomgrupo->diferenciador_grupo}} {{$nomgrupo->turno}} <br>{{ $nomgrupo->denominacion_grado }}</span>
@endsection("encabezado")
<style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }
    .example-modal .modal {
      background: transparent !important;
    }
  </style>
@section("subencabezado")
	<a href="{{ route('nivelescolar.create') }}"></a>
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
    <div class="col-xs-12">
      <div class="box">
          <div class="box-header">
            <button type="button"  name="create_record" id="create_record" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                Agregar alumno
              </button>
              <a style="float: right;" href="/grupoalumnos/print-pdf/{{ $nomgrupo->id_grupo}}" target="_blank"><img src="../images/pdf.png" alt="pdf" width="42" height="42"></a>
              <a style="float: right;" href="/grupoalumnos/excel/{{ $nomgrupo->id_grupo}}"><img src="../images/excel.png" alt="pdf" width="42" height="42"></a>
          </div>

          <!-- /.box-header -->
          <div class="box-body">            
            <div class="table-responsive">
              <table id="grupoalumnos_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Foto</th>
                  <th>Nombre del alumno</th>
                  <th>Genero</th>
                  <th>Status</th>
                  <th  width="170">Action</th>
                </tr>
                </thead>

              </table>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
    </div>
  </div>
 <div class="modal fade" id="modal-default">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-title">Default Modal</h4>
        
      </div>
      <span id="form_result"></span>
      <form method="post" id="sample_form" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
        <div class="modal-body">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4" >Nombre del alumno: </label>
            <input type="hidden" name="id_tb_alumno" id="id_tb_alumno">
            <span id="nombre_alumno"></span>
            <div class="col-md-8" id="cont_alumnos">
              <select  name="id_alumno" id="id_alumno"  class="form-control select2" style="width: 100%;"  required>
                <option value="">Seleccione una opcion</option>
                @foreach($alumnos as $alumno)
                  <option value="{{ $alumno->id}}">{{ $alumno->apaterno }} {{ $alumno->amaterno }} {{ $alumno->nombres }}</option>
                @endforeach
              </select>
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4" >Status: </label>
            <div class="col-md-8">
              <select name="status" id="status" class="form-control" required>
                <option value="activo">activo</option>
                <option value="baja temporal">baja temporal</option>
                <option value="baja definitiva">baja definitiva</option>
                <option value="egresado">egresado</option>
              </select>
            </div>
           </div> 
           <div class="form-group" id="cont_grupo" style="display:none;">
            <label class="control-label col-md-4" >Grupo: </label>
            <div class="col-md-8">
              <select name="grupo_inscrito" id="grupo_inscrito" class="form-control">                
                @foreach($grupos as $grupo)
                  <option value="{{ $grupo->id_grupo }}">{{ $grupo->grado_semestre }} {{ $grupo->diferenciador_grupo }}</option>
                @endforeach
              </select>
            </div>
           </div>           
           <input type="hidden" name="id_grupo" id="id_grupo" class="form-control" required value="{{ $id }}" />
           <br />
           <div class="form-group" align="center">
            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
            <span id="store_image"></span>
           </div>           
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Add">
      </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<!-- Ventana modal para eliminar -->
<div class="modal fade" id="confirmModal" name="confirmModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="modal-title">Confirmar</h4>
      </div>
      <span id="form_result"></span>
        <div class="modal-body">
          <h4 align="center" style="margin: 0;">Realmente deseas eliminar el alumno del grupo?</h4>
        </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger pull-right" name="ok_button" id="ok_button">Eliminar</button>
      </div>
    </div>
  </div>
</div>
<!-- /.modal -->
@endsection("contenidoprincipal")
@section("scriptpie")
<script type="text/javascript">
  $(document).ready(function(){
    $('#grupoalumnos_table').DataTable({
      language: {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
      },
      "search": {
            "addClass": 'form-control input-lg col-xs-12'
      },
      "fnDrawCallback":function(){
        $("input[type='search']").attr("id", "searchBox");            
        $('#searchBox').css("width", "400px").focus();
      },
      processing: true,
      serverSide: true,
      ajax:{
        url: "{{route('grupoalumnos.show',$id)}}"
      },
      columns:[
        {
          data: 'foto',
          name: 'foto',
          render: function(data, type, full, meta){
            return "<img src='{{URL::to('/')}}/images/"+data+"' width='30' class='img-thumbnail' />"
          },
        },
        {
          data: {'full_name':'full_name', 'id':'id'},
          name: 'id_alumno',
          render: function(data, type, full, meta){
            return "<a href='{{URL::to('/')}}/alumnos/"+data.id_alumno+"' />"+data.full_name+"</a>"
          },
        },
        {
          data: 'genero',
          name: 'genero'
        },
        {
          data: 'status',
          name: 'status'
        },
        {
        data: 'action',
        name: 'action',
        orderable: false
        }
      ]
    });
    $('#create_record').click(function(){
        
         $('#modal-title').text("Agregar alumno");
         $('#action_button').val("Agregar");
         $('#action').val("Add");
         //$('#formModal').modal('show');        
        $("#id_alumno").removeAttr("readonly"); 
        $("#cont_alumnos").show();
        $("#nombre_alumno").hide();
        $("#cont_grupo").hide();
     });
    $('#sample_form').on('submit', function(event){
      event.preventDefault();
     // alert($('#action').val());     
      if($('#action').val()=='Add')
      {      

        $.ajax({
          url:"{{route('grupoalumnos.store')}}",
          method:"POST",
          data: new FormData(this),
          contentType:false,
          cache:false,
          processData:false,
          dataType:"json",
          success: function(data){            
            //alert("2");
            var html = '';
            if(data.errors)
            {
              html = '<div class="alert alert-danger">';
              for(var count = 0; count < data.errors.length; count++)
                {
                  html += '<p>' + data.errors[count] + '</p>';
                }
              html += '</div>';
            }
            if (data="success") {
              html = '<div class="alert alert-success">Registrado correctament</div>';
              $('#sample_form')[0].reset();

              $('#grupoalumnos_table').DataTable().ajax.reload();
            }
            $('#form_result').html(html);
            location.reload();
          }
        })
      }
      if ($('#action').val()=='Edit')
      {
        if(confirm('Estas seguro de realizar los cambios') ){          
        $.ajax({
          url: "{{ route('grupoalumnos.update')}}",
          method:"POST",
          data:new FormData(this),
          contentType: false,
          cache: false,
          processData: false,
          dataType:"json", 
          success: function(data)
          {
            var html = '';
            if(data.errors){
              html = '<div class="alert alert-danger">';
              for(var count=0; count < data.errors.length; count++)
              {
                html += '<p>'+data.errors[count]+'<p>'
              }
              html = '</div>'
            }
            if(data.success)
            {
              html = '<div class="alert alert-success">'+data.success+"</div>";
             // $('#sample_form')[0].reset();
              $('#store_image').html('');
              $('#grupoalumnos_table').DataTable().ajax.reload();
            }
            $('#form_result').html(html);
            $('#modal-default').delay(500).modal('hide');
          }

        });
      }
      }
    });
    $(document).on('click', '.edit', function(){
      var id = $(this).attr('id');      
      $('#form_result').html('');
     // $('#inputId').prop('readonly', true);
      $("#id_alumno").attr("readonly","readonly");
      $("#id_alumno").hide();
      $("#cont_alumnos").hide();
      $("#nombre_alumno").show();
      $("#cont_grupo").show();
      $.ajax({
       url:"/grupoalumnos/"+id+"/edit",
       dataType:"json",
       success:function(html){
          $('#nombre_alumno').text(html.data.apaterno+" "+html.data.amaterno+" "+html.data.nombres);
          $('#store_image').html("<img src={{URL::to('/')}}/images/"+html.data.foto +" width='100' height='100' class='img-thumbnail' />");
          $('#status').val(html.data.status);
          $('#grupo_inscrito').val(html.data.id_grupo);
          $('#hidden_id').val(html.data.id);
          $('#modal-title').text("editar alumno");
          $('#action_button').val("Actualizar");
          $('#action').val("Edit");
          $('#id_tb_alumno').val(html.data.id_alumno);          
       }
      })
     });
    var id;
    $(document).on('click', '.delete', function(){
      id = $(this).attr('id');
      //$("#confirmModal").show();{}
     });
    $("#ok_button").click(function(){
      $.ajax({
        url: "/grupoalumnos/destroy/"+id,
        beforeSend:function(){          
          $("#ok_button").text('Eliminando...');
        },
        success:function(data){
          setTimeout(function(){
            //$('#confirmModal').modal('show');
            $('#grupoalumnos_table').DataTable().ajax.reload();
          }, 500);          
          $('#confirmModal').modal('hide');
        }
      })
    });
  });
  $('.select2').select2();
</script>
@endsection("scriptpie")
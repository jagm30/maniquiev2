  @extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('planpago.index') }}"><button type="button" class="btn btn-success">Planes de pago</button></span>
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
            <h3 class="box-title">{{ $nom_plan_pago->descripcion }}</h3>
            <div align="right">
              <button type="button"  name="create_record" id="create_record" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                Agregar concepto
              </button>
             </div>
          </div>

          <!-- /.box-header -->
          <div class="box-body">            
            <div class="table-responsive">
              <table id="grupoalumnos_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Concepto del cobro</th>
                  <th>Año al que corresponde</th>
                  <th>Mes a pagar</th>
                  <th>Costo</th>
                  <th  width="170">Funciones</th>
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
      <form method="post" id="sample_form" class="form-horizontal" enctype="multipart/form-data">
        <div class="modal-body">
          @csrf
          <div class="form-group">
            <label class="control-label col-md-4" >Concepto: </label>
            <div class="col-md-8">
              <span id="nombre_alumno"></span>
              <select name="id_concepto_cobro" id="id_concepto_cobro" class="form-control" required >
                <option value="">Seleccione una opción</option>
                @foreach($conceptos as $conceptos)
                  <option value="{{ $conceptos->id }}">{{ $conceptos->descripcion }}</option>
                @endforeach
              </select>
            </div>
           </div>
           <div class="form-group">
            <label class="control-label col-md-4" >Año al que corresponde: </label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="anio_corresponde" id="anio_corresponde" required>
            </div>
           </div> 
           <div class="form-group">
            <label class="control-label col-md-4" >Mes a pagar: </label>
            <div class="col-md-8">
              <select class="form-control" name="mes_pagar" id="mes_pagar" required>
                <option value="">Seleccione</option>
                <option>ENERO</option>
                <option>FEBRERO</option>
                <option>MARZO</option>
                <option>ABRIL</option>
                <option>MAYO</option>
                <option>JUNIO</option>
                <option>JULIO</option>
                <option>AGOSTO</option>
                <option>SEPTIEMBRE</option>
                <option>OCTUBRE</option>
                <option>NOVIEMBRE</option>
                <option>DICIEMBRE</option>
              </select>
            </div>
           </div>  
           <div class="form-group">
            <label class="control-label col-md-4" >Parcialidad: </label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="no_parcialidad" id="no_parcialidad" required>
            </div>
           </div>  
           <div class="form-group">
            <label class="control-label col-md-4" >Periodo de inicio: </label>
            <div class="col-md-8">
              <input type="date" class="form-control" name="periodo_inicio" id="periodo_inicio" required>
            </div>
           </div> 
           <div class="form-group">
            <label class="control-label col-md-4" >Periodo de vencimiento: </label>
            <div class="col-md-8">
              <input type="date" class="form-control" name="periodo_vencimiento" id="periodo_vencimiento" required>
            </div>
           </div> 
           <div class="form-group">
            <label class="control-label col-md-4" >Cantidad a pagar: </label>
            <div class="col-md-8">
              <input type="text" class="form-control" name="cantidad" id="cantidad" required>
            </div>
           </div>                      
           <input type="hidden" name="id_plan_pago" id="id_plan_pago" class="form-control" required value="{{ $id }}" />

            <input type="hidden" name="action" id="action" />
            <input type="hidden" name="hidden_id" id="hidden_id" />
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
        <input type="submit" name="action_button" id="action_button" class="btn btn-warning" value="Agregar">
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
          <h4 align="center" style="margin: 0;">Realmente deseas eliminar el concepto?</h4>
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
      processing: true,
      serverSide: true,
      ajax:{
        url: "{{route('planpagoconcepto.show',$id)}}"
      },
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
      columns:[
        {
          data: 'descripcion',
          name: 'id_concepto_cobro'
        },
        {
          data: 'anio_corresponde',
          name: 'anio_corresponde'
        },
        {
          data: 'mes_pagar',
          name: 'mes_pagar'
        },
        {
          data: 'precio', className: "text-right",
          render: function (data, type, row) {
                return type === 'export' ?
                    data.replace( /[$,]/g, '' ) :
                    data;
            }, 
          name: 'cantidad'
        },
        {
        data: 'action',
        name: 'action',
        orderable: false
        }
      ]
    });
    function formatNumber(n) {
      alert(n.text().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,"));
      //alert("2");
    }
    $('#create_record').click(function(){
        
         $('#modal-title').text("Agregar concepto");
         $('#action_button').val("Guardar");
         $('#action').val("Add");
         $('#sample_form')[0].reset();
         //$('#formModal').modal('show');        
       // $("#id_alumno").removeAttr("readonly"); 
       // $("#id_alumno").show();
        //$("#nombre_alumno").hide();
        //$("#cont_grupo").hide();
     });
    $('#sample_form').on('submit', function(event){
      event.preventDefault();
     // alert($('#action').val());     
      if($('#action').val()=='Add')
      {      
        //alert("add");
        $.ajax({
          url:"{{route('planpagoconcepto.store')}}",
          method:"POST",
          data: new FormData(this),
          contentType:false,
          cache:false,
          processData:false,
          dataType:"json",
          success: function(data){            
           // alert("2");
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
            if(data.success) 
            {
              html = '<div class="alert alert-success">Registrado correctamente</div>';
              $('#sample_form')[0].reset();

              $('#grupoalumnos_table').DataTable().ajax.reload();
            }
            $('#form_result').html(html);            
          }
        })
      }
      if ($('#action').val()=='Edit')
      {
        if(confirm('Estas seguro de realizar los cambios') ){          
        $.ajax({
          url: "{{ route('planpagoconcepto.update')}}",
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
     // $("#id_alumno").attr("readonly","readonly");
      //$("#id_alumno").hide();
      //$("#nombre_alumno").show();
     // $("#cont_grupo").show();    
      $.ajax({
       url:"/planpagoconcepto/"+id+"/edit",
       dataType:"json",
       success:function(html){
          $('#id_concepto_cobro').val(html.data.id_concepto_cobro);
          $('#anio_corresponde').val(html.data.anio_corresponde);
          $('#mes_pagar').val(html.data.mes_pagar);
          $('#no_parcialidad').val(html.data.no_parcialidad);
          $('#periodo_inicio').val(html.data.periodo_inicio);
          $('#periodo_vencimiento').val(html.data.periodo_vencimiento);
          $('#cantidad').val(html.data.cantidad);
          $('#hidden_id').val(html.data.id);
          $('#modal-title').text("Editar concepto");
          $('#action_button').val("Guardar");
          $('#action').val("Edit");          
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
        url: "/planpagoconcepto/destroy/"+id,
        beforeSend:function(){          
          $("#ok_button").text('Eliminando...');
        },
        success:function(data){
          setTimeout(function(){
            alert(data);
            //$('#confirmModal').modal('show');
            $('#grupoalumnos_table').DataTable().ajax.reload();
          }, 500);          
          $('#confirmModal').modal('hide');
        }
      })
    });
  });
</script>
@endsection("scriptpie")
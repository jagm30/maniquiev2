@extends("../layout.plantilla")

@section("encabezado")
	<a href="{{ route('alumnos.index') }}"><button type="button" class="btn btn-success">Alumnos</button></a>
@endsection("encabezado")

@section("subencabezado")
	<a href="{{ route('alumnos.create') }}"><button type="button" class="btn btn-info">Agregar alumno</button></a>
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
    <div class="col-xs-12">
      <div class="box">
          <div class="box-header">
            <h3 class="box-title">
             <!-- <div class="form-group">
                <select class="form-control" style="float:right; width: 300px;">
                  <option>Inscritos</option>
                  <option>No Inscritos</option>
                </select>
              </div>
            -->
            </h3>
          </div>
          <!-- /.box-header -->        
          <!-- /.box-body -->
          <div class="table-responsive">
              <table id="alumnos_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Foto</th>
                  <th>Nombre completo</th>
                  <th>Grado/Grupo</th>
                  <th>CURP</th>
                  <th>email</th>
                  <th>Teléfono</th>
                  <th>Status</th>
                  <th>Funciones</th> 
                  <th></th> 
                </tr>
                </thead>

              </table>
            </div>
        </div>
    </div>
  </div>



  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

@endsection("contenidoprincipal")
@section("scriptpie")
<script>
  $(document).ready(function(){
    $('#alumnos_table').DataTable({
      processing: true,
      serverSide: true,
      ajax:{
        url: "{{route('alumnos.index')  }}"
      },
      columns:[
        {
          data: 'image',
          name: 'image'
        },
        {
          data: 'full_name',
          name: 'full_name'
        },
        {
          data: 'grado_grupo',
          name: 'grado_grupo'
        },
        {
          data: 'curp',
          name: 'curp'
        },
        {
          data: 'email',
          name: 'email'
        },
        {
          data: 'telefono',
          name: 'telefono'
        },
        {
          data: 'status',
          name: 'status'
        },
        {
        data: 'action',
        name: 'action',
        orderable: false
        },
        {
        data: 'action2',
        name: 'action2',
        orderable: false
        }
      ],
      searching: true,
      autoWidth: false,      
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
      columnDefs: [
            { width: 500, targets: 1 }
        ],
    });
  });
  $('body').on('click', '#delete-product', function () {
  
        var alumno_id = $(this).data("id");
        
        if(confirm("Estas seguro que deseas eliminar el alumno?")){
          $.ajax({
              type: "get",
              url: "alumnos/delete/"+alumno_id,
              success: function (data) {
              alert(data.mensaje);
              var oTable = $('#alumnos_table').dataTable(); 
              oTable.fnDraw(false);
              }/*,
              error: function (data) {
                  console.log('Error:', data);
              }*/
          });
        }
    }); 
  $("form").submit(function( event ) {
    $('#opcion_asignacion2').val();
    id = $(this).attr("name");  
    no_cuentas  = 0;
    no_cobros   = 0;
    $.ajax({
       url:"/alumnos/consultaeliminar/"+id,
       async: false,
       dataType:"json",
       success:function(html){
          no_cuentas  = html.cuentas;
          no_cobros   = html.cobros;
       }
    })
    //valida si tiene cobros efectuados...
    if(no_cobros>0){      
      alert("El alumno tiene cobros registrados, no se puede eliminar...");      
      event.preventDefault(); 
    }else{
      //valida si tiene cuentas asignadas...
      if(no_cuentas>0){      
        var r = confirm("El alumno tiene cuentas asignadas, desea continuar?");      
        if (r == true) {
          txt = "You pressed OK!";
        } else {
          event.preventDefault();
        }
      }
      //fin valida si tiene cuentas asignadas...
    }
    //fin valida si tiene cobros efectuados...
    
  });
</script>
@endsection("scriptpie")
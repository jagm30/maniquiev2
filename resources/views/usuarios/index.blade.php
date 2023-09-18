@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('usuarios.index') }}"><button type="button" class="btn btn-success">Usuarios</button></a>
@endsection("encabezado")
@section("subencabezado")
<a href="{{ route('usuarios.create') }}"><button type="button" class="btn btn-info">Nuevo Usuario</button></a>
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
    <div class="col-xs-12">
      <div class="box">
          <div class="box-header">
            <h3 class="box-title">Niveles escolares</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Nombre</th>
                <th>E-mail</th>
                <th>Password</th>
                <th>Tipo de usuario</th>
                <th>Funciones</th>
              </tr>
              </thead>
              <tbody>
              </tfoot>
                 @foreach($usuarios as $usuario)              
                  <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>{{ $usuario->password }}</td>
                    <td>{{ $usuario->roles[0]->name }}</td>
                    <td><a href="{{ route('usuarios.edit',$usuario->id) }}"><button type="button" class="btn btn-primary btn-xs" style="width:70px; ">Editar</button></a><br>
                       
                    </td>
                  </tr>
                @endforeach
              <tfoot>
              <tr>
                <th>Nombre</th>
                <th>E-mail</th>
                <th>Password</th>
                <th>Tipo de usuario</th>
                <th>Funciones</th>
              </tr>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
    </div>
  </div>

@endsection("contenidoprincipal")
@section("scriptpie")
<script>
  $(function () {
    $('#example1').DataTable({
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
      }
    })
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>
@endsection("scriptpie")
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
              <div class="form-group">
                <select class="form-control" style="float:right; width: 300px;">
                  <option>Inscritos</option>
                  <option>No Inscritos</option>
                </select>
              </div>
            </h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Foto</th>
                <th>Nombre completo</th>
                <th>Grado/Grupo</th>
                <th>CURP</th>
                <th>email</th>
                <th>Telefono</th>
                <th>Status</th>
                <th>Accion</th> 
              </tr>
              </thead>
              <tbody>
              @foreach($alumnos as $alumno)              
                <tr>
                  <td> <img src="images/{{$alumno->foto}}" alt="" width="50" height="50"></td>
                  <td><a href="{{ route('alumnos.show',$alumno->id) }}">{{ $alumno->apaterno }} {{ $alumno->amaterno }} {{ $alumno->nombres }}</a></td>
                  <td>{{ $alumno->grado_semestre }} {{ $alumno->diferenciador_grupo }}</td>
                  <td>{{ $alumno->curp }}</td>
                  <td>{{ $alumno->email }}</td>
                  <td>{{ $alumno->telefono }}</td>
                  <td>{{ $alumno->status }}</td>
                  <td><a href="{{ route('alumnos.edit',$alumno->id) }}"><button type="button" class="btn btn-primary btn-xs" style="width: 110px;margin-bottom: 2px;">Editar</button></a><br>
                    <a href="{{ route('alumnos.show',$alumno->id) }}"><button type="button" class="btn btn-success btn-xs" style="width: 110px;margin-bottom: 2px;">Cuentas asignadas</button></a>
                    <a href="#" onclick="return confirm('Desea eliminar el registro')">
                      <form role="form" method="post" action="/alumnos/{{$alumno->id}}" >
                      {{ csrf_field() }}
                      <input type="hidden" name="_method" value="DELETE">
                      <button type="submit" class="btn btn-danger btn-xs" style="width: 110px;margin-bottom: 2px;">Eliminar</button>
                      </form>
                    </a>                      
                </td>                  
                </tr>
              @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>Foto</th>
                <th>Nombre completo</th>
                <th>Grado/Grupo</th>
                <th>CURP</th>
                <th>email</th>
                <th>Telefono</th>
                <th>Status</th>
                <th>Accion</th>                
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
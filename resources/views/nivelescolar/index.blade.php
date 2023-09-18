@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('nivelescolar.index') }}"><button type="button" class="btn btn-success">Niveles escolares</button></a>
@endsection("encabezado")

@section("subencabezado")
  <a href="{{ route('nivelescolar.create') }}"><button type="button" class="btn btn-info">Agregar nivel</button></a>
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
                <th>Clave / Identificador</th>
                <th>Acuerdo / Incorporación </th>
                <th>Fecha de incorporación</th>
                <th>Zona escolar</th>
                <th>Descripción</th>                
                <th>Funciones</th>
              </tr>
              </thead>
              <tbody>
                @foreach($nivelescolars as $nivelescolar)              
                  <tr>
                    <td>{{ $nivelescolar->clave_identificador }}</td>
                    <td>{{ $nivelescolar->acuerdo_incorporacion }}</td>
                    <td>{{ $nivelescolar->fecha_incorporacion }}</td>
                    <td>{{ $nivelescolar->zona_escolar }}</td>
                    <td>{{ $nivelescolar->denominacion_grado }}</td>                    
                    <td><a href="{{ route('nivelescolar.edit',$nivelescolar->id) }}"><button type="button" class="btn btn-primary btn-xs" style="width:70px; ">Editar</button></a><br>
                        <a href="#" onclick="return confirm('Desea eliminar el registro');">
                          <form role="form" method="post" action="/nivelescolar/{{ $nivelescolar->id}}" >
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-xs" style="width:70px; ">Eliminar</button>
                            </form>                  
                        </a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>Clave / Identificador</th>
                <th>Acuerdo / Incorporación </th>
                <th>Fecha de incorporación</th>
                <th>Zona escolar</th>
                <th>Descripción</th>                
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
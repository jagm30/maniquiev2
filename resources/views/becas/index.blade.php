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
            <h3 class="box-title">Becas</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Descuento</th>                
                <th>Funciones</th>
              </tr>
              </thead>
              <tbody>
                @foreach($becas as $beca)
                  <tr>
                    <td>{{ $beca->codigo }}</td>
                    <td>{{ $beca->descripcion }}</td>
                    <td>{{ $beca->cantidad   }}({{ $beca->porc_o_cant  }})</td>
                    <td style="width:120px">
                      <a href="{{ route('becas.edit',$beca->id) }}"><button type="button" class="btn btn-primary btn-xs" style="width:100px; ">Editar</button></a><br>
                        <a href="#" onclick="return confirm('Desea eliminar el registro');">
                          <form role="form" method="post" action="/becas/{{ $beca->id}}" >
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-xs" style="width:100px; ">Eliminar</button>
                            </form>                  
                        </a>                          
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Descuento</th>                
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
  })
</script>
@endsection("scriptpie")
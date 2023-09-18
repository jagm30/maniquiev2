@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('planpago.index') }}"><button type="button" class="btn btn-success">Planes de pago</button></a>
@endsection("encabezado")

@section("subencabezado")
  <a href="{{ route('planpago.create') }}"><button type="button" class="btn btn-info">Agregar plan</button></a>
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
    <div class="col-xs-12">
      <div class="box">
          <div class="box-header">
            <h3 class="box-title">Planes de pago</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Periodicidad</th>
                <th>Funciones</th>
              </tr>
              </thead>
              <tbody>
                @foreach($planpagos as $planpago)              
                  <tr>
                    <td>{{ $planpago->codigo }}</td>
                    <td>{{ $planpago->descripcion }}</td>
                    <td>{{ $planpago->periocidad }}</td>
                    <td style="width:120px"><a href="{{ route('planpago.edit',$planpago->id) }}"><button type="button" class="btn btn-primary btn-xs" style="width:100px; ">Editar</button></a><br>
                        <a href="#" onclick="return confirm('Desea eliminar el registro');">
                          <form role="form" method="post" action="/planpago/{{ $planpago->id}}" >
                            {{ csrf_field() }}
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit" class="btn btn-danger btn-xs" style="width:100px; ">Eliminar</button>
                            </form>                  
                        </a>
                        <a href="{{ route('planpagoconcepto.show',$planpago->id) }}"><button type="button" class="btn btn-success btn-xs" style="width:100px; ">Conceptos</button></a>
                    </td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot>
              <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Periodicidad</th>
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
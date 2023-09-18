@extends("../layout.plantilla")

@section("encabezado")
	<a href="{{ route('cuentasasignadas.index') }}"><button type="button" class="btn btn-success">Cuentas asignadas</button></a>
@endsection("encabezado")
  
@section("subencabezado")
	<a href="{{ route('cuentasasignadas.create') }}"><button type="button" class="btn btn-info">Creacion de cuentas por cobrar</button></a>
@endsection("subencabezado")

@section("contenidoprincipal")
	<div class="row">
    <div class="col-xs-12">
      <div class="box">
          <div class="box-header">
            <h3 class="box-title">Registros</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
              <tr>
                <th>Ciclo escolar</th>
                <th>Plan de pago</th>
                <th>Dias limite pronto pago</th>
                <th>Descuento</th>
                <th>Valor de recargos</th>                
                <th>Accion</th>
              </tr>
              </thead>
              <tbody>

              </tbody>
              <tfoot>
              <tr>
                <th>Ciclo escolar</th>
                <th>Plan de pago</th>
                <th>Fecha limite pronto pago</th>
                <th>Descuento</th>
                <th>Valor de recargos</th>                
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
    $('#example1').DataTable()
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
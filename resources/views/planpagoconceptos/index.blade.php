@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('grupoalumnos.index') }}"><button type="button" class="btn btn-success">Grupos</button></a>
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
	<a href="{{ route('grupos.create') }}">Nuevo</a>
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
            <div class="table-responsive">
              <table id="grupoalumnos_table" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Ciclo escolar</th>
                  <th>Cupo maximo</th>
                  <th>Turno</th>
                  <th>Nivel escolar</th>
                  <th>Grado/Semestre</th>
                  <th>Diferenciador de grupo</th>
                  <th  width="70">Action</th>
                </tr>
                </thead>

              </table>
            </div>
          </div>
          <!-- /.box-body -->
        </div>
    </div>
  </div>

@endsection("contenidoprincipal")
@section("scriptpie")
<script type="text/javascript">
  $(document).ready(function(){
    $('#grupoalumnos_table').DataTable({
      processing: true,
      serverSide: true,
      ajax:{
        url: "{{route('grupoalumnos.index')  }}"
      },
      columns:[
        {
          data: 'descripcion',
          name: 'descripcion'
        },
        {
          data: 'cupo_maximo',
          name: 'cupo_maximo'
        },
        {
          data: 'turno',
          name: 'turno'
        },
        {
          data: 'clave_identificador',
          name: 'clave_identificador'
        },
        {
          data: 'grado_semestre',
          name: 'grado_semestre'
        },
        {
          data: 'diferenciador_grupo',
          name: 'diferenciador_grupo'
        },
        {
        data: 'action',
        name: 'action',
        orderable: false
        }
      ],
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
    });
  });
</script>
@endsection("scriptpie")
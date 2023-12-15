<!DOCTYPE html>
<html lang="ES">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Maniquie - Control escolar</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset("bower_components/bootstrap/dist/css/bootstrap.min.css") }}">  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset("bower_components/font-awesome/css/font-awesome.min.css") }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset("bower_components/Ionicons/css/ionicons.min.css") }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset("dist/css/AdminLTE.min.css") }}">

  <link rel="stylesheet" href="{{ asset("bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css") }}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset("dist/css/skins/_all-skins.min.css") }}">
  
  <link rel="stylesheet" href="{{ asset("bower_components/select2/dist/css/select2.min.css") }}">


  <link rel="shortcut icon" href="{{ asset("images/favicon.ico") }}">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style type="text/css" media="screen">
    .content-wrapper{background-image: url(/images/fondo.jpg);}  
    .flotante {
      display:scroll;
          position:fixed;
          bottom: 0px;
          right:0px;
  }
  </style>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="{{ url('/') }}" class="navbar-brand"><b>Maniquie</b></a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          @if (!Auth::guest())
          <ul class="nav navbar-nav">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Catalogos<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('conceptocobro.index') }}">Conceptos de cobro</a></li>
              </ul>
            </li>
            <li  class="dropdown active">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Escolar<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">                
                <li><a href="{{ route('cicloescolar.index') }}">Ciclo Escolar</a></li>
                <li><a href="{{ route('nivelescolar.index') }}">Niveles</a></li>
                <li><a href="{{ route('grupos.index') }}">Grupos</a></li>
                <li><a href="{{ route('alumnos.index') }}">Alumnos</a></li>
              </ul>
            </li>            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Cobranza<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('planpago.index') }}">Planes de pago y conceptos de cobro</a></li>
                <li><a href="{{ route('becas.index') }}">Tipos de Becas</a></li>
                <li><a href="{{ route('politicaplanpago.index') }}">Politicas de descuento</a></li>
                <li><a href="{{ route('cuentasasignadas.create') }}">Asignar cuentas</a></li>
              </ul>
            </li>
            <li><a href="{{ route('cobros.index') }}">Cobrar</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Reportes<span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="/cobros/reporte/">Cuentas cobradas</a></li>
                <li><a href="/cobros/deudores/">Deudores</a></li>
              </ul>
            </li>
            <li><a href="/wizard">Wizard</a></li>
            @if (Auth::user()->hasRole("admin"))
             <!-- <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">admin<span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="/usuarios/">Usuarios</a></li>
                </ul>
              </li>-->
            @endif
            <li>              
              <select id="id_ciclo" name="id_ciclo" class="form-control" style="margin-top: 8px;">
                <option value="0">Seleccione un ciclo</option>
                @foreach($sessionopcions as $sessionopcion)                
                  <option value="{{$sessionopcion->id}}" {{($sessionopcion->id == session('session_cart')) ? 'selected' : ''}}>{{ $sessionopcion->descripcion }}</option>
                @endforeach
              </select>
            </li>
          </ul>  
          @endif        
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <!-- Messages: style can be found in dropdown.less-->

            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                @guest
                    <img src="{{ asset("dist/img/user2-160x160.jpg") }}" class="user-image" alt="User Image">
                  @else
                    <img src="/images/{{ Auth::user()->foto }}" class="user-image" align="middle" alt="User Image">
                @endguest
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">
                    @guest
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar') }}</a>
                      @else
                        {{ Auth::user()->name }}
                    @endguest</span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  @guest
                      <img src="{{ asset("dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image">
                    @else
                      <img src="/images/{{ Auth::user()->foto }}" class="img-circle" alt="User Image">
                  @endguest
                  

                  <p>
                    @guest
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Iniciar') }}</a>
                      @else
                        {{ Auth::user()->name }}
                    @endguest
                  </p>
                </li>
                <li class="user-footer" style="background-color:gray ;">                  
                  <div class="pull-right">
                    <a href="#" class="btn btn-default btn-flat" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar sesión</a>
                  </div>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                  </form>
                </li>
              </ul>
            </li>
            @guest
            @else
              <li class="container2"><a href="#" class="btn btn-primary btn-xs" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Cerrar sesión</a></li>
            @endguest            
          </ul>
        </div>
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div class="container">
      <!-- Content Header (Page header) -->
      <section class="content-header">        
        <h1>
           <!-- session('session_cart') -->
          @yield("encabezado")
          <small>@yield("subencabezado")</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>          
          <li class="active">Bienvenidos</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        @yield("contenidoprincipal")
        <a class='flotante' href="{{ route('cobros.index') }}"><img src='/images/boton_flotante.png' width="80" border="0"/></a>

      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="container">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
      </div>
      <strong>Copyright &copy; 2019-2020 
    </div>
    <!-- /.container -->
  </footer>
</div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="{{ asset("bower_components/jquery/dist/jquery.min.js") }}"></script>
<script src="{{ asset("bower_components/bootstrap/dist/js/bootstrap.min.js") }}"></script>
<script src="{{ asset("bower_components/datatables.net/js/jquery.dataTables.min.js") }}"></script>
<script src="{{ asset("bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js") }}"></script>
<script src="{{ asset("bower_components/jquery-slimscroll/jquery.slimscroll.min.js") }}"></script>
<script src="{{ asset("bower_components/fastclick/lib/fastclick.js") }}"></script>
<script src="{{ asset("dist/js/adminlte.min.js") }}"></script>
<script src="{{ asset("dist/js/demo.js") }}"></script>
<script src="{{ asset("bower_components/select2/dist/js/select2.full.min.js") }}"></script>
<!-- Select2 
https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css
https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js
https://cdn.datatables.net/buttons/1.4.0/js/dataTables.buttons.min.js
https://cdn.datatables.net/buttons/1.4.0/js/buttons.flash.min.js
https://cdn.datatables.net/buttons/1.4.0/js/buttons.html5.min.js
https://cdn.datatables.net/buttons/1.4.0/js/buttons.print.min.js
https://cdn.datatables.net/buttons/1.4.0/css/buttons.dataTables.min.css
https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js
https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js
https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js
-->

@yield("scriptpie")
<style>
.container2:hover {
  background-color: gray;
}
</style>
<script type="text/javascript">
$(document).ready(function()
{
  if($("#id_ciclo").val()==0){
    $.ajax({
       url:"/cicloescolar/cicloreciente/",
       dataType:"json",
       success:function(html){
          $("#id_ciclo").val(html.data.id);          
       }
    })
  }
  $("#id_ciclo").change(function(){ 
   // var id="e";
   var id = $("#id_ciclo").val();
    
   $.ajax({     
        url:"/home/sessionciclo/"+id,
        success: function(data)
        {
          location.reload(); 
        }
    }); 
  }); 

});


</script>
</body>
</html>
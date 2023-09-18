@extends("../layout.plantilla")

@section("encabezado")
<a href="{{ route('usuarios.index') }}"><button type="button" class="btn btn-success">Usuarios</button></a>
@endsection("encabezado")

@section("subencabezado")

@endsection("subencabezado")

@section("contenidoprincipal")
  <div class="row">
        <!-- left column -->
        <form name="form1" id="form1" role="form" method="post" action="/usuarios/{{$usuario->id}}"  enctype="multipart/form-data" >
        {{ csrf_field() }}
        <input type="hidden" name="_method" value="PUT">
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Editar usuario</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nombre</label>
                      <input type="text" class="form-control" id="name" name="name" required placeholder="Nombre completo" value="{{$usuario->name}}">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Email</label>
                      <input type="email" class="form-control" id="email" name="email" required placeholder="email" value="{{$usuario->email}}">
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Password</label>
                      <input type="password" class="form-control" id="password" name="password" required value="{{$usuario->password}}" >
                    </div>
                  </div>
                  <div class="col-xs-6">   
                    <div class="form-group">
                      <label for="exampleInputPassword1">Confirmar password</label>
                      <input type="password" class="form-control" id="confirm_password" name="confirm_password" required value="{{$usuario->password}}">
                    </div>  
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Tipo de usuario</label>
                      <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                        <option value="0">Seleccion</option>
                        <option value="1" {{ ($usuario->roles[0]->name =='admin') ? 'selected' : ''}}>Administrador</option>
                        <option value="2" {{ ($usuario->roles[0]->name =='caja') ? 'selected' : ''}}>Caja</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <br>
                      <button type="submit" class="btn btn-primary">Registrar</button>
                      <a href="{{ route('usuarios.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
                        @if($errors->any())
                          @foreach($errors->all() as $error)
                            <h3>{{$error}}</h3>
                          @endforeach
                        @endif
                    </div> 
                  </div>
                </div>                                                                       
              </div>
              <!-- /.box-body -->                       
          </div>
          <!-- /.box -->
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body"> 
                                                             
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
              </div>
          </div>
          <!-- /.box -->
          <!-- general form elements disabled -->         
          <!-- /.box -->
        </div>
        </form>
        <!--/.col (right) -->
      </div>

@endsection("contenidoprincipal")
@section("scriptpie")
<script>
  $("form").submit(function(){
    //alert("Submitted");
    email             = $('#email').val();
    password          = $('#password').val();
    confirm_password  = $('#confirm_password').val();
    email_uso         = 0;
    $.ajax({
       url:"/usuarios/consultaemail/"+email,
       async: false, 
       dataType:"json",
       success:function(html){
          email_uso = html.data;          
       }
    });
    //alert(email_uso);
   /* if(email_uso == 1){
      alert("el correo ingresado ya esta en uso");
      $('#email').focus();
      return false;
    }*/
    if( $('#tipo_usuario').val()<= 0){
      alert("Selecciona el tipo de usuario");
      $('#tipo_usuario').focus();
      return false; 
    }
    if(password != confirm_password){
      alert("las contraseñas no coinciden...");
      $('#confirm_password').focus();
      event.preventDefault();
    }

  });
</script>
@endsection("scriptpie")

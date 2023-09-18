@extends("../layout.plantilla")

@section("encabezado")
  <a href="{{ route('alumnos.index') }}"><button type="button" class="btn btn-success">Alumnos</button></a>
@endsection("encabezado")

@section("subencabezado")
  
@endsection("subencabezado")

@section("contenidoprincipal")
<style type="text/css" >
.form-group{
  margin-bottom:4px;
}

  
</style>
	<div class="row">
        <!-- left column -->
        <form id="frm" name="frm" role="form" method="post" action="/alumnos"  enctype="multipart/form-data" >
        @csrf
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Datos del alumno</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->            
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Apellido paterno</label>
                      <input type="text" class="form-control" id="apaterno" name="apaterno" required placeholder="A. paterno"  onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Apellido materno</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="amaterno" name="amaterno" required placeholder="A. materno">
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Nombres</label>
                  <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="nombres" name="nombres" required placeholder="Nombre">
                </div>   
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Genero</label>
                      <select class="form-control" id="genero" name="genero" required>
                        <option>Hombre</option>
                        <option>Mujer</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Fecha de nacimiento</label>
                      <input type="date" class="form-control" id="fecha_nac" name="fecha_nac" required>
                    </div>
                  </div>
                </div> 
               <!-- <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Lugar de nacimiento</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="lugar_nac" name="lugar_nac" required>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Estado civil</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="edo_civil" name="edo_civil" required>
                    </div>
                  </div>
                </div>-->
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">CURP</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="curp" name="curp" required placeholder="Clave unica de registro poblacional">
                    </div> 
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">email</label>
                      <input type="text" class="form-control" id="email" name="email"  placeholder="correo electronico" value=" ">
                    </div>
                  </div>
                </div> 
                <div class="form-group">
                  <label for="exampleInputPassword1">Domicilio</label>
                  <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();" class="form-control" id="domicilio" name="domicilio" placeholder="domicilio">
                </div>         
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Ciudad</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="ciudad" name="ciudad" placeholder="Ciudad">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Estado</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="estado" name="estado" placeholder="Estado">
                    </div>
                  </div>
                </div>
                <div class="row">                  
                  <div class="col-xs-4">
                    <div class="form-group">
                      <label for="exampleInputPassword1">C.P.</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="cp" name="cp" placeholder="codigo postal">
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Teléfono de casa</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="telefono" name="telefono" placeholder="teléfono">
                    </div>
                  </div>
                  <div class="col-xs-4">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Teléfono móvil</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="telefono2" name="telefono2" placeholder="teléfono móvil">
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
            <div class="box-header with-border">
              <h3 class="box-title">Datos del tutor</h3>
            </div>
              <div class="box-body">                                                
                <div class="row">                  
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Nombre del tutor</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="nombre_tutor" name="nombre_tutor" placeholder="Nombre del tutor">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Parentesco del tutor</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="parentesco_tutor" name="parentesco_tutor" placeholder="Parentesco del tutor">
                    </div>                    
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Teléfono del tutor</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="telefono_tutor" name="telefono_tutor" placeholder="Teléfono del tutor">
                    </div>                    
                  </div>              
                </div>    
                <div class="box-header with-border">
                  <b><h3 class="box-title">Datos de facturación</h3></b>
                </div>
                <div class="row">                  
                  <div class="col-xs-12">
                    <div class="form-group">
                      <label for="exampleInputPassword1">Razón social</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="razon_social" name="razon_social" placeholder="Razón social">
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">RFC</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="rfc" name="rfc" placeholder="RFC">
                    </div>                    
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputEmail1">Uso del CFDI</label>
                      <input type="text" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase();ComprobarAcentos(this);" class="form-control" id="uso_cfdi" name="uso_cfdi" placeholder="Uso del CFDI">
                    </div>                    
                  </div>              
                </div>             
                <div class="row">
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label>Status</label>
                      <select class="form-control" id="status" name="status" required>
                        <option>activo</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-6">
                    <div class="form-group">
                      <label for="exampleInputFile">Foto</label>
                      <input type="file" id="foto" name="foto">
                    </div> 
                  </div>
                </div>                                               
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button id="btn-guardar" type="submit" class="btn btn-primary">Guardar alumno</button>
                <a href="{{ route('alumnos.index') }}"><button type="button" class="btn btn-danger">Cancelar</button></a>
                @if($errors->any())
                  @foreach($errors->all() as $error)
                    <h3>{{$error}}</h3>
                  @endforeach
                @endif
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
<script type="text/javascript">
  
  $(document).ready(function(){
    $('#frm').bind('submit', function (e) {
      var button = $('#btn-guardar');
      //Disable the submit button while evaluating if the form should be submitted
      button.prop('disabled', true);
      var valid = true;    
      //Do stuff (validations, etc) here and set
      //"valid" to false if the validation fails
      //alert("se");
      if (!valid) { 
          //Prevent form from submitting if validation failed
          e.preventDefault();
          //Reactivate the button if the form was not submitted
          button.prop('disabled', false);
      }
    });
  });
  function ComprobarAcentos(inputtext)
  {
    if(!inputtext) return false;
    if(inputtext.value.match('[á,é,í,ó,ú]|[Á,É,Í,Ó,Ú]'))
    {
      alert('No se permiten acentos en la casilla');
      inputtext.value = '';
      inputtext.focus();
      return true;
    }
    return false;
  }

  $("form").submit(function( event ) {
    var curp  = $('#curp').val();
    var id    = 0;
    var cont  = 0;
    $.ajax({
       url:"/alumnos/consultacurp/"+id+"/"+curp,
       async: false,
       dataType:"json",
       success:function(html){
          cont = html.data;
       }
    })
    if(cont>0){
      alert("LA CURP YA EXISTE... VERIFICAR...");
      $('#curp').focus();
      event.preventDefault();
      button.prop('disabled', false);
    }else{
      button.prop('disabled', true);      
    }   
  });
</script>
@endsection("scriptpie")
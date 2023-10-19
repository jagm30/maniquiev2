<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/grupos/excel','GrupoController@export');
Route::get('/grupoalumnos/excel/{id}','GrupoalumnoController@export')->name('export');

Route::get('alumnos/ConsultaCuentas/{id}', 'AlumnoController@ConsultaCuentas')->name('consultacuentas');

Route::get('alumnos/cuenta_asignada/{id}', 'AlumnoController@alumnosCuentasAsiganadas')->name('cuentaasignada');

Route::get('/alumnos/print-pdf/{id}', [ 'as' => 'alumnos.printpdf', 'uses' => 'AlumnoController@printPDF']);

Route::get('/alumnos/becas/{id}', 'AlumnoController@becas')->name('becas');

Route::get('/alumnos/consultaeliminar/{id}', 'AlumnoController@consultaeliminar')->name('consultaeliminar');

Route::get('/alumnos/consultacurp/{id}/{curp}', 'AlumnoController@consultacurp')->name('consultacurp');

Route::get('/alumnos/grupo/{id}', 'AlumnoController@grupo')->name('grupo');

Route::get('alumnos/delete/{id}', 'AlumnoController@destroy')->name('delete');

Route::resource('alumnos', 'AlumnoController');

Route::get('cicloescolar/cicloreciente/','CicloescolarController@cicloReciente')->name('cicloreciente');

Route::resource('cicloescolar', 'CicloescolarController');

Route::resource('nivelescolar', 'NivelescolarController');

Route::get('grupos/listarxciclo/{id}','GrupoController@listarxciclo')->name('listarxciclo');

Route::get('grupos/guardargrupo/{datos}','GrupoController@guardargrupo')->name('guardargrupo');

Route::get('grupos/transferirgrupoalumno/{grupoant}/{grupoact}','GrupoController@transferirgrupoalumno')->name('transferirgrupoalumno');

Route::resource('grupos', 'GrupoController');
////reportess PDF
Route::get('/grupoalumnos/print-pdf/{id}', [ 'as' => 'grupoalumnos.printpdf', 'uses' => 'GrupoalumnoController@printPDF']);

Route::get('grupoalumnos/consultaexiste/{id}','GrupoalumnoController@consultaExiste')->name('consultaexiste');

Route::resource('grupoalumnos', 'GrupoalumnoController');

Route::post('grupoalumnos/update', 'GrupoalumnoController@update')->name('grupoalumnos.update');

Route::get('grupoalumnos/destroy/{id}', 'GrupoalumnoController@destroy');

Route::resource('conceptocobro', 'ConceptocobroController');

Route::get('planpago/listarplanxciclo/{id_ciclo}','PlanpagoController@listarplanxciclo')->name('listarplanxciclo');

Route::get('planpago/clonar/{id_plan}/{codigo}/{desc}/{per}','PlanpagoController@clonarplan')->name('clonarplan');

Route::resource('planpago', 'PlanpagoController');

Route::resource('planpagoconcepto', 'PlanpagoconceptoController');

Route::post('planpagoconcepto/update', 'PlanpagoconceptoController@update')->name('planpagoconcepto.update');

Route::get('planpagoconcepto/destroy/{id}', 'PlanpagoconceptoController@destroy');
//Route::get('/alumnos/crear','AlumnoController@create');

Route::resource('politicaplanpago', 'PoliticaplanpagoController');

Route::resource('becas', 'BecaController');

Route::get('cuentasasignadas/opcion_asignacion/{id}','CuentaasignadaController@opcionAsignacion')->name('opcion_asignacion');

Route::get('cuentasasignadas/listar_opcion_asignacion/{id}/{subop}','CuentaasignadaController@listarOpcionAsignacion')->name('listaropasignacion');

Route::get('cuentasasignadas/guardar_opcion_asignacion/{id}/{subop}/{selected}/{planpago}/{conceptos}','CuentaasignadaController@guardarOpcionAsignacion')->name('guardaropcionasignacion');

Route::get('cuentasasignadas/cuenta_asignada/{id}/{opcion}/{planpago}','CuentaasignadaController@CuentasAsignadas')->name('cuentaasignada');

Route::resource('cuentasasignadas', 'CuentaasignadaController');

Route::get('cuentasasignadas/destroy/{id}', 'CuentaasignadaController@destroy');

Route::get('becaalumno/guardar/{id_beca}/{selected}/{id_alumno}/{id_grupo}','BecaalumnoController@RegistrarBeca')->name('registrarbeca');

Route::resource('becaalumno', 'BecaalumnoController');

Route::get('becaalumno/destroy/{id}', 'BecaalumnoController@destroy');

Route::get('cobros/guardarcobro/{datos}', 'CobroController@guardarCobro')->name('guardarcobro');

Route::get('cobros/cuentapagada/{id}', 'CobroController@cuentaPagada')->name('cuentapagada');

////reportess PDF
Route::get('/cobros/print-pdf/{id}/{flag}', [ 'as' => 'cobros.printpdf', 'uses' => 'CobroController@printPDF']);
Route::get('/cobros/printPDFcancelado/{id}/{idcta}', [ 'as' => 'cobros.printPDFcancelado', 'uses' => 'CobroController@printPDFcancelado']);

Route::get('/cobros/carnetpagopdf/{id}', [ 'as' => 'cobros.carnetpagopdf', 'uses' => 'CobroController@carnetpagoPDF']);

Route::get('/cobros/cuentas-pdf/{id}', [ 'as' => 'cobros.cuentaspdf', 'uses' => 'CobroController@cuentasPDF']);
//Route::get('/alumnos/print-pdf/{id}', [ 'as' => 'alumnos.printpdf', 'uses' => 'AlumnoController@printPDF']);
Route::get('cobros/reporte/', 'CobroController@reporte')->name('reporte');

Route::get('cobros/deudores/', 'CobroController@deudores')->name('deudores');

Route::get('cobros/excel/{fecha1}/{fecha2}','CobroController@exportExcel')->name('exportexcel');

Route::get('cobros/exceldeudores/{fecha1?}/{fecha2?}','CobroController@exceldeudores')->name('exportexcel');

Route::get('cobros/reporteCobros/{fecha1}/{fecha2}', 'CobroController@reporteCobros')->name('reportecobros');

Route::get('cobros/reportedeudoresPDF/{fecha1?}/{fecha2?}', 'CobroController@reportedeudoresPDF')->name('reportedeudorespdf');

Route::get('cobros/reporteCobrosPDF/{fecha1}/{fecha2}', 'CobroController@reporteCobrosPDF')->name('reportecobrospdf');

Route::get('/cobros/parcialidad/{id}', 'CobroController@parcialidad')->name('parcialidad');

Route::get('/cobros/cancelar/{id}/{motivo}', 'CobroController@cancelar')->name('cancelar');

Route::resource('cobros', 'CobroController');

Route::resource('cobroscancelados', 'CobrocanceladoController');

Route::get('/cobroparcial/registroabono/{data}', 'CobroparcialController@registroabono')->name('registroabono');

Route::resource('cobroparcial', 'CobroparcialController');

Route::get('descuentos/guardar_descuento/{id_cuentaasignada}/{id_alumno}/{fecha_desc}/{cantidad}/{observaciones}/{id_user}','DescuentoController@guardarDescuento')->name('guardardescuento');

Route::resource('descuentos', 'DescuentoController');

Route::get('usuarios/consultaemail/{email}','UsuarioController@consultaEmail')->name('consultaemail');

Route::resource('usuarios', 'UsuarioController');
Route::resource('wizard', 'WizardController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('home/sessionciclo/{id}', 'HomeController@sessionciclo')->name('home.sessionciclo');

<?php
use App\permiso;
use App\medico;
use App\fallecimiento;
use App\MaterPater;
use App\empleado;
use App\user;
use App\medicoG;
use App\personal;
use App\obligacionCiudadano;


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
	$datosMedicos = medico::all();
	$datosFallecidos = fallecimiento::all();
	$datosMaterPater = MaterPater::all();
    $id = Auth::user()->id;
    $empleadoss = empleado::where('cod_empleado','=', $id)->first()->tiempo_disponible;
    $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado; 

    if ($cargo == 'Secretaria') {
    	$valor = '';
    }else{
    	$valor = 'none';
    }

    return view('permisos.index', compact('empleadoss','cargo', 'valor','datosMedicos','datosFallecidos','datosMaterPater'));
})->middleware('auth');

Route::get('/verAdmin', function () {
	  $idEmpleado = Auth::user()->id;
	$cargo = empleado::where('cod_empleado','=',$idEmpleado)->first()->cargo_empleado; 
       if ($cargo == 'Secretaria') { 

	  $datosMedicos = medico::all();
       $datosFallecidos = fallecimiento::all();
       $datosMaterPater = MaterPater::all();
       $datosMedicosG = medicoG::all();
       $datosPersonales = personal::all();
        $datosObligacion = obligacionCiudadano::all();


     
       $empleadoss = empleado::where('cod_empleado','=', $idEmpleado)->first()->tiempo_disponible;
       return view('permisos.verPermisosAdmin', compact('datosMedicos','empleadoss','datosFallecidos','datosMaterPater','datosMedicosG','datosPersonales','datosObligacion'));
   }else{
   	 return redirect('/');
   }
})->middleware('auth');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('permiso','permisoController')->middleware('auth');
Route::get('/verPermisos', 'permisoController@verPermisos')->middleware('auth')->name('permiso.verPermiso');
Route::get('/verPermisosAdmin', 'permisoController@verPermisosAdmin')->middleware('auth');
Route::post('/test', 'permisoController@buscador');
Route::get('/aceptar', 'permisoController@aceptar')->middleware('auth')->name('permiso.aceptar');
Route::get('/rechazar', 'permisoController@rechazar')->middleware('auth')->name('permiso.rechazar');
Route::resource('permisoo','permisoController2')->middleware('auth');
Route::name('print')->get('/imprimir', 'permisoController2@imprimir');
Route::name('permisoo.imprimirID')->post('/imprimirID', 'permisoController2@imprimirID');
























Route::get('/ingresarPermisos', function ()
{

	//INGRESA DATOS DE LOS PERMISOS EN STOCK
	$dato = new permiso;
	$dato->id_permiso = "1";
	$dato->nombre_permiso = "Permiso Medico";
	$dato->descripcion_permiso = "Extienda su permiso por cualquier percanse de salud que se le haya presentado, ya sean una enfermeda o algun accidente que no le permita mobilisarse.";
	$dato->save();

		$dato = new permiso;
	$dato->id_permiso = "2";
	$dato->nombre_permiso = "Permiso Fallecimiento";
	$dato->descripcion_permiso = "Obtenga su permisos por fallecimiento, es necesario que sea un familiar que sea cercano es decir: Papá, Mamá, Hermanos o Hijos.";
	$dato->save();

	$dato = new permiso;
	$dato->id_permiso = "3";
	$dato->nombre_permiso = "Permiso Maternidad o Paternidad";
	$dato->descripcion_permiso = "Solicite su permisos de materniadad  o paternidad, segun sea su genero se aplicaran las horas en las cuales usted estara solicitando el permiso";
	$dato->save();

	$dato = new permiso;
	$dato->id_permiso = "4";
	$dato->nombre_permiso = "Permiso Medico Grave";
	$dato->descripcion_permiso = "Extienda su permiso por cualquier percanse de salud que se grave, algun accidente, cortadura o cualquier insidente que se bastante grave.";
	$dato->save();

		$dato = new permiso;
	$dato->id_permiso = "6";
	$dato->nombre_permiso = "Permiso Personal";
	$dato->descripcion_permiso = "Solicite su permisos personales sobre cualquier percance o inconveniente que usted este pasando sin necesidad de presentar una evidencia.";
	$dato->save();

		$dato = new permiso;
	$dato->id_permiso = "7";
	$dato->nombre_permiso = "Permiso por Obligacion Ciudadana";
	$dato->descripcion_permiso = "Solicite su permisos por obligacion ciudadana, por cualquier evento que requiera hacer de su presencia de manera legal";
	$dato->save();


	//INGRESA DATOS COMPLETOS DE LOS EMPLEADOS
	$dato = new empleado;
	$dato->cod_empleado = "1";
	$dato->nombre = "Juan Jose";
	$dato->apellido = "Perez Gomez";
	$dato->dui = "063514959";
	$dato->edad = "26";
	$dato->departamento = "Administración";
	$dato->jefe_inmediato = "Oscar Alberto Ceren Potter";
	$dato->cargo_empleado = "Recursos Humanos";
	$dato->sexo = "M";
	$dato->save();

	$dato = new empleado;
	$dato->cod_empleado = "2";
	$dato->nombre = "Pedro Alfonso";
	$dato->apellido = "Castro Funes";
	$dato->dui = "248513694";
	$dato->edad = "29";
	$dato->departamento = "Mantenimento";
	$dato->jefe_inmediato = "Ronal Ernesto Mejia Rivera";
	$dato->cargo_empleado = "Operador de bodega";
	$dato->sexo = "M";
	$dato->save();

	$dato = new empleado;
	$dato->cod_empleado = "3";
	$dato->nombre = "Luciana Andrea";
	$dato->apellido = "Sandoval Hernandez";
	$dato->dui = "256314752";
	$dato->edad = "35";
	$dato->departamento = "Atencion al cliente";
	$dato->jefe_inmediato = "Joel Cesar Caceres Cruz";
	$dato->cargo_empleado = "Secretaria";
	$dato->sexo = "F";
	$dato->save();


	//INGRESA DATOS DE LOS USERS Y PASS
	$dato = new user;
	$dato->id = "1";
	$dato->cod_empleado_fk = "1";
	$dato->name = "Juan Jose Perez Gomez";
	$dato->email = "juangomez@miempresa.com";
	$dato->password = "$2y$10$.HFJkZU..UxOHhXnyfcT/exK7QUYCEgJOfha.3h3LAWgA3QEOolpq";
	$dato->save();


	$dato = new user;
	$dato->id = "2";
	$dato->cod_empleado_fk = "2";
	$dato->name = "Pedro Alfonso Castro Funes";
	$dato->email = "pedrofunes@miempresa.com";
	$dato->password = "$2y$10$2L9RJyOqv5JoMs7mahkyluy6sASZkEVsHg13EZhqQXz4W6iuEX6v.";
	$dato->save();


	$dato = new user;
	$dato->id = "3";
	$dato->cod_empleado_fk = "3";
	$dato->name = "Luciana Andrea Sandoval Hernandez";
	$dato->email = "lucianahernandez@miempresa.com";
	$dato->password = '$2y$10$ubkVfHT2yBT.d1lt7BkI5.vq98yI33.Q0Kh/LvmuIPl7cYhtk/p7i';
	$dato->save();
	});

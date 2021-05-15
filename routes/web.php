<?php
use App\permiso;
use App\solicitud_permiso;
use App\empleado;
use App\user;


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
    $id = Auth::user()->id;
    $empleadoss = empleado::where('cod_empleado','=', $id)->first()->tiempo_disponible;
    $cargo = empleado::where('cod_empleado','=',$id)->first()->cargo_empleado; 

    if ($cargo == 'Secretaria') {
    	$valor = '';
    }else{
    	$valor = 'none';
    }

    return view('permisos.index', compact('empleadoss','cargo', 'valor'));
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('permiso','permisoController')->middleware('auth');
Route::get('/verPermisos', 'permisoController@verPermisos')->middleware('auth');
Route::get('/verPermisosAdmin', 'permisoController@verPermisosAdmin')->middleware('auth');

Route::post('/test', 'permisoController@buscador');


Route::get('/aceptar', 'permisoController@aceptar')->middleware('auth')->name('permiso.aceptar');
Route::get('/rechazar', 'permisoController@rechazar')->middleware('auth')->name('permiso.rechazar');



Route::get('/ingresarPermisos', function ()
{
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
	$dato->nombre_permiso = "Permiso Matrimonio";
	$dato->descripcion_permiso = "Solicite su permisos matrimonial ya sea civil o religioso con dos días sin goce de sueldo segun la ley establecidad.";
	$dato->save();
	});

Route::get('/ingresarDatos', function ()
{
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
	});


Route::get('/ingresarDatosUsers', function ()
{
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


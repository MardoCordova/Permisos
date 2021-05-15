<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleados', function (Blueprint $table) {
            $table->string('cod_empleado',2)->primary();
            $table->string('nombre', 30);
            $table->string('apellido', 40);
            $table->string('dui', 9)->unique();
            $table->string('edad', 3);
            $table->string('departamento', 30);
            $table->string('jefe_inmediato',80);
            $table->string('cargo_empleado',30);
            $table->decimal('tiempo_disponible')->default(120);
            $table->char('sexo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleados');
    }
}

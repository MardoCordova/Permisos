<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedicoGSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medico_g_s', function (Blueprint $table) {
             $table->string('id_solicitud')->primary();
            $table->string('id_permiso_fk');
            $table->timestamp('fecha_salida');
            $table->timestamp('fecha_entrada')->default(NULL);
            $table->string('motivo_permiso');
            $table->string('estado_revision');
            $table->unsignedbigInteger('cod_users_fk');

        $table->foreign('id_permiso_fk')
           ->references('id_permiso')
           ->on('permisos')
           ->onDelete('cascade');

        $table->foreign('cod_users_fk')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

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
        Schema::dropIfExists('medico_g_s');
    }
}

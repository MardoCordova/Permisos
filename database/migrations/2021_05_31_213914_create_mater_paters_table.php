<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterPatersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mater_paters', function (Blueprint $table) {
            $table->string('id_solicitud')->primary();
            $table->string('id_permiso_fk');
            $table->timestamp('fecha_salida');
            $table->timestamp('fecha_entrada');
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
        Schema::dropIfExists('mater_paters');
    }
}

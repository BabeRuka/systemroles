<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemRolesTable extends Migration
{
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');


        Schema::create('system_roles', function (Blueprint $table) {
            $table->bigIncrements('role_id');
            $table->string('role_name', 191)->unique();
            $table->string('role_guard_name', 191)->unique();
            $table->string('role_description', 255)->nullable();
            $table->enum('role_lang_name', ['eng'])->default('eng');
            $table->enum('role_role_class', ['RolesController'])->nullable()->default('RolesController');
            $table->integer('role_sequence')->nullable();
            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function down()
    {
        Schema::dropIfExists('system_roles');
    }
}

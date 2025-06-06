<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUserRolesTable extends Migration
{
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('user_roles', function (Blueprint $table) {
            $table->bigIncrements('role_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_role');
            $table->integer('role_admin')->nullable();
            $table->string('role_type', 255)->nullable();
            $table->timestamps();

            $table->foreign('user_role')->references('role_id')->on('system_roles')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}

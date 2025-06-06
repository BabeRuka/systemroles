<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateSystemRolesInTable extends Migration
{
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('system_roles_in', function (Blueprint $table) {
            $table->bigIncrements('in_id');
            $table->unsignedBigInteger('role_id');
            $table->string('in_name', 191);
            $table->enum('in_role', ['0', '1', '2'])->default('0');
            $table->string('in_guard_name', 191);
            $table->integer('in_sequence')->nullable();
            $table->timestamps();

            $table->unique(['in_name', 'role_id']);
            $table->unique(['in_guard_name', 'role_id']);
            $table->foreign('role_id')->references('role_id')->on('system_roles')->onDelete('restrict')->onUpdate('restrict');
        });
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function down()
    {
        Schema::dropIfExists('system_roles_in');
    }
}

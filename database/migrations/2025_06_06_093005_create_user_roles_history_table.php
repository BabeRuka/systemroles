<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUserRolesHistoryTable extends Migration
{
    public function up()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::create('user_roles_history', function (Blueprint $table) {
            $table->bigIncrements('history_id');
            $table->integer('role_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->unsignedBigInteger('user_role')->nullable();
            $table->integer('role_admin')->nullable();
            $table->string('role_type', 255)->nullable();
            $table->timestamps();
        });

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    }

    public function down()
    {
        Schema::dropIfExists('user_roles_history');
    }
}

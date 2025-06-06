<?php
class CreateUserRolesHistoryTable extends Migration
{
    public function up()
    {
        Schema::create('user_roles_history', function (Blueprint $table) {
            $table->bigIncrements('history_id');
            $table->integer('role_id')->nullable();
            $table->integer('user_id')->nullable();
            $table->unsignedBigInteger('user_role')->nullable();
            $table->integer('role_admin')->nullable();
            $table->string('role_type', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_roles_history');
    }
}

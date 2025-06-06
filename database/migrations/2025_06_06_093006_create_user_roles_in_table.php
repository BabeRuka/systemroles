<?php
class CreateUserRolesInTable extends Migration
{
    public function up()
    {
        Schema::create('user_roles_in', function (Blueprint $table) {
            $table->bigIncrements('perm_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('in_id');
            $table->integer('in_role')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('in_id')->references('in_id')->on('system_roles_in')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_roles_in');
    }
}


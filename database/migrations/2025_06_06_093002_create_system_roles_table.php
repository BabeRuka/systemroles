<?php
class CreateSystemRolesTable extends Migration
{
    public function up()
    {
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
    }

    public function down()
    {
        Schema::dropIfExists('system_roles');
    }
}

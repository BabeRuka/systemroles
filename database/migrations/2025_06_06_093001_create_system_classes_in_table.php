<?php
class CreateSystemClassesInTable extends Migration
{
    public function up()
    {
        Schema::create('system_classes_in', function (Blueprint $table) {
            $table->bigIncrements('in_id');
            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('class_id');
            $table->enum('in_role', ['0', '1', '2'])->default('0');
            $table->timestamps();

            $table->unique(['class_id', 'role_id']);
            $table->foreign('class_id')->references('class_id')->on('system_classes')->onDelete('restrict')->onUpdate('restrict');
            $table->foreign('role_id')->references('role_id')->on('system_roles')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_classes_in');
    }
}

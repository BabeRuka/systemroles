<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSystemClassesTable extends Migration
{
    public function up()
    {
        Schema::create('system_classes', function (Blueprint $table) {
            $table->bigIncrements('class_id');
            $table->string('class_name', 191)->unique();
            $table->string('class_filename', 191)->unique();
            $table->string('class_description', 255)->nullable();
            $table->string('class_namespace', 255);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('system_classes');
    }
}

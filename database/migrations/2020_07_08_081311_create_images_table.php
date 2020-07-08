<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->index();
            $table->string('type')->index();
            $table->string('storage_type')->nullable()->comment("存储类型，图片还是视频,image代表图片，video代表音频");
            $table->string('path');
            $table->integer("target_id")->nullable()->comment("外键ID");
            $table->string("target_type")->nullable()->comment("外键类型");
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
        Schema::dropIfExists('images');
    }
}

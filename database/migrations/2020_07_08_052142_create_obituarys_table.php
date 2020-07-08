<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**生死簿 */
class CreateObituarysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('obituarys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name")->unique()->comment("名称");
            $table->unsignedBigInteger("used_age")->nullable()->default("0")->comment("已过年龄");
            $table->unsignedBigInteger("age")->nullable()->default("0")->comment("年龄");
            $table->string("specie_type")->nullable()->default("human")->comment("物种类型，默认是人");
            $table->string("dead_type")->nullable()->comment("死亡方式，默认是善终");
            $table->string("dead_type_detail")->nullable()->comment("死亡详细方式");
            $table->string("status")->nullable()->comment("状态");
            $table->text("images")->nullable()->comment("图片");
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
        Schema::dropIfExists('obituarys');
    }
}

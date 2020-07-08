<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**地府操作日志 */
class CreateAdminLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("user_id")->nullable()->default("0")->comment("操作者ID");
            $table->unsignedBigInteger("status")->nullable()->default("0")->comment("状态");
            $table->string("type")->nullable()->default("0")->comment("操作方式");
            $table->string("remark")->nullable()->default("0")->comment("备注");
            $table->text("extra")->nullable()->comment("额外信息");
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
        Schema::dropIfExists('admin_logs');
    }
}

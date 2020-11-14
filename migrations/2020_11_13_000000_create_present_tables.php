<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePresentTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 55)->comment('礼物名称');
            $table->string('thumbnail')->nullable()->comment('礼物图标');
            $table->string('image')->nullable()->comment('礼物大图');
            $table->string('animation', 26)->nullable()->comment('动效');
            $table->unsignedBigInteger('pay_currency_type_id')->index()->comment('支付货币类型');
            $table->decimal('pay_amount')->default(0)->comment('支付数额');
            $table->string('unit', 15)->default('件')->comment('计数单位');
            $table->unsignedBigInteger('exchange_currency_type_id')->index()->comment('兑换货币类型');
            $table->decimal('exchange_amount')->default(0)->comment('兑换数额');
            $table->unsignedInteger('exchange_exp')->default(0)->comment('兑换经验');
            $table->boolean('is_broadcast')->default(0)->comment('是否广播');
            $table->boolean('status')->default(0)->comment('状态');
            $table->unsignedInteger('sort')->default(0)->comment('排序');
            $table->timestamps();
        });

        Schema::create('present_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('present_id')->comment('礼物id');
            $table->unsignedBigInteger('user_id')->comment('送礼会员id');
            $table->unsignedBigInteger('to_user_id')->comment('收礼会员id');
            $table->boolean('status')->default(0)->comment('状态');
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
        Schema::dropIfExists('presents');
        Schema::dropIfExists('present_orders');
    }
}

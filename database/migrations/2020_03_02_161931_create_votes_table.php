<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment("点赞用户的id");
            $table->unsignedBigInteger('answer_id')->index()->comment("被赞答案的id");
            $table->timestamps();
        });
        Schema::table('votes', function (Blueprint $table) {
            //用户表中用户被删除的时候，同步删除votes表user_id列对应的数据行
            $table
                ->foreign('user_id')//本表有一个user_id列
                ->references('id')//指向了id列
                ->on('users')//users表中的那个id列
                ->onDelete('cascade');//users表中id列里面任意一个id数据删除的时候，删除本votes表user_id列对应的数据行

            //答案表中答案被删除的时候，同步删除votes表answer_id对应的数据行
            $table
                ->foreign('answer_id')//本表有一个answer_id列
                ->references('id')//指向了id列
                ->on('answers')//answers表中的那个id列
                ->onDelete('cascade');//answers表中id列里面任意一个id数据删除的时候，删除本votes表answer_id列对应的数据行
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}

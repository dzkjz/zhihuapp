<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('content');
            $table->integer('comments_count')->default(0);
            $table->integer('followers_count')->default(1);//问题的关注者数量，默认1个【提问的人就是最开始关注的那个人】
            $table->integer('answers_count')->default(0);
            $table->string('close_comment', 8)->default('F');//问题是否被关闭评论 F默认否
            $table->string('is_hidden', 8)->default('F');//问题是否被隐藏 F默认否
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
        Schema::dropIfExists('questions');
    }
}

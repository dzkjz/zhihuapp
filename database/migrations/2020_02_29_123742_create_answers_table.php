<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index()->comment("答案是哪个用户创建的");
            $table->unsignedBigInteger('question_id')->index()->comment("答案是回答的哪个问题");
            $table->text('content')->comment("答案的具体内容");
            $table->integer('votes_count')->default(0)->comment("点赞总数");
            $table->integer('comments_count')->default(0)->comment("回复总数");
            $table->string('is_hidden', 8)->default("F")->comment("回答状态是否被隐藏，默认设置长度必须大于8");//默认设置长度必须大于8，否则不被赋值F，即被隐藏
            $table->string('close_comment')->default('F')->comment("回答是否被关闭评论");//默认F代表否，即不关闭，如果需要关闭设置为 T
            $table->softDeletes()->comment("支持软删除");
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
        Schema::dropIfExists('answers');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment("发出评论的用户的id");
            $table->text('content')->comment("评论的内容");
            $table->unsignedBigInteger('commentable_id')->comment("被评论的对象的id");
            $table->string('commentable_type')->comment("被评论的类型 问题或者答案或者评论");
            $table->unsignedBigInteger('parent_id')->nullable()->comment("嵌套评论的上级id");
            $table->unsignedSmallInteger('level')->default(1)->comment("评论属于第几层");
            $table->string('is_hidden', 8)->default("F")->comment("是否隐藏状态");
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
        Schema::dropIfExists('comments');
    }
}

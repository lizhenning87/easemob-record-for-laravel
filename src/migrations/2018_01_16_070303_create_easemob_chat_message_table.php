<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEasemobChatMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('easemob_chat_message', function (Blueprint $table) {

            $table->increments('id');

            $table->string('msg_id')->unique()->index();
            $table->string('timestamp');
            $table->string('to')->comment('接收人的username或者接收group的ID');
            $table->string('from')->comment('发送人username');
            $table->string('chat_type', 10)->comment('chat: 单聊；groupchat: 群聊');
            $table->string('body_type', 10)->comment('txt:文本消息类型, img:图片消息类型, loc:位置消息类型, audio:语音消息类型, video:视频, file:文件消息');
            $table->text('body')->nullable()->comment('消息内容');
            $table->string('secret')->nullable()->comment('密钥');
            $table->string('url')->nullable()->comment('附近下载URL');
            $table->tinyInteger('is_download')->default(1)->comment('下载标示 1下载 2需要下载');
            $table->string('filename', 255)->nullable()->comment('文件名');
            $table->tinyInteger('status')->default(1);
            $table->text('json_original')->nullable()->comment('原始JSON数据');

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
        Schema::dropIfExists('easemob_chat_message');
    }
}

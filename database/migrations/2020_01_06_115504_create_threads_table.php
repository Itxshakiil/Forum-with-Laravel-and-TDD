<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->unique()->nullable();
            $table->unsignedBiginteger('user_id');
            $table->unsignedBiginteger('channel_id');
            $table->unsignedBiginteger('replies_count')->default(0);
            $table->unsignedBiginteger('visits')->default(0);
            $table->unsignedBiginteger('best_reply_id')->nullable();
            $table->boolean('locked')->default(false);
            $table->string('title');
            $table->text('body');
            $table->timestamps();

            $table->foreign('best_reply_id')
            ->references('id')
            ->on('replies')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('threads');
    }
}

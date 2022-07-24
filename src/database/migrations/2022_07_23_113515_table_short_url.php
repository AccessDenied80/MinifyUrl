<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id()->unsigned()->autoIncrement();
            $table->string('short_url', 8);
            $table->string('original_url', 2000);
            $table->boolean('is_unlimited_redirects')->default(false);
            $table->integer('max_redirects')->unsigned()->default(1);
            $table->integer('current_redirects_count')->unsigned()->default(0);
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('short_urls', function (Blueprint $table) {
            $table->index(['short_url', 'deleted_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('short_urls');
    }
};

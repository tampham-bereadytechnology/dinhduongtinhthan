<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rate_posts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('post_id');
            $table->string('post_category');
            $table->integer('rating_stars');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_posts');
    }
};

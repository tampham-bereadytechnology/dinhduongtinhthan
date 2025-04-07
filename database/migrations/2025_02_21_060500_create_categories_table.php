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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->text('description');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete()->index()->name('fk_categories_created_by');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->index()->name('fk_categories_updated_by');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->nullOnDelete()->index()->name('fk_categories_deleted_by');
            $table->boolean('is_published')->default(false);
            $table->string('slug')->unique();
            $table->longText('content');
            $table->string('thumbnail');
            $table->text('meta_name');
            $table->text('meta_desc');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

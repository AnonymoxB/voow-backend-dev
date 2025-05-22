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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->on('users')->onDelete('cascade');
            $table->foreignId('blog_category_id')->constrained()->on('blog_categories')->onDelete('cascade');
            $table->string('title')->nullable();
            $table->text('image')->nullable();
            $table->string('slug')->nullable();
            $table->text('content')->nullable();
            $table->enum('status',['Draft','Publish'])->default('Draft')->nullable();
            $table->enum('lang',['ID','EN'])->default('ID')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->on('users')->onDelete('cascade');
            $table->foreignId('template_id')->constrained()->on('templates')->onDelete('cascade');
            $table->text('link_slug')->nullable();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->date('event_date')->nullable();
            $table->time('event_time')->nullable();
            $table->string('time_zone')->nullable();
            $table->text('address')->nullable();
            $table->enum('status',['Draft','Publish'])->default('Draft')->nullable();
            $table->enum('lang',['ID','EN'])->default('ID')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};

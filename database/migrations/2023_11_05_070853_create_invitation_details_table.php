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
        Schema::create('invitation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->on('invitations')->onDelete('cascade');
            $table->text('opening')->nullable();
            $table->text('home')->nullable();
            $table->text('couple')->nullable();
            $table->text('date')->nullable();
            $table->text('story')->nullable();
            $table->text('gallery')->nullable();
            $table->text('gift')->nullable();
            $table->text('rsvp')->nullable();
            $table->text('thanks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_details');
    }
};

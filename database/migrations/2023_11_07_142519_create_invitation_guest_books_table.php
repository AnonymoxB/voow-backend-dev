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
        Schema::create('invitation_guest_books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->on('invitations')->onDelete('cascade');
            $table->text('name')->nullable();
            $table->text('address')->nullable();
            $table->text('qrcode')->nullable();
            $table->boolean('is_scan')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitation_guest_books');
    }
};

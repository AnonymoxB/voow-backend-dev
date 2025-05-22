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
        Schema::table('invitation_rsvps', function (Blueprint $table) {
            $table->foreignId('invitation_guest_book_id')->after('invitation_id')->constrained()->on('invitation_guest_books')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitation_rsvps', function (Blueprint $table) {
            //
        });
    }
};

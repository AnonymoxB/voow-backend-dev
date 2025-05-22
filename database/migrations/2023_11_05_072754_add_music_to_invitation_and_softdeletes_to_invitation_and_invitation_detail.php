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
        Schema::table('invitations', function (Blueprint $table) {
            $table->foreignId('music_id')->after('user_id')->nullable(true)->constrained()->on('music')->onDelete('cascade')->change();
            $table->boolean('music_active')->default(0)->nullable()->after('music_id');
            $table->softDeletes()->after('parent_id');
        });

        Schema::table('invitation_details', function (Blueprint $table) {
            $table->softDeletes()->after('thanks');
        });

        Schema::table('music', function (Blueprint $table) {
            $table->softDeletes()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            //
        });
    }
};

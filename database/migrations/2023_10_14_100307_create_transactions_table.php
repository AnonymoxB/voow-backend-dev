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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->on('users')->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->on('packages')->onDelete('cascade');
            $table->text('invoice')->nullable();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->bigInteger('price')->nullable();
            $table->bigInteger('admin_price')->nullable();
            $table->bigInteger('price_total')->nullable();
            $table->string('invoice_url')->nullable();
            $table->dateTime('expiry_date')->nullable();
            $table->text('rawJson')->nullable();
            $table->enum('status',["Pending","Success","Failed"])->default("Pending");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

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
        Schema::create('customer_package_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->constrained()->onDelete('cascade');
            $table->enum('status', ['pending_payment', 'paid', 'cancelled', 'expired'])->default('pending_payment');
            $table->enum('payment_method', ['card', 'bank_transfer'])->nullable();
            $table->enum('payment_status', ['waiting', 'success', 'failed'])->default('waiting');
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('starts_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->integer('remaining_question_count')->default(0);
            $table->integer('remaining_voice_count')->default(0);
            $table->string('bank_transfer_receipt_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_package_orders');
    }
};

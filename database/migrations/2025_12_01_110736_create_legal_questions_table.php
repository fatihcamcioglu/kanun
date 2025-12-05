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
        Schema::create('legal_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_id')->constrained('customer_package_orders')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('legal_categories')->onDelete('cascade');
            $table->foreignId('assigned_lawyer_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('title');
            $table->text('question_body');
            $table->enum('status', ['waiting_assignment', 'waiting_lawyer_answer', 'answered', 'closed'])->default('waiting_assignment');
            $table->timestamp('asked_at')->nullable();
            $table->timestamp('answered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_questions');
    }
};

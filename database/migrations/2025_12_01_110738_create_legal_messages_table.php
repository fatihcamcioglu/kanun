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
        Schema::create('legal_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('legal_question_id')->constrained()->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->enum('sender_role', ['CUSTOMER', 'LAWYER', 'ADMIN']);
            $table->text('message_body')->nullable();
            $table->string('voice_path')->nullable();
            $table->string('attachment_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('legal_messages');
    }
};

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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null')->comment('İşlemi Yapan Kullanıcı');
            $table->string('action')->comment('Yapılan İşlem');
            $table->text('description')->comment('Açıklama');
            $table->string('model_type')->nullable()->comment('İlgili Model Tipi');
            $table->unsignedBigInteger('model_id')->nullable()->comment('İlgili Model ID');
            $table->json('changes')->nullable()->comment('Yapılan Değişiklikler');
            $table->string('ip_address')->nullable()->comment('IP Adresi');
            $table->text('user_agent')->nullable()->comment('Tarayıcı Bilgisi');
            $table->timestamps();

            // Indexes
            $table->index(['user_id', 'created_at']);
            $table->index(['model_type', 'model_id']);
            $table->index('action');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};

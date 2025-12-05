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
        Schema::table('legal_messages', function (Blueprint $table) {
            $table->tinyInteger('rating')->nullable()->after('attachment_path')->comment('1-5 arası cevap puanı');
            $table->timestamp('rated_at')->nullable()->after('rating')->comment('Puanlama tarihi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_messages', function (Blueprint $table) {
            $table->dropColumn(['rating', 'rated_at']);
        });
    }
};

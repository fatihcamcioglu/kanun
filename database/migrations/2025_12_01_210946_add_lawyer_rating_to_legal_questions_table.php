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
        Schema::table('legal_questions', function (Blueprint $table) {
            $table->tinyInteger('lawyer_rating')->nullable()->after('answered_at')->comment('1-5 arası avukat genel puanı');
            $table->timestamp('rated_at')->nullable()->after('lawyer_rating')->comment('Genel puanlama tarihi');
            $table->timestamp('closed_at')->nullable()->after('rated_at')->comment('Kapatılma tarihi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_questions', function (Blueprint $table) {
            $table->dropColumn(['lawyer_rating', 'rated_at', 'closed_at']);
        });
    }
};

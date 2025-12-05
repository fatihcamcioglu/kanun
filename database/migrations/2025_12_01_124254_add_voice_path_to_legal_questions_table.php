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
            $table->string('voice_path')->nullable()->after('question_body');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('legal_questions', function (Blueprint $table) {
            $table->dropColumn('voice_path');
        });
    }
};

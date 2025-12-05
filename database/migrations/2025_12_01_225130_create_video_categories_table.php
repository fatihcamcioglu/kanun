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
        Schema::create('video_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Kategori Adı');
            $table->string('slug')->unique()->comment('Slug');
            $table->text('description')->nullable()->comment('Açıklama');
            $table->boolean('is_active')->default(true)->comment('Aktif mi?');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_categories');
    }
};

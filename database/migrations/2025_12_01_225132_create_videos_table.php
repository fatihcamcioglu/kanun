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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_category_id')->constrained()->onDelete('cascade')->comment('Video Kategorisi');
            $table->string('title')->comment('Başlık');
            $table->text('short_description')->nullable()->comment('Kısa Açıklama');
            $table->string('cover_image_path')->nullable()->comment('Kapak Resmi');
            $table->string('vimeo_link')->comment('Vimeo Linki');
            $table->integer('order')->default(0)->comment('Sıralama');
            $table->boolean('is_active')->default(true)->comment('Aktif mi?');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};

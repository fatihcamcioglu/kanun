@extends('customer.layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', 'Videolar')

@push('styles')
<style>
    .videos-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .category-filter {
        margin-bottom: 30px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .category-btn {
        padding: 10px 20px;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        text-decoration: none;
        color: #6b7280;
        font-weight: 500;
        transition: all 0.3s;
    }
    .category-btn:hover,
    .category-btn.active {
        border-color: #f59e0b;
        color: #f59e0b;
        background: #fffbeb;
    }
    .videos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 24px;
        margin-top: 30px;
    }
    .video-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s, box-shadow 0.3s;
        cursor: pointer;
        text-decoration: none;
        color: inherit;
        display: block;
    }
    .video-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    .video-cover {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: #f3f4f6;
    }
    .video-info {
        padding: 16px;
    }
    .video-category {
        font-size: 12px;
        color: #f59e0b;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .video-title {
        font-size: 16px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 8px;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .video-description {
        font-size: 14px;
        color: #6b7280;
        line-height: 1.5;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        margin-top: 30px;
    }
    .empty-state-icon {
        font-size: 64px;
        color: #d1d5db;
        margin-bottom: 16px;
    }
    .empty-state h3 {
        color: #6b7280;
        font-size: 20px;
        margin-bottom: 8px;
    }
    .empty-state p {
        color: #9ca3af;
        font-size: 14px;
    }
</style>
@endpush

@section('content')
<div class="videos-container">
    <div class="page-header">
        <h1>Videolar</h1>
        <p>Eğitim ve bilgilendirici videolarımızı izleyebilirsiniz.</p>
    </div>

    @if($categories->isNotEmpty())
        <div class="category-filter">
            <a href="{{ route('customer.videos.index') }}" 
               class="category-btn {{ !$selectedCategory ? 'active' : '' }}">
                Tümü
            </a>
            @foreach($categories as $category)
                <a href="{{ route('customer.videos.index', ['category' => $category->id]) }}" 
                   class="category-btn {{ $selectedCategory && $selectedCategory->id === $category->id ? 'active' : '' }}">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>

        @php
            $videosToShow = $selectedCategory ? $selectedCategory->activeVideos : collect($categories)->pluck('activeVideos')->flatten();
        @endphp

        @if($videosToShow->isNotEmpty())
            <div class="videos-grid">
                @foreach($videosToShow as $video)
                    <a href="{{ route('customer.videos.show', $video) }}" class="video-card">
                        <img src="{{ $video->cover_image_url ?? asset('images/placeholder-video.png') }}" 
                             alt="{{ $video->title }}" 
                             class="video-cover"
                             onerror="this.src='{{ asset('images/placeholder-video.png') }}'">
                        <div class="video-info">
                            <div class="video-category">{{ $video->category->name }}</div>
                            <h3 class="video-title">{{ $video->title }}</h3>
                            @if($video->short_description)
                                <p class="video-description">{{ $video->short_description }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📹</div>
                <h3>Henüz video eklenmemiş</h3>
                <p>Seçili kategoride henüz video bulunmamaktadır.</p>
            </div>
        @endif
    @else
        <div class="empty-state">
            <div class="empty-state-icon">📹</div>
            <h3>Henüz video kategorisi eklenmemiş</h3>
            <p>Yakında burada videoları bulabileceksiniz.</p>
        </div>
    @endif
</div>
@endsection


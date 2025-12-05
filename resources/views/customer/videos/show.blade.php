@extends('customer.layouts.app')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('title', $video->title)

@push('styles')
<style>
    .video-detail-container {
        max-width: 1200px;
        margin: 0 auto;
    }
    .video-player-container {
        background: #000;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 30px;
        position: relative;
        padding-bottom: 56.25%; /* 16:9 aspect ratio */
        height: 0;
    }
    .video-player-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        border: none;
    }
    .video-info-section {
        background: white;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .video-category-badge {
        display: inline-block;
        padding: 6px 12px;
        background: #fffbeb;
        color: #f59e0b;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 16px;
    }
    .video-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 16px;
    }
    .video-description {
        font-size: 16px;
        color: #4b5563;
        line-height: 1.8;
    }
    .related-videos {
        margin-top: 40px;
    }
    .related-videos h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 24px;
    }
    .related-videos-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
    }
    .related-video-card {
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
    .related-video-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }
    .related-video-cover {
        width: 100%;
        height: 140px;
        object-fit: cover;
        background: #f3f4f6;
    }
    .related-video-info {
        padding: 12px;
    }
    .related-video-title {
        font-size: 14px;
        font-weight: 600;
        color: #1f2937;
        line-height: 1.4;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .ask-question-section {
        background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
        border-radius: 12px;
        padding: 32px;
        margin-bottom: 30px;
        text-align: center;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .ask-question-section h3 {
        font-size: 20px;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 16px;
    }
    .ask-question-btn {
        display: inline-block;
        padding: 14px 32px;
        background: #f59e0b;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
        cursor: pointer;
    }
    .ask-question-btn:hover {
        background: #d97706;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);
    }
</style>
@endpush

@section('content')
<div class="video-detail-container">
    <div class="video-player-container">
        @if($video->embed_url)
            <iframe src="{{ $video->embed_url }}" 
                    allow="autoplay; fullscreen; picture-in-picture" 
                    allowfullscreen>
            </iframe>
        @else
            <div style="display: flex; align-items: center; justify-content: center; height: 100%; color: white;">
                Video yüklenemedi
            </div>
        @endif
    </div>

    <div class="video-info-section">
        <span class="video-category-badge">{{ $video->category->name }}</span>
        <h1 class="video-title">{{ $video->title }}</h1>
        @if($video->short_description)
            <div class="video-description">
                {{ $video->short_description }}
            </div>
        @endif
    </div>

    <div class="ask-question-section">
        <h3>Bu konu ile ilgili soru sormak ister misiniz?</h3>
        <a href="{{ route('customer.questions.create') }}" class="ask-question-btn">
            Soru Sor
        </a>
    </div>

    @if($relatedVideos->isNotEmpty())
        <div class="related-videos">
            <h2>İlgili Videolar</h2>
            <div class="related-videos-grid">
                @foreach($relatedVideos as $relatedVideo)
                    <a href="{{ route('customer.videos.show', $relatedVideo) }}" class="related-video-card">
                        <img src="{{ $relatedVideo->cover_image_url ?? asset('images/placeholder-video.png') }}" 
                             alt="{{ $relatedVideo->title }}" 
                             class="related-video-cover"
                             onerror="this.src='{{ asset('images/placeholder-video.png') }}'">
                        <div class="related-video-info">
                            <h3 class="related-video-title">{{ $relatedVideo->title }}</h3>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection


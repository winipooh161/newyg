@foreach ($reels as $reel)
    <div class="video-card">
        <div class="video-container">
            <video playsinline muted loop poster="{{ $reel->thumbnail_url ?? '' }}">
                <source src="{{ asset('videos/reels/' . $reel->video_file) }}" type="video/mp4">
                Ваш браузер не поддерживает видео.
            </video>
            <div class="video-overlay">
                <button class="play-btn" data-id="{{ $reel->id }}">
                    <i class="fas fa-play"></i>
                </button>
            </div>
        </div>
        <div class="video-info">
            <h3>{{ $reel->title }}</h3>
            <p>{{ Str::limit($reel->description, 100) }}</p>
        </div>
    </div>
@endforeach

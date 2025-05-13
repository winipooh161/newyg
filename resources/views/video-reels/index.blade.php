<section class="video-reels">
    <div class="container">
        <div class="title">
            <h2  class=" wow fadeInDown" data-wow-duration="1.2s" data-wow-delay="1.2s">       вИДЕО  <span class="color-text">Рилсы </span><br>
              
        
            </h2>
        </div>
        <div class="video-grid" id="video-grid">
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
        </div>
        
        @if($reels->hasMorePages())
            <div class="load-more-container">
                <button id="load-more" class="load-more-btn" data-page="{{ $reels->currentPage() }}">Загрузить еще</button>
            </div>
        @endif
    </div>
</section>

<div class="video-modal" id="video-modal">
    <div class="video-modal-content">
        <span class="close-modal">&times;</span>
        <video id="modal-video" controls playsinline></video>
        <h3 id="modal-title"></h3>
        <p id="modal-description"></p>
    </div>
</div>

<style>

</style>

@section('scripts')
<script>
    $(document).ready(function() {
        // Play video in modal when play button is clicked
        $('.play-btn').on('click', function() {
            const videoId = $(this).data('id');
            const videoCard = $(this).closest('.video-card');
            const videoSrc = videoCard.find('video source').attr('src');
            const videoTitle = videoCard.find('.video-info h3').text();
            const videoDesc = videoCard.find('.video-info p').text();
            
            $('#modal-video').attr('src', videoSrc);
            $('#modal-title').text(videoTitle);
            $('#modal-description').text(videoDesc);
            
            $('#video-modal').fadeIn();
            $('#modal-video')[0].play();
        });
        
        // Close modal
        $('.close-modal').on('click', function() {
            $('#modal-video')[0].pause();
            $('#modal-video').attr('src', '');
            $('#video-modal').fadeOut();
        });
        
        // Close modal when clicking outside
        $(window).on('click', function(event) {
            if ($(event.target).is('#video-modal')) {
                $('#modal-video')[0].pause();
                $('#modal-video').attr('src', '');
                $('#video-modal').fadeOut();
            }
        });
        
        // Auto-preview videos on hover
        $('.video-card').hover(
            function() {
                $(this).find('video')[0].play();
            },
            function() {
                const video = $(this).find('video')[0];
                video.pause();
                video.currentTime = 0;
            }
        );
        
        // Load more videos
        $('#load-more').on('click', function() {
            const btn = $(this);
            const page = parseInt(btn.data('page')) + 1;
            btn.text('Загрузка...');
            btn.prop('disabled', true);
            
            $.ajax({
                url: '{{ route("video-reels") }}',
                type: 'GET',
                data: {
                    page: page,
                    ajax: 1
                },
                success: function(response) {
                    if (response.html) {
                        $('#video-grid').append(response.html);
                        btn.data('page', page);
                        btn.text('Загрузить еще');
                        btn.prop('disabled', false);
                        
                        // If no more pages, hide the button
                        if (!response.hasMorePages) {
                            btn.parent().remove();
                        }
                        
                        // Reinitialize event handlers for new videos
                        initVideoHandlers();
                    }
                },
                error: function() {
                    btn.text('Ошибка загрузки. Попробуйте еще раз');
                    btn.prop('disabled', false);
                }
            });
        });
        
        function initVideoHandlers() {
            // Play video in modal
            $('.play-btn').off('click').on('click', function() {
                const videoId = $(this).data('id');
                const videoCard = $(this).closest('.video-card');
                const videoSrc = videoCard.find('video source').attr('src');
                const videoTitle = videoCard.find('.video-info h3').text();
                const videoDesc = videoCard.find('.video-info p').text();
                
                $('#modal-video').attr('src', videoSrc);
                $('#modal-title').text(videoTitle);
                $('#modal-description').text(videoDesc);
                
                $('#video-modal').fadeIn();
                $('#modal-video')[0].play();
            });
            
            // Auto-preview videos on hover
            $('.video-card').off('mouseenter mouseleave').hover(
                function() {
                    $(this).find('video')[0].play();
                },
                function() {
                    const video = $(this).find('video')[0];
                    video.pause();
                    video.currentTime = 0;
                }
            );
        }
    });
</script>
@endsection

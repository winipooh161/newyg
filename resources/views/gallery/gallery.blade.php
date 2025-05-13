<section class="gallery" id="gallery">
    <div class="title">
        <h2 class="wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s"> ГАЛЕРЕЯ <span class="color-text">НАШИХ</span> РАБОТ </h2>
        <p class="wow fadeInDown" data-wow-duration="1.2s" data-wow-delay="1.2s"> Посмотрите примеры реализованных нами проектов и <strong>убедитесь в качестве</strong> выполненных работ</p>
          <!-- Tab navigation -->
    <div class="gallery-tabs wow fadeInDown" data-wow-duration="0.8s" data-wow-delay="0.8s">
        <button class="gallery-tab active" data-tab="photos">Фотографии</button>
        <button class="gallery-tab" data-tab="videos">Видео проектов</button>
    </div>
    </div>
    
  
    
    <!-- Photos tab content -->
    <div class="gallery-tab-content active" id="photos-content">
        @if(isset($projectImages) && count($projectImages) > 0)
            @php
                // Сортируем проекты по убыванию ключей (идентификаторов)
                $projectImages = collect($projectImages)->sortKeysDesc()->toArray();
            @endphp
            @foreach($projectImages as $projectId => $images)
                @php
                    // Ограничиваем количество фотографий до 10
                    $limitedImages = array_slice($images, 0, 10);
                @endphp
                <div class="gallery__slider wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                    <!-- Добавляем название проекта, если оно есть и нужно показывать заголовки -->
                    @if(isset($allProjects[$projectId]) && (!isset($showProjectTitles) || $showProjectTitles))
                        <div class="gallery-project-title">
                            <h3>{{ $allProjects[$projectId]->title }}</h3>
                            @if(count($images) > 10)
                                <span class="gallery-more-info">(показано 10 из {{ count($images) }} фото)</span>
                            @endif
                        </div>
                    @endif
                    
                    <swiper-container class="gallery-swiper-{{ $loop->index + 1 }} @if($loop->index % 2 == 1) reverse @endif"
                        slides-per-view="3" slides-per-group="1"
                        space-between="30" grid-rows="1" grid-fill="row"
                        autoplay-delay="{{ 3000 + ($loop->index * 1000) }}" autoplay="true"
                        breakpoints='{"320": {"slidesPerView": 1}, "640": {"slidesPerView": 2}, "1024": {"slidesPerView": 3}}'>
                        @foreach($limitedImages as $i => $img)
                        <swiper-slide>
                            <div class="gallery-item">
                                @if(isset($allProjects[$projectId]))
                                    <a href="{{ route('projects.show', $projectId) }}">
                                        <img src="{{ asset($img) }}" alt="Фото работы {{ $allProjects[$projectId]->title }}" onload="this.classList.add('loaded')">
                                    </a>
                                @else
                                    <img src="{{ asset($img) }}" alt="Фото работы" onload="this.classList.add('loaded')" onclick="openModal('{{ $projectId }}', {{ $i }})">
                                @endif
                            </div>
                        </swiper-slide>
                        @endforeach
                    </swiper-container>
                </div>
            @endforeach
        @else
            <!-- Используем старую структуру, если новой нет -->
            @foreach($chunkedImages as $chunkIndex => $slider)
                @php
                    // Ограничиваем количество фотографий до 10
                    $limitedSlider = array_slice($slider, 0, 10);
                @endphp
                <div class="gallery__slider wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                    <swiper-container class="gallery-swiper-{{ $chunkIndex + 1 }} @if($chunkIndex % 2 == 1) reverse @endif"
                        slides-per-view="3" slides-per-group="1"
                        space-between="30" grid-rows="1" grid-fill="row"
                        autoplay-delay="{{ 3000 + ($chunkIndex * 1000) }}" autoplay="true"
                        breakpoints='{"320": {"slidesPerView": 1}, "640": {"slidesPerView": 2}, "1024": {"slidesPerView": 3}}'>
                        @foreach($limitedSlider as $i => $img)
                        <swiper-slide>
                            <div class="gallery-item">
                                <img src="{{ asset($img) }}" alt="Фото работы" onload="this.classList.add('loaded')" onclick="openModal({{ $chunkIndex }}, {{ $i }})">
                            </div>
                        </swiper-slide>
                        @endforeach
                    </swiper-container>
                </div>
            @endforeach
        @endif
    </div>
    
    <!-- Videos tab content -->
    <div class="gallery-tab-content" id="videos-content">
        @php
            // Получаем проекты с видео
            $projectsWithVideo = isset($allProjects) ? $allProjects->filter(function($project) {
                return $project->hasVideo();
            }) : collect();
        @endphp
        
        @if($projectsWithVideo->count() > 0)
            <div class="gallery__slider video-slider wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                <swiper-container class="video-swiper"
                    slides-per-view="1" slides-per-group="1"
                    space-between="30" grid-rows="1" grid-fill="row"
                    pagination="true" navigation="true"
                    breakpoints='{"768": {"slidesPerView": 1}, "1024": {"slidesPerView": 1}}'>
                    @foreach($projectsWithVideo as $project)
                    <swiper-slide>
                        <div class="video-item">
                            <div class="video-title">
                                <h3>{{ $project->title }}</h3>
                            </div>
                            <div class="video-container">
                                <video controls poster="{{ asset($project->image) }}">
                                    <source src="{{ $project->getVideoUrl() }}" type="video/mp4">
                                    Ваш браузер не поддерживает видео.
                                </video>
                            </div>
                            <div class="video-info">
                                <p>{{ Str::limit($project->description, 150) }}</p>
                                <a href="{{ route('projects.show', $project->id) }}" class="video-link">Подробнее о проекте</a>
                            </div>
                        </div>
                    </swiper-slide>
                    @endforeach
                </swiper-container>
            </div>
        @else
            <div class="no-videos">
                <p>Видео проектов пока не добавлены</p>
            </div>
        @endif
    </div>
</section>

<!-- Модальное окно для проектов без привязки к базе данных -->
<div id="imageModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <swiper-container id="modalSwiper" slides-per-view="1" space-between="30" style="width:100%; height:100%;">
            <!-- Слайды будут заполнены динамически -->
        </swiper-container>
    </div>
</div>

<style>
    /* Стили для табов */
    .gallery-tabs {
        display: flex;
        justify-content: center;
        margin-top: 30px;
        gap: 20px;
    }
    
    .gallery-tab {
        padding: 12px 25px;
        background-color: #f5f5f5;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }
    
    .gallery-tab:hover {
        background-color: #e5e5e5;
    }
    
    .gallery-tab.active {
        background-color: #29235c;
        color: white;
    }
    
    /* Стили для контента табов */
    .gallery-tab-content {
        display: none;
    }
    
    .gallery-tab-content.active {
        display: block;
    }
    
    /* Стили для видео */
    .video-slider {
        margin: 0 auto;
        max-width: 900px;
    }
    
    .video-item {
        padding: 15px;
     margin: none;
        border-radius: 8px;

    }
    
    .video-title {
        margin-bottom: 15px;
        text-align: center;
    }
    
    .video-container {
        width: 100%;
        position: relative;
        padding-top: 56.25%; /* 16:9 соотношение */
        margin-bottom: 15px;
    }
    
    .video-container video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 5px;
    }
    
    .video-info {
        padding: 15px 0;
        text-align: center;
    }
    
    .video-link {
        display: inline-block;
        margin-top: 10px;
        padding: 8px 20px;
        background-color: #29235c;
        color: white;
        border-radius: 30px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .video-link:hover {
        background-color: #1a1645;
        transform: translateY(-2px);
    }
    
    .gallery-more-info {
        font-size: 14px;
        color: #666;
        margin-left: 10px;
    }
    
    .no-videos {
        text-align: center;
        padding: 50px 0;
        font-size: 18px;
        color: #666;
    }
    
    /* Адаптивность */
    @media (max-width: 768px) {
        .gallery-tabs {
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .gallery-tab {
            padding: 10px 20px;
            font-size: 14px;
            flex: 1;
            min-width: 120px;
            text-align: center;
        }
    }
</style>

<script>
// Глобальная переменная для хранения изображений проектов
var projectImages = @json(isset($projectImages) ? $projectImages : (isset($chunkedImages) ? $chunkedImages : []));

// Функция открытия модального окна с слайдером
function openModal(projectId, slideIndex) {
    var images = projectImages[projectId];
    var modalSwiper = document.getElementById('modalSwiper');
    var slidesHtml = '';
    
    images.forEach(function(img) {
        slidesHtml += '<swiper-slide><img src="'+img+'" alt="Модальное изображение" style=""></swiper-slide>';
    });
    
    modalSwiper.innerHTML = slidesHtml;
    document.getElementById('imageModal').style.display = 'flex';
    
    // Дождаться апгрейда элемента и перейти к нужному слайду
    setTimeout(function(){
        if(modalSwiper.swiper) {
            modalSwiper.swiper.slideTo(slideIndex, 0);
        }
    }, 100);
}

// Функция закрытия модального окна
function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
    document.getElementById('modalSwiper').innerHTML = ''; // очистка слайдов
}

// Закрытие модального окна по клику вне его содержимого
document.getElementById('imageModal').addEventListener('click', function(e) {
    if(e.target.id === 'imageModal'){
        closeModal();
    }
});

// Функциональность переключения табов
document.addEventListener('DOMContentLoaded', function() {
    var tabs = document.querySelectorAll('.gallery-tab');
    
    tabs.forEach(function(tab) {
        tab.addEventListener('click', function() {
            // Удаляем активный класс у всех табов и контента
            document.querySelectorAll('.gallery-tab').forEach(function(t) {
                t.classList.remove('active');
            });
            
            document.querySelectorAll('.gallery-tab-content').forEach(function(content) {
                content.classList.remove('active');
            });
            
            // Добавляем активный класс к выбранному табу
            this.classList.add('active');
            
            // Показываем соответствующий контент
            var tabId = this.getAttribute('data-tab');
            document.getElementById(tabId + '-content').classList.add('active');
            
            // Остановка автоматического воспроизведения видео при переключении табов
            if(tabId === 'photos') {
                document.querySelectorAll('#videos-content video').forEach(function(video) {
                    video.pause();
                });
            }
        });
    });
    
    // Автоматическая остановка видео при закрытии модального окна
    document.querySelectorAll('.modal video').forEach(function(video) {
        video.addEventListener('ended', function() {
            this.currentTime = 0; // Сбрасываем на начало для повторного просмотра
        });
    });
});
</script>

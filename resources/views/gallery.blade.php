@extends('layouts.app')

@section('content')
    @include('layouts/header')
    
    <section class="gallery-hero">
        <div class="container">
            <div class="title">
                <h1 class="wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                    Галерея <span class="color-text">наших проектов</span>
                </h1>
                <p class="wow fadeInDown" data-wow-duration="0.8s" data-wow-delay="0.8s">
                    Фотографии реализованных проектов по ремонту и дизайну интерьеров
                </p>
            </div>
        </div>
    </section>

    <section class="gallery-content">
        <div class="container">
            <div class="gallery-projects">
                @if(!empty($projectImages))
                    @foreach($projectImages as $projectId => $images)
                        <div class="gallery-project wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
                            @if($showProjectTitles && isset($allProjects[$projectId]))
                                <h3 class="project-title">{{ $allProjects[$projectId]->title }}</h3>
                                <p class="project-details">
                                    <span>Площадь: {{ $allProjects[$projectId]->area }}</span>
                                    <span>Срок: {{ $allProjects[$projectId]->time }}</span>
                                </p>
                            @endif

                            <div class="gallery-images">
                                @foreach($images as $image)
                                    <div class="gallery-image-item">
                                        <a href="{{ asset($image) }}" data-fancybox="gallery-{{ $projectId }}" data-caption="{{ isset($allProjects[$projectId]) ? $allProjects[$projectId]->title : 'Фотография проекта' }}">
                                            <img src="{{ asset($image) }}" alt="{{ isset($allProjects[$projectId]) ? $allProjects[$projectId]->title : 'Фото проекта' }}" loading="lazy">
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                            
                            @if(isset($allProjects[$projectId]))
                                <div class="project-link">
                                    <a href="{{ route('projects.show', $projectId) }}" class="btn btn-outline">Подробнее о проекте</a>
                                </div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="no-projects">
                        <p>Проекты скоро будут добавлены</p>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Секция CTA -->
    <section class="gallery-cta">
        <div class="container">
            <div class="cta-content wow fadeInUp" data-wow-duration="0.8s">
                <h2>Хотите такой же <span class="color-text">стильный интерьер?</span></h2>
                <p>Закажите консультацию дизайнера и получите индивидуальный проект</p>
                <div class="cta-buttons">
                    <button class="blick" onclick="openQuizModal()">Рассчитать стоимость ремонта</button>
                    <a href="{{ route('projects.index') }}" class="secondary-btn">Смотреть все проекты</a>
                </div>
            </div>
        </div>
    </section>

    @include('form/form-three')
    @include('layouts/quiz')
    @include('layouts/footer')
@endsection

@section('scripts')
<!-- FancyBox для просмотра изображений -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css"/>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Инициализация FancyBox
        Fancybox.bind("[data-fancybox]", {
            // Настройки FancyBox
            caption: function (fancybox, carousel, slide) {
                return slide.caption || '';
            },
            Thumbs: {
                showOnStart: false
            }
        });

        // Добавление микроразметки для фото при загрузке страницы
        const galleryImages = document.querySelectorAll('.gallery-image-item img');
        
        // Создаем наблюдателя для LazyLoad изображений
        const observer = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                    }
                    observer.unobserve(img);
                }
            });
        }, {threshold: 0.1});

        // Добавляем наблюдателя ко всем изображениям галереи
        galleryImages.forEach(img => observer.observe(img));
    });
</script>

<style>
    /* Стили для галереи */
    .gallery-hero {
        background-color: #f8f9fa;
        padding: 80px 0 40px;
        text-align: center;
    }
    
    .gallery-hero h1 {
        font-size: 42px;
        margin-bottom: 20px;
    }
    
    .gallery-hero p {
        font-size: 18px;
        max-width: 700px;
        margin: 0 auto;
        color: #666;
    }
    
    .gallery-content {
        padding: 60px 0;
    }
    
    .gallery-project {
        margin-bottom: 50px;
        padding-bottom: 40px;
        border-bottom: 1px solid #eee;
    }
    
    .project-title {
        font-size: 24px;
        margin-bottom: 10px;
        color: #333;
    }
    
    .project-details {
        display: flex;
        gap: 20px;
        margin-bottom: 20px;
        font-size: 16px;
        color: #666;
    }
    
    .gallery-images {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }
    
    .gallery-image-item {
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    
    .gallery-image-item:hover {
        transform: translateY(-5px);
    }
    
    .gallery-image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        aspect-ratio: 4/3;
    }
    
    .project-link {
        text-align: center;
        margin-top: 20px;
    }
    
    .gallery-cta {
        background-color: #f8f9fa;
        padding: 60px 0;
        text-align: center;
        margin-bottom: 40px;
    }
    
    .cta-content h2 {
        font-size: 32px;
        margin-bottom: 20px;
    }
    
    .cta-content p {
        font-size: 18px;
        margin-bottom: 30px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }
    
    .cta-buttons {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
    }
    
    .secondary-btn {
        display: inline-block;
        padding: 12px 24px;
        background-color: transparent;
        border: 2px solid #007bff;
        color: #007bff;
        border-radius: 4px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .secondary-btn:hover {
        background-color: #007bff;
        color: white;
    }
    
    /* Адаптивность */
    @media (max-width: 768px) {
        .gallery-hero h1 {
            font-size: 32px;
        }
        
        .gallery-images {
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        }
        
        .cta-buttons {
            flex-direction: column;
            align-items: center;
        }
        
        .cta-buttons button,
        .cta-buttons a {
            width: 100%;
            max-width: 300px;
        }
    }
</style>
@endsection

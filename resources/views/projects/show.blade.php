@extends('layouts.app')
@section('content')
    @include('layouts/header')
    
    <section class="project-detail" id="project-detail">
        <div class="container">
            <div class="project-header">
                <div class="project-header__title">
                    <div class="section-body-page__info wow fadeInLeft blick" data-wow-duration="2s" data-wow-delay="2s">
                        <p>Лучший стиль сезона</p>
                    </div>
                    <h1 class="wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                        {{ $project->title }}
                    </h1>
                    <div class="description-content wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                        {!! nl2br(e($project->description)) !!}
                    </div>
                    {{-- <div class="project-meta wow fadeInDown" data-wow-duration="0.8s" data-wow-delay="0.8s">
                        <div class="project-meta-item">
                            <span>Площадь</span>
                            <strong>{{ $project->area }}</strong>
                        </div>
                        <div class="project-meta-item">
                            <span>Сроки</span>
                            <strong>{{ $project->time }}</strong>
                        </div>
                        @if($project->price)
                        <div class="project-meta-item">
                            <span>Стоимость работы</span>
                            <strong>{{ $project->price }} руб</strong>
                        </div>
                        @endif
                    </div> --}}
                    <div class="section-body-page__buttons wow fadeInLeft" data-wow-duration="1.2s" data-wow-delay="1.2s">
                        <button class="case_button"> <img src="{{ asset('img/icon/radio.svg') }}" alt=""> Еще  кейсы</button>
                        <button class="blick" onclick="openQuizModal()">Хочу тоже! <img src="{{ asset('img/icon/comment.svg ') }}"
                                alt=""></button>
                    </div>
                   
                </div>
                  
            <div class="project-main-image wow fadeInDown" data-wow-duration="1s" data-wow-delay="1s">
                <img src="{{ asset($project->image) }}" alt="{{ $project->title }}">
            </div>
            
            </div>
         
            <!-- Добавляем блок для отображения видео проекта -->
            @if($project->hasVideo())
            <div class="project-video wow fadeInDown" data-wow-duration="1.2s" data-wow-delay="1.2s">
                <h2>Видео стиля</h2>
                <div class="video-container-project">
                    <video width="100%" controls>
                        <source src="{{ $project->getVideoUrl() }}" type="video/mp4">
                        Ваш браузер не поддерживает видео.
                    </video>
                </div>
            </div>
            @endif
            
            @if(count($galleryImages) > 0)
            <div class="project-gallery wow fadeInDown" data-wow-duration="1.4s" data-wow-delay="1.4s">
                <h2>Галерея стиля</h2>
                
                <div class="project-gallery-slider">
                    <swiper-container class="projectGallerySwiper" 
                        pagination="true" 
                        slides-per-view="3" 
                        slides-per-group="1"
                        space-between="30" 
                        grid-rows="3" 
                        grid-fill="row"
                        breakpoints='{
                            "0": {
                                "slidesPerView": 1,
                                "slidesPerGroup": 1,
                                "grid": {"rows": 1}
                            },
                            "768": {
                                "slidesPerView": 2,
                                "slidesPerGroup": 2,
                                "grid": {"rows": 2}
                            },
                            "992": {
                                "slidesPerView": 3,
                                "slidesPerGroup": 3,
                                "grid": {"rows": 3}
                            }
                        }'>
                        @foreach($galleryImages as $image)
                        <swiper-slide>
                            <div class="gallery-slide">
                                <img src="{{ asset($image) }}" alt="{{ $project->title }} - фото {{ $loop->iteration }}" 
                                     onclick="openImageModal('{{ asset($image) }}')">
                            </div>
                        </swiper-slide>
                        @endforeach
                    </swiper-container>
                </div>
            </div>
            @endif
            
            <div class="section-body-page__buttons section-body-page__buttons-bottom wow fadeInDown" data-wow-duration="1.6s" data-wow-delay="1.6s">
                <a href="{{ route('projects.index') }}" class="back-button">
                    <i class="fas fa-arrow-left"></i> Вернуться к проектам
                </a>
                <button class="blick" onclick="openQuizModal()">Получить консультацию</button>
            </div>
        </div>
    </section>
 
    @include('layouts/quiz')
    @include('layouts/footer')
@endsection

@section('styles')
<style>
    /* Стили для видео-контейнера */
    .project-video {
        margin-bottom: 40px;
    }
    
    .project-video h2 {
        margin-bottom: 20px;
        font-size: 24px;
    }
    
    .video-container {
        position: relative;
        width: 100%;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    
    .video-container video {
        display: block;
        width: 100%;
        height: auto;
    }
    
    /* Адаптивность для мобильных устройств */
    @media (max-width: 768px) {
        .project-video h2 {
            font-size: 20px;
        }
    }
</style>
@endsection

@extends('layouts.app')
@section('content')
    @include('layouts/header')
    
    <section class="projects" id="projects">
        <div class="container">
            <div class="title">
                <h2 class="wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                    Только за 2024 год сделали ремонт <br> 100+ объектах по всей<span class="color-text"> Ростовской области </span>
                </h2>
                <p class="wow fadeInDown" data-wow-duration="1.2s" data-wow-delay="1.2s">
                    <strong>Профессиональный</strong> ремонт с многоступенчатым <strong>контролем качества,</strong> <br>
                    опытными специалистами и <strong>выгодными ценами</strong> без посредников
                </p>
            </div>
            
            <div class="projects-grid">
                @foreach($projects as $project)
                <a href="{{ route('projects.show', $project->id) }}" class="project-card-link">
                    <div class="section-body_infocards__card wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="{{ 0.2 * $loop->iteration }}s">
                        <div class="section-body_infocards__card-img">
                            <img src="{{ asset($project->image) }}" alt="{{ $project->title }}">
                        </div>
                        <div class="section-body_infocards__card-info">
                            <h4>{{ $project->title }}</h4>
                            <ul class="section-body_infocards__card-info__swiper">
                                <li>
                                    <p>Площадь</p>
                                    <h3>{{ $project->area }}</h3>
                                </li>
                                <li>
                                    <p>Сроки</p>
                                    <h3>{{ $project->time }}</h3>
                                </li>
                            </ul>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    
    @include('layouts/footer')
@endsection

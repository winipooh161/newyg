{{-- <section class="cards" id="cards">
    <div class="container">
        <div class="title">
            <h2 class=" wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s"> Только за 2024 год <span class="color-text">выполнили ремонт</span> <br> более чем на 100 объектах</h2>
            <p  class=" wow fadeInDown" data-wow-duration="1.2s" data-wow-delay="1.2s"><strong>Профессиональный</strong> ремонт с многоступенчатым <strong>контролем качества,</strong> <br>
                опытными специалистами и <strong>выгодными ценами</strong> без посредников </p>
        </div>
        <div class="cards__slider  wow fadeInDown" data-wow-duration="1.4s" data-wow-delay="1.4s">
            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" breakpoints='{"640":{"slidesPerView":1},"768":{"slidesPerView":2},"1024":{"slidesPerView":3},"1368":{"slidesPerView":4}}' space-between="20" centered-slides="true">
                @if(isset($projects) && count($projects) > 0)
                    @php
                        // Сортируем проекты по убыванию идентификаторов
                        $projects = $projects->sortByDesc('id');
                    @endphp
                    @foreach($projects as $project)
                    <swiper-slide>
                        <a href="{{ route('projects.show', $project->id) }}" class="project-card-link">
                            <div class="section-body_infocards__card">
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
                    </swiper-slide>
                    @endforeach
                @else
                 
                @endif
            </swiper-container>
            <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
            <div class="cards__form__swiper wow fadeInDown" data-wow-duration="1.5s" data-wow-delay="1.5">
                <p>Смотреть остальные проекты <br> прямо сейчас</p>
                <div class="section-body-page__buttons">
                    <a href="{{ route('projects.index') }}" class="blick">Смотреть проекты </a>
                </div>
            </div>
        </div>
    </div>
</section> --}}

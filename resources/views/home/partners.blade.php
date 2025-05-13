<section class="partners" id="partners">
    <div class="container">
        <div class="partners__header">
            <h2 class="section-title wow fadeIn">Наши партнёры</h2>
            <p class="section-description wow fadeIn" data-wow-delay="0.2s">Компании, которые доверяют нам и с которыми мы сотрудничаем</p>
        </div>
        
        <div class="partners-slider-container wow fadeIn" data-wow-delay="0.3s">
            <div class="swiper partners-slider">
                <div class="swiper-wrapper">
                    <!-- Partner logo items -->
                    <div class="swiper-slide">
                        <div class="partner-logo">
                            <img src="{{ asset('img/colaboration/logoAnastasia.svg') }}" alt="Партнер 1">
                        </div>
                    </div>
                    {{-- <div class="swiper-slide">
                        <div class="partner-logo">
                            <img src="{{ asset('img/colaboration/logoUsi.svg') }}" alt="Партнер 2">
                        </div>
                    </div> --}}
                    <div class="swiper-slide">
                        <div class="partner-logo">
                            <img src="{{ asset('img/colaboration/logoYgStroy.svg') }}" alt="Партнер 3">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="partner-logo">
                            <img src="{{ asset('img/colaboration/logoAnastasia.svg') }}" alt="Партнер 4">
                        </div>
                    </div>
                    {{-- <div class="swiper-slide">
                        <div class="partner-logo">
                            <img src="{{ asset('img/colaboration/logoUsi.svg') }}" alt="Партнер 5">
                        </div>
                    </div> --}}
                    <div class="swiper-slide">
                        <div class="partner-logo">
                            <img src="{{ asset('img/colaboration/logoYgStroy.svg') }}" alt="Партнер 6">
                        </div>
                    </div>
                </div>
             
            </div>
        </div>
    </div>

    <!-- Микроразметка для партнеров -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "ЮГСТИЛЬ",
        "url": "{{ url('/') }}",
        "logo": "{{ asset('img/icon/logo.svg') }}",
        "partner": [
            {
                "@type": "Organization",
                "name": "Анастасия",
                "logo": "{{ asset('img/colaboration/logoAnastasia.svg') }}"
            },
            {
                "@type": "Organization",
                "name": "USI",
                "logo": "{{ asset('img/colaboration/logoUsi.svg') }}"
            },
            {
                "@type": "Organization",
                "name": "ЮГ СТРОЙ",
                "logo": "{{ asset('img/colaboration/logoYgStroy.svg') }}"
            }
        ]
    }
    </script>

    <style>
        .partners {
            padding: 80px 0;
            background-color: #fff;
        }
        
        .partners__header {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .partners-slider-container {
            position: relative;
            padding: 0 40px;
        }
        
        .partners-slider {
            width: 100%;
            height: 100%;
        }
        
        .partner-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100px;
            padding: 15px;
            background: #fff;
            border-radius: 8px;
            transition: transform 0.3s ease;
        }
        
        .partner-logo:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .partner-logo img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        .partners-button-prev,
        .partners-button-next {
            color: #333;
        }
        
        .partners-pagination {
            margin-top: 20px;
        }
        
        @media (max-width: 768px) {
            .partners {
                padding: 50px 0;
            }
            
            .partners-slider-container {
                padding: 0 25px;
            }
            
            .partner-logo {
                height: 80px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const partnersSwiper = new Swiper('.partners-slider', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: {
                    delay: 3000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true
                },
         
                breakpoints: {
                    // When window width is >= 576px
                    576: {
                        slidesPerView: 3,
                        spaceBetween: 20
                    },
                    // When window width is >= 768px
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 30
                    },
                    // When window width is >= 1024px
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 30
                    }
                }
            });
        });
    </script>
</section>

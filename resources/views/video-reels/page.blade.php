<section class="page" id="page">
    <div class="container">
        <div class="section-body">
            <div class="section-body-page">
                <div class="section-body-page__info wow fadeInLeft blick" data-wow-duration="2s" data-wow-delay="2s">
                    <p>По 02.02.2025 скидка на все 5%</p>
                </div>
                <div class="section-body-page__title wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.5s">
                    <h1>Сборка наших видео-рилсов специально для вас!</h1>
                    <p>Несем финансовую ответственность за качество работ, материалов и сроки ремонта </p>
                </div>
                <div class="section-body-page__buttons wow fadeInLeft" data-wow-duration="1.2s" data-wow-delay="1.2s">
                    <button class="case_button"> <img src="{{ asset('img/icon/radio.svg') }}" alt=""> Наши кейсы</button>
                    <button class="blick" onclick="openQuizModal()">Записаться сейчас <img src="{{ asset('img/icon/comment.svg ') }}"
                            alt=""></button>
                </div>
                <div class="section-body-page__p wow fadeInLeft" data-wow-duration="1.3s" data-wow-delay="1.3s">
                    <p><strong>Рассчитайте стоимость прямо на сайте</strong> и бесплатно <br> получите детальную смету
                    </p>
                </div>
            </div>
           
        </div> 
    </div>
</section>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Define background images array
        const backgroundImages = [
            "/img/page/page_fon.webp",
            "/img/page/page_fon2.webp",
            "/img/page/page_fon3.webp",
            "/img/page/page_fon4.webp",
            "/img/page/page_fon5.webp",
            // Add more background images as needed
        ];
        
        let currentIndex = 0;
        const sectionBody = document.querySelector('.page .section-body');
        
        // Apply loaded class after a small delay for animation effect
        setTimeout(function() {
            if (sectionBody) {
                sectionBody.classList.add('loaded');
            }
        }, 300);
        
        // Change background every 3 seconds
        setInterval(function() {
            currentIndex = (currentIndex + 1) % backgroundImages.length;
            if (sectionBody) {
                sectionBody.style.backgroundImage = `url('${backgroundImages[currentIndex]}')`;
            }
        }, 6000);
    });
</script>



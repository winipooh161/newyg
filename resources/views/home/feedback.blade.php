<section class="feedback" id="feedback">
    <div class="container">
        <div class="title">
            <h2 class="wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                <span class="color-text">Более 267 клиентов оценили</span> <br>
                качество нашего ремонта
            </h2>
            <p class="wow fadeInDown" data-wow-duration="1.2s" data-wow-delay="1.2s">
                Почитайте реальные отзывы некоторых из них:
            </p>
        </div>
        <div class="cards__slider wow fadeInDown" data-wow-duration="2s" data-wow-delay="2s">
            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" space-between="20" centered-slides="true"
                slides-per-view="1"
                breakpoints='{"640": {"slidesPerView": 1}, "768": {"slidesPerView": 2}, "1024": {"slidesPerView": 3}}'>
                @foreach($feedbacks as $feedback)
                    @if($feedback->approved)
                    <swiper-slide>
                        <div class="section-body_feedback__card">
                            <div class="section-body_feedback__card__person">
                                <!-- Можно добавить аватар по желанию -->
                                <div class="section-body_feedback__card-info">
                                    <h4 class="color-text">{{ $feedback->name }}</h4>
                                </div>
                            </div>
                            <p>{{ $feedback->comment }}</p>
                        </div>
                    </swiper-slide>
                    @endif
                @endforeach
            </swiper-container>
            <div class="cards__form__swiper wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">
                <p>Оставить отзыв <br> прямо сейчас</p>
                <div class="section-body-page__buttons">
                    <button class="blick" onclick="openFeedbackModal()">Оставить отзыв <img src="{{ asset('img/icon/eye.svg') }}" alt=""></button>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Модальное окно для отправки отзыва --}}
<div id="feedbackModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeFeedbackModal()">&times;</span>
      <form action="{{ route('feedback.store') }}" method="POST">
            @csrf
            <h3>Оставить отзыв</h3>
            <input type="text" name="name" placeholder="Ваше имя" required>
            <input type="email" name="email" placeholder="Ваш email" required>
            <textarea name="comment" placeholder="Ваш отзыв" required maxlength="300"></textarea>
            <button type="submit">Отправить отзыв</button>
        </form>
    </div>
</div>


<script>
// Открытие модального окна для отзыва
function openFeedbackModal() {
    document.getElementById('feedbackModal').style.display = 'flex';
}

// Закрытие модального окна для отзыва
function closeFeedbackModal() {
    document.getElementById('feedbackModal').style.display = 'none';
}

// Закрытие модального окна кликом вне содержимого
document.getElementById('feedbackModal').addEventListener('click', function(e) {
    if (e.target.id === 'feedbackModal') {
        closeFeedbackModal();
    }
});
</script>

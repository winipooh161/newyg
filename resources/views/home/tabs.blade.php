<section class="tabs" id="tabs">
    <div class="container">
        <div class="title">
            <h2  class=" wow fadeInDown" data-wow-duration="0.5s" data-wow-delay="0.5s">Для начала нужна лишь ваша идея <br>
                — мы возьмем <span class="color-text">на себя всю работу «под ключ».</span> </h2>
        </div>
    </div>
    <div class="container">
        <div class="tabs-blocks-pop">
            <div class="tabs__blocks-ul">
                <ul>
                    <li  class=" wow fadeInLeft" data-wow-duration="0.8s" data-wow-delay="0.8s">
                        <button class="blick" >
                            <p>Этап 1</p>
                            <span>Бесплатный выезд прораба</span>
                        </button>
                    </li>
                    <li  class=" wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.5s">
                        <button class="blick" >
                            <p>Этап 2</p>
                            <span>Разработка
                                дизайн-проекта</span>
                        </button>
                    </li>
                    <li  class=" wow fadeInLeft" data-wow-duration="1.2s" data-wow-delay="1.2s">
                        <button class="blick" >
                            <p>Этап 3</p>
                            <span>Закупка материала</span>
                        </button>
                    </li>
                    <li  class=" wow fadeInLeft" data-wow-duration="1.4s" data-wow-delay="1.4s">
                        <button class="blick" >
                            <p>Этап 4</p>
                            <span>Ремонт с фото-отчетом</span>
                        </button>
                    </li>
                    <li  class=" wow fadeInLeft" data-wow-duration="1.6s" data-wow-delay="1.6s">
                        <button class="blick" >
                            <p>Этап 5</p>
                            <span>Контроль качества
                                и сдача проекта</span>
                        </button>
                    </li>
                </ul>
            </div>
            <div class="tabs__blocks-page one-tabs__blocks-page  wow fadeInRight" data-wow-duration="2s" data-wow-delay="2s">
                <div class="tabs__blocks-page-title">
                    <h3>Приезжаем на объект и <span class="color-text">готовим смету</span></h3>
                    <p>В результате выезда прораба на объект вы получите:</p>
                    <ul>
                        <li>Детальную смету на работы</li>
                        <li>Детальную смету на материалы в 3-х ценовых вариантах</li>
                        <li>Подробный график и план работ</li>
                    </ul>
                    <div class="section-body-page__buttons">
                        <button class="blick" onclick="openQuizModal()">Пригласить прораба <img src="{{ asset('img/icon/comment.svg ') }}"
                                alt=""></button>
                    </div>
                </div>
            </div>
            <div class="tabs__blocks-page two-tabs__blocks-page">
                <div class="tabs__blocks-page-title">
                    <h3>Воплотим ваши представления <br> об идеальном 
                        <span class="color-text">пространстве
                            в реальности</span></h3>
                    <p>Эффективно организуем пространство и продумаем
                        комфорт каждого квадратного метра</p>

                    <div class="section-body-page__buttons">
                        <button class="blick" >Узнать стоимость дизайн-проекта <img src="{{ asset('img/icon/comment.svg ') }}"
                                alt=""></button>
                    </div>
                </div>
            </div>
            <div class="tabs__blocks-page three-tabs__blocks-page">
                <div class="tabs__blocks-page-title">
                    <h3>Закупим материалы по лучшему соотношению  <span class="color-text">цена — качество</span> </h3>
                    <p>Мы сделали более 5 000 дизайн-проектов, поэтому
                        точно знаем надежных производителей и умеем
                        подбирать качественные материалы</p>


                </div>
            </div>
            <div class="tabs__blocks-page four-tabs__blocks-page">
                <div class="tabs__blocks-page-title">
                    <h3><span class="color-text">Контролируем качество</span> на каждом этапе и несем ответственность
                        за ваш ремонт</h3>
                    <p>Делим весь процесс строительства на 12 этапов,
                        каждый из которых проверяет
                        несколько специалистов:</p>
                    <ul>
                        <li>Специалист контроля качества</li>
                        <li>Прораб и руководитель проекта</li>
                        <li>Независимый специалист приёмки</li>
                    </ul>
                    <div class="section-body-page__buttons">
                        <button class="blick"onclick="openQuizModal()" >Обратиться к нам <img src="{{ asset('img/icon/comment.svg ') }}"
                                alt=""></button>
                    </div>
                </div>
            </div>
            <div class="tabs__blocks-page five-tabs__blocks-page">
                <div class="tabs__blocks-page-title">
                    <h3><span class="color-text">Полностью укомплектуем</span> объект мебелью, предметами интерьера
                        и декора</h3>
                    <p>Укомплектуем дом или квартиру всем, что необходимо
                        для комфортной жизни под ваш бюджет — вам остается
                        только забрать ключи и отпраздновать новоселье</p>

                    <div class="section-body-page__buttons">
                        <button class="blick"onclick="openQuizModal()" >Оставить заявку прямо сейчас <img src="{{ asset('img/icon/comment.svg ') }}"
                                alt=""></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Подключение jQuery, если еще не подключена -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        // Устанавливаем активное состояние первому табу
        $('.tabs__blocks-ul li button:first').addClass('active');
        // Скрываем все страницы, кроме первой
        $('.tabs__blocks-page').hide().first().show();

        $('.tabs__blocks-ul li button').click(function() {
            var idx = $(this).parent().index();
            // Обновляем активное состояние табов
            $('.tabs__blocks-ul li button').removeClass('active');
            $(this).addClass('active');
            // Плавно скрываем текущий блок и показываем выбранный
            $('.tabs__blocks-page:visible').fadeOut(300, function() {
                $('.tabs__blocks-page').eq(idx).fadeIn(300);
            });
        });
    });
</script>

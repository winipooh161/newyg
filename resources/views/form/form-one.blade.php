<section  class="form" id="form">
    <div class="container">
       <div class="form-send">
            <div class="form-send__title wow fadeInLeft" data-wow-duration="0.5s" data-wow-delay="0.5s">
                <h2> <span class="color-text">Не знаете,</span> что выбрать?</h2>
                <p>Оставьте заявку и получите детальную консультацию дизайнера и подбор услуги, которая идеально вам подойдет </p>
            </div>
            <form action="{{ route('telegram.store') }}" method="POST" class=" wow fadeInLeft" data-wow-duration="1.2s" data-wow-delay="1.2s">
                @csrf
                <input type="hidden" name="block" value="Консультация дизайнера">
                <h6>Заполните форму ниже</h6>
                <p>Перезвоним в течение 30 минут (в рабочее время), ответим на все вопросы и поможем подобрать услугу</p>
                <div class="form-bloks">
                    <input type="phone" name="phone" id="phone" class="maskphone" placeholder="+7 (___) ___-__-__">
                    <input type="text" name="name" id="name" maxlength="25" placeholder="Ваше имя">
                </div>
                <div class="section-body-page__buttons">
                    <button class="blick" >Отправить заявку <img src="{{ asset('img/icon/send-write.svg ') }}" alt=""></button>
                </div>
            </form>
            <div class="form-person  ">
                {{-- <div class="abs-elements page-abs-elements-one">
                    <img class="animCurdor" src="{{ asset('img/elements/caler.webp ') }}" alt="">
                 </div>
                 <div class="abs-elements page-abs-elements-tree">
                    <img class="animCurdor" src="{{ asset('img/elements/list1.webp ') }}" alt="">
                 </div>
                <img class="animCurdor"src="{{ asset('img/form-one-personal.webp ') }}" alt=""> --}}
               </div>
       </div>
    </div>
</section>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $meta_title ?? 'Админ панель' }}</title>

    {{-- Новые meta-теги для SEO --}}
    <meta name="description" content="{{ $meta_description ?? 'Описание сайта по умолчанию' }}">
    <meta name="keywords" content="{{ $meta_keywords ?? 'ключевое слово1, ключевое слово2, ключевое слово3' }}">
    <meta name="author" content="{{ $meta_author ?? 'Автор сайта' }}">
    <meta name="robots" content="{{ $meta_robots ?? 'index, follow' }}">
    <link rel="canonical" href="{{ $canonical_url ?? url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="{{ $og_title ?? ($meta_title ?? 'Админ панель') }}">
    <meta property="og:description" content="{{ $og_description ?? ($meta_description ?? 'Описание сайта по умолчанию') }}">
    <meta property="og:image" content="{{ $og_image ?? asset('images/og-image.jpg') }}">
    <meta property="og:url" content="{{ $og_url ?? url()->current() }}">
    <meta property="og:type" content="{{ $og_type ?? 'website' }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="{{ $twitter_card ?? 'summary_large_image' }}">
    <meta name="twitter:title" content="{{ $twitter_title ?? ($meta_title ?? 'Админ панель') }}">
    <meta name="twitter:description" content="{{ $twitter_description ?? ($meta_description ?? 'Описание сайта по умолчанию') }}">
    <meta name="twitter:image" content="{{ $twitter_image ?? asset('images/twitter-image.jpg') }}">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Onest:wght@100..900&display=swap" rel="stylesheet">
    <!-- Scripts -->
    @vite([ 'resources/js/app.js', 'resources/css/adm.css', 'resources/css/animate.css', 'resources/css/mobile_adm.css'])
 
    <!-- Общие стили для админки подключены здесь -->
</head>
<script src="{{ asset('js/wow.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>


<div class="loader-container">
    <div class="loader">
      <div class="note-0"></div>
      <div class="note-1"></div>
      <div class="note-2"></div>
      <div class="note-3"></div>
      <div class="note-4"></div>
    </div>
    <div class="status">Загрузка...</div>
</div>
<script>
    window.addEventListener('load', function() {
      const container = document.querySelector('.loader-container');
      // Проигрываем анимацию 2 сек и затем скрываем контейнер
      setTimeout(() => {
        container.style.display = 'none';
      }, 1000);
    });
  </script>
  
<script>
    wow = new WOW({
        boxClass: 'wow', // default
        animateClass: 'animated', // default
        offset: 0, // default
        mobile: true, // default
        live: true // default
    })
    wow.init();
</script>

<body>
    

    <div id="app">
        @auth
            @if(auth()->user()->status === 'admin')
            <div class="admin-panel">
                <div class="container">
                    <div class="admin-panel__content">
                        <span class="admin-welcome">Добро пожаловать, {{ auth()->user()->name }} (Администратор)</span>
                        <button class="admin-menu-toggle" onclick="toggleAdminMenu()">☰</button>
                        <div class="admin-links" id="adminMenu">
                            <a href="{{ route('admin.dashboard') }}" class="admin-link">Главная</a>
                            <a href="{{ route('admin.users') }}" class="admin-link">Пользователи</a>
                            <a href="{{ route('admin.projects') }}" class="admin-link">Проекты</a>
                            <a href="{{ route('feedback.index') }}" class="admin-link">Отзывы</a>
                            <a href="{{ route('admin.video-reels.index') }}" class="admin-link">Видео рилсы</a>
                            <a href="{{ route('admin.site-links') }}" class="admin-link">Ссылки сайта</a>
                            <a href="{{ route('logout') }}" class="admin-link" 
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Выйти
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endauth
        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script>
        function openCommonModal(options) {
    // options: { title, body, footer }
    document.getElementById('commonModalTitle').innerText = options.title || 'Информация';
    document.getElementById('commonModalBody').innerHTML = options.body || '';
    if(options.footer !== undefined) {
        document.getElementById('commonModalFooter').innerHTML = options.footer;
    }
    document.getElementById('commonModal').style.display = 'flex';
}

function closeCommonModal() {
    document.getElementById('commonModal').style.display = 'none';
}

// Закрытие модального окна при клике вне его содержимого
window.addEventListener('click', function(event) {
    let modal = document.getElementById('commonModal');
    if (event.target === modal) {
        closeCommonModal();
    }
});

    </script>
    <script>
        function toggleAdminMenu() {
            const menu = document.getElementById('adminMenu');
            menu.style.display = menu.style.display === 'flex' ? 'none' : 'flex';
        }
    </script>
    <script>
        // Функция, которая каждые 5 секунд запускает анимацию блика для всех элементов с классом .blick
        setInterval(() => {
            document.querySelectorAll('.blick').forEach(el => {
                // Удаляем класс, если анимация уже была запущена ранее
                el.classList.remove('shine');
                // Принудительный reflow для перезапуска анимации
                void el.offsetWidth;
                // Добавляем класс, который запускает анимацию блика
                el.classList.add('shine');
            });
        }, 5000);
    </script>
    
<!-- Скрипт для анимации чисел при попадании в область видимости -->
<script>
    // Функция анимации от start до end за duration (мс)
    function animateValue(span, start, end, duration) {
      let startTime = null;
      function step(timestamp) {
        if (!startTime) startTime = timestamp;
        const progress = timestamp - startTime;
        const current = Math.min(Math.floor((progress / duration) * (end - start) + start), end);
        span.textContent = current;
        if (progress < duration) {
          window.requestAnimationFrame(step);
        } else {
          span.textContent = end;
        }
      }
      window.requestAnimationFrame(step);
    }
  
    // При загрузке DOM:
    document.addEventListener("DOMContentLoaded", function() {
      const spans = document.querySelectorAll('.spanAnim');
      // Сохраняем финальное значение в data-атрибуте и выставляем начальное значение 0
      spans.forEach(span => {
        span.dataset.target = span.textContent;
        span.textContent = '0';
      });
  
      // Observer: следим, когда элемент становится видимым (50% видимости)
      const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const span = entry.target;
            // Запускаем анимацию только один раз
            if (!span.classList.contains('animated')) {
              const targetValue = parseInt(span.dataset.target);
              animateValue(span, 0, targetValue, 2000);
              span.classList.add('animated');
            }
          }
        });
      }, { threshold: 0.5 });
  
      spans.forEach(span => {
        observer.observe(span);
      });
    });
  </script>
    <script>
        // Обработчик движения мыши
        document.addEventListener('mousemove', function(e) {
            // Получаем координаты курсора
            const mouseX = e.clientX;
            const mouseY = e.clientY;

            // Выбираем все элементы с классом animCurdor
            const elements = document.querySelectorAll('.animCurdor');

            elements.forEach(function(el) {
                // Получаем положение и размеры элемента
                const rect = el.getBoundingClientRect();
                // Вычисляем центр элемента
                const elCenterX = rect.left + rect.width / 2;
                const elCenterY = rect.top + rect.height / 2;

                // Вычисляем вектор от курсора к центру элемента
                let offsetX = elCenterX - mouseX;
                let offsetY = elCenterY - mouseY;
                // Вычисляем расстояние между курсором и элементом
                const distance = Math.sqrt(offsetX * offsetX + offsetY * offsetY);

                // Если курсор находится достаточно близко, двигаем элемент
                const activationDistance = 1000; // расстояние активации эффекта (в пикселях)
                if (distance < activationDistance) {
                    // Вычисляем коэффициент воздействия: чем ближе курсор, тем сильнее эффект
                    const factor = (activationDistance - distance) / activationDistance;
                    // Задаем максимальное смещение (в пикселях)
                    const maxTranslate = 20;

                    // Нормализуем вектор и умножаем на максимальное смещение и коэффициент
                    const translateX = (offsetX / distance) * maxTranslate * factor;
                    const translateY = (offsetY / distance) * maxTranslate * factor;

                    el.style.transform = `translate(${translateX}px, ${translateY}px)`;
                } else {
                    // Если курсор далеко – возвращаем элемент на место
                    el.style.transform = 'translate(0, 0)';
                }
            });
        });
    </script>
    <script>
      document.addEventListener("DOMContentLoaded", function() {
          const links = document.querySelectorAll('a[href^="#"]');
  
          links.forEach(link => {
              link.addEventListener("click", function(event) {
                  event.preventDefault(); // Предотвращаем стандартное поведение ссылки
                  const targetId = this.getAttribute("href").substring(1); // Получаем id целевого элемента без символа #
                  const targetElement = document.getElementById(targetId); // Получаем целевой элемент
  
                  if (targetElement) {
                      const offsetTop = targetElement.offsetTop - 120; // Получаем смещение целевого элемента относительно верха страницы с отступом в 200px
                      window.scroll({
                          top: offsetTop,
                          behavior: 'smooth'
                      });
                  }
              });
          });
      });
  </script>
  <script>
    
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
var inputs = document.querySelectorAll("input.maskphone");
for (var i = 0; i < inputs.length; i++) {
 var input = inputs[i];
 input.addEventListener("input", mask);
 input.addEventListener("focus", mask);
 input.addEventListener("blur", mask);
}

function mask(event) {
 var blank = "+_ (___) ___-__-__";
 var i = 0;
 var val = this.value.replace(/\D/g, "").replace(/^8/, "7").replace(/^9/, "79");
 this.value = blank.replace(/./g, function(char) {
     if (/[_\d]/.test(char) && i < val.length) return val.charAt(i++);
     return i >= val.length ? "" : char;
 });
 if (event.type == "blur") {
     if (this.value.length == 2) this.value = "";
 } else {
     setCursorPosition(this, this.value.length);
 }
}

function setCursorPosition(elem, pos) {
 elem.focus();
 if (elem.setSelectionRange) {
     elem.setSelectionRange(pos, pos);
     return;
 }
 if (elem.createTextRange) {
     var range = elem.createTextRange();
     range.collapse(true);
     range.moveEnd("character", pos);
     range.moveStart("character", pos);
     range.select();
     return;
 }
}
});
 </script>
             <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-element-bundle.min.js"></script>
<!-- Добавляем глобальный скрипт для всех кнопок case_button -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const caseButtons = document.querySelectorAll('.case_button');
    caseButtons.forEach(button => {
        button.addEventListener('click', function() {
            window.location.href = "{{ route('projects.index') }}";
        });
    });
});
</script>
<script>
    // Универсальные функции для работы с модальными окнами
    function showModal(modalId, options = {}) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        
        // Если переданы дополнительные опции
        if (options.title) {
            modal.querySelector('.custom-modal-title').textContent = options.title;
        }
        
        if (options.body) {
            const modalBody = modal.querySelector('.custom-modal-body');
            if (typeof options.body === 'string') {
                modalBody.innerHTML = options.body;
            } else if (options.body instanceof HTMLElement) {
                modalBody.innerHTML = '';
                modalBody.appendChild(options.body);
            }
        }
        
        // Показать модальное окно
        modal.classList.add('active');
        
        // Заблокировать прокрутку основной страницы
        document.body.style.overflow = 'hidden';
    }
    
    function hideModal(modalId) {
        const modal = document.getElementById(modalId);
        if (!modal) return;
        
        // Скрыть модальное окно
        modal.classList.remove('active');
        
        // Разблокировать прокрутку
        document.body.style.overflow = '';
    }
    
    // Закрытие модальных окон по клику вне контента
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('custom-modal')) {
            hideModal(e.target.id);
        }
    });
    
    // Закрытие модальных окон по клику на крестик
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('custom-modal-close')) {
            const modal = e.target.closest('.custom-modal');
            if (modal) {
                hideModal(modal.id);
            }
        }
    });
    
    // Закрытие модальных окон по Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const activeModals = document.querySelectorAll('.custom-modal.active');
            activeModals.forEach(modal => hideModal(modal.id));
        }
    });
</script>
 
    @yield('scripts')
</body>
</html>

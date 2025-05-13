<header>
    <div class="container">
        <div class="header__body">
            <div class="header__logo">
                <a href="{{ url('/welcome') }}"><img src="{{ asset('img/icon/logo.svg') }}" alt=""></a>
            </div>
            <div class="icons">
                <a class="icon-info" href="{{ \App\Models\SiteLink::where('key', 'telegram')->first()->value }} ">
                    <img src="{{ asset('img/icon/tg.svg') }}" alt="">
                </a>
                <a class="icon-info" href="{{ \App\Models\SiteLink::where('key', 'whatsapp')->first()->value }}">
                    <img src="{{ asset('img/icon/wa.svg') }}" alt="">
                </a>
                <a class="icon-info" href="">
                    <img src="{{ asset('img/icon/inst.svg') }}" alt="">
                </a>
                {{-- <a class="icon-info" href="{{ \App\Models\SiteLink::where('key', 'rutube')->first()->value }}">
                    <img src="{{asset('img/icon/ru.svg')}}" alt="">
                </a>
                <a class="icon-info" href="{{ \App\Models\SiteLink::where('key', 'zen')->first()->value }}">
                    <img src="{{asset('img/icon/dz.svg')}}" alt="">
                </a> --}}
                <a class="icon-info" href="{{ \App\Models\SiteLink::where('key', 'vk')->first()->value }}">
                    <img src="{{ asset('img/icon/vk.svg') }}" alt="">
                </a>
            </div>
            <div class="header__number">
                <div class="burger">
                    <svg viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <path
                                d="M4 7C4 6.44771 4.44772 6 5 6H24C24.5523 6 25 6.44771 25 7C25 7.55229 24.5523 8 24 8H5C4.44772 8 4 7.55229 4 7Z"
                                fill="#000"></path>
                            <path
                                d="M4 13.9998C4 13.4475 4.44772 12.9997 5 12.9997L16 13C16.5523 13 17 13.4477 17 14C17 14.5523 16.5523 15 16 15L5 14.9998C4.44772 14.9998 4 14.552 4 13.9998Z"
                                fill="#000"></path>
                            <path
                                d="M5 19.9998C4.44772 19.9998 4 20.4475 4 20.9998C4 21.552 4.44772 21.9997 5 21.9997H22C22.5523 21.9997 23 21.552 23 20.9998C23 20.4475 22.5523 19.9998 22 19.9998H5Z"
                                fill="#000"></path>
                        </g>
                    </svg>
                    <input type="checkbox" id="burger-toggle">
                    <label for="burger-toggle"></label>
                    <div class="links">
                        <ul>
                            <li class="nav-item"><a href="{{ url('/projects') }}"
                                    class="nav-link smoth-animation">Главная </a></li>
                            <li class="nav-item"><a href="{{ url('/welcome') }}#tabs"
                                    class="nav-link smoth-animation">Этапы работы </a>
                            </li>
                            <li class="nav-item"><a href="{{ url('/welcome') }}#info"
                                    class="nav-link smoth-animation">Гарантии </a></li>
                            <li class="nav-item"><a href="{{ url('/welcome') }}#services"
                                    class="nav-link smoth-animation">Комплекс услуг
                                </a></li>
                            <li class="nav-item"><a href="{{ url('/welcome') }}#avtor"
                                    class="nav-link smoth-animation">Дизайн-проект </a>
                            </li>
                            <li class="nav-item"><a href="{{ url('/gallery') }}"
                                    class="nav-link smoth-animation">Галерея </a></li>
                            <li class="nav-item"><a href="{{ route('video-reels') }}"
                                    class="nav-link smoth-animation">Видео рилсы </a></li>
                            <li class="nav-item"><a href="{{ url('/welcome') }}#map" class="nav-link smoth-animation">О
                                    компании </a></li>
                        </ul>

                    </div>
                </div>

                <script>
                    // Get the burger menu and checkbox elements
                    const burgerToggle = document.getElementById('burger-toggle');
                    const burgerMenu = document.querySelector('.burger');

                    // Function to handle clicks outside the burger menu
                    function handleClickOutside(event) {
                        if (!burgerMenu.contains(event.target) && !burgerToggle.contains(event.target)) {
                            // Uncheck the checkbox if the click is outside
                            burgerToggle.checked = false;
                        }
                    }

                    // Add event listener to document for clicks
                    document.addEventListener('click', handleClickOutside);
                </script>

                <a class="header__number_a"
                    href="tel:{{ \App\Models\SiteLink::where('key', 'phone')->first()->value }} ">{{ \App\Models\SiteLink::where('key', 'phone')->first()->value }}
                </a>
                <a href="mailto:{{ \App\Models\SiteLink::where('key', 'email')->first()->value }} ">{{ \App\Models\SiteLink::where('key', 'email')->first()->value }}
                </a>
            </div>
        </div>
        <ul>
            <li><a href="{{ url('/projects') }}">Выполненные проекты </a></li>
            <li><a href="{{ url('/welcome') }}#tabs">Этапы работы</a></li>
            <li><a href="{{ url('/welcome') }}#info">Гарантии</a></li>
            <li><a href="{{ url('/welcome') }}#services">комплекс
                    услуг </a></li>
            <li><a href="{{ url('/welcome') }}#avtor">Дизайн-проект</a></li>
            <li><a href="{{ url('/gallery') }}">Галерея</a></li>
            <!-- Add this to your navigation menu in the appropriate header template -->
            <li><a href="{{ route('video-reels') }}">Видео рилсы</a></li>
            <li><a href="{{ url('/welcome') }}#map">О компании</a></li>
        </ul>

    </div>
</header>

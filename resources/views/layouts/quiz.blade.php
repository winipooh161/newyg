<!-- Модальное окно с квизом -->
<div id="quizModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeQuizModal()">&times;</span>
        <div id="quizContent">
        </div>
        <div id="quizNavigation">
            <div class="quizNavigation-duv"> <button class="quizNavigation-prev" onclick="prevQuestion()"><-</button>
                <button class="quizNavigation-next" onclick="nextQuestion()">-></button></div>
           
        </div>
    </div>
</div>

<script>
var telegramStoreUrl = "{{ route('telegram.store') }}";
// Новый объект данных квиза со страницами:
var quizData = {
    page: "page",
    questions: [
        {
            question: "Где Вы планируете делать ремонт?",
            type: "radio-image",
            options: [
                { value: "apartment", text: "Квартира - новостройка", image: "{{ asset('img/quiz/apartment.jpg') }}" },
                { value: "cottage", text: "Квартира - вторичка", image: "{{ asset('img/quiz/cottage.jpg') }}" },
                { value: "office", text: "Дом, коттедж", image: "{{ asset('img/quiz/office.jpg') }}" },
                { value: "commercia", text: "Коммерческое помещение", image: "{{ asset('img/quiz/commercia.jpg') }}" }
            ]
        },
        {
            question: "Какой тип ремонта Вас интересует?",
            type: "radio",
            options: [
                { value: "designer", text: "Дизайнерский" },
                { value: "capital", text: "Капитальный" },
                { value: "finish", text: "Чистовой" },
                { value: "rough", text: "Черновой" }
            ]
        },
        {
            question: "Какая у Вас общая площадь объекта?",
            type: "radio",
            options: [
                { value: "40-70", text: "От 40 до 70 м²" },
                { value: "70-100", text: "От 70 до 100 м²" },
                { value: "100-150", text: "От 100 до 150 м²" },
                { value: "150+", text: "Больше 150 м²" }
            ]
        },
        {
            question: "Требуется ли дизайн проект?",
            type: "radio",
            options: [
                { value: "yes", text: "Да" },
                { value: "no", text: "Нет" },
                { value: "without", text: "Будем делать без проекта" },
                { value: "unknown", text: "Не знаю" }
            ]
        }
    ]
};

var currentQuestionIndex = 0;
var quizAnswers = {}; // Для хранения выбранных ответов

function openQuizModal(){
    document.getElementById('quizModal').style.display = 'flex';
    currentQuestionIndex = 0;
    renderQuestion();
}

function closeQuizModal(){
    document.getElementById('quizModal').style.display = 'none';
    document.getElementById('quizContent').innerHTML = '';
}

function highlightOption(label) {
    // Находим контейнер, где находятся все варианты
    var container = label.parentElement.parentElement;
    var labels = container.querySelectorAll('label');
    labels.forEach(function(l) {
        l.classList.remove('selected');
    });
    label.classList.add('selected');
}

function renderQuestion(){
    var container = document.getElementById('quizContent');
    var progressText = '';
    if(currentQuestionIndex === quizData.questions.length){
        progressText = '<div id="quizProgress">Заполнение данных</div>';
        // Формируем форму без кнопки отправки
        var formHtml = progressText +
            '<h3 style="margin-bottom:15px;">Заполните данные для отправки:</h3>' +
            '<form id="quizForm" action="' + telegramStoreUrl + '" method="POST">' +
            '<input type="hidden" name="_token" value="{{ csrf_token() }}">' +
            '<div style="margin-bottom:5px; margin-top:5px;"><label>Ваше имя:</label>' +
            '<input type="text" name="name" style=""></div>' +
            '<div style="margin-bottom:5px; margin-top:5px;"><label>Телефон:</label>' +
            '<input type="text" name="phone" class="maskphone" style=""></div>' +
            '</form>';
        container.innerHTML = formHtml;
        // Меняем навигацию: кнопка "Обратно" и кнопка "Отправить" вместо "Продолжить"
        document.getElementById('quizNavigation').innerHTML =
            '<button onclick="prevQuestion()"><-</button>' +
            '<button id="sendForm" type="button" onclick="submitQuizForm()">Отправить</button>';
        return;
    } else {
        progressText = '<div id="quizProgress">Вопрос ' + (currentQuestionIndex + 1) + ' из ' + (quizData.questions.length + 1) + '</div>';
    }
    
    var qData = quizData.questions[currentQuestionIndex];
    var html = progressText + '<h3 style="">' + qData.question + '</h3>';
    
    if(qData.type === 'radio-image'){
        qData.options.forEach(function(opt, index){
            html += '<div class="radio-image" style="display:flex; ">' +
                    '<input type="radio" name="quizOption" id="q' + currentQuestionIndex + 'opt'+ index +'" value="'+opt.value+'" style="display:none;">' +
                    '<label for="q' + currentQuestionIndex + 'opt'+ index +'" style="cursor:pointer;" onclick="highlightOption(this)">' +
                    '<img src="'+ opt.image +'" alt="'+opt.text+'" style="">' +
                    '<span>'+ opt.text +'</span>' +
                    '</label>' +
                    '</div>';
        });
    }
    else if(qData.type === 'radio'){
        qData.options.forEach(function(opt, index){
            html += '<div class="radio">' +
                    '<input type="radio" name="quizOption" id="q' + currentQuestionIndex + 'opt'+ index +'" value="'+opt.value+'" style="">' +
                    '<label for="q' + currentQuestionIndex + 'opt'+ index +'" onclick="highlightOption(this)"> '+ opt.text +'</label>' +
                    '</div>';
        });
    }
    // Удаляем кнопку "Продолжить" из контента вопроса:
    container.innerHTML = html;
    // Обновляем навигацию: кнопка "Назад" и отключённая кнопка "Продолжить"
    document.getElementById('quizNavigation').innerHTML = 
         '<button onclick="prevQuestion()"><-</button>' +
         '<button id="nextQuestion" onclick="nextQuestion()" disabled style="opacity:0.5; transition: opacity 0.3s;">Продолжить</button>';
    container.classList.add('fade-in');
    setTimeout(function(){ container.classList.remove('fade-in'); }, 500);
}

// Обработчик для включения кнопки после выбора варианта
document.addEventListener('change', function(e){
    if(e.target && e.target.name === 'quizOption'){
        var nextBtn = document.getElementById('nextQuestion');
        if(e.target.checked){
            nextBtn.disabled = false;
            nextBtn.style.opacity = 1;
            nextBtn.classList.add('bounce');
            setTimeout(function(){ nextBtn.classList.remove('bounce'); }, 500);
        }
    }
});

function nextQuestion(){
    // Сохраняем выбранный ответ (если есть)
    var sel = document.querySelector('input[name="quizOption"]:checked');
    if(sel){
        quizAnswers[currentQuestionIndex] = sel.value;
    } else {
        alert("Выберите вариант ответа или заполните форму.");
        return;
    }
    // Если не последняя страница - идём дальше
    if(currentQuestionIndex < quizData.questions.length){
        currentQuestionIndex++;
        renderQuestion();
    }
}

function prevQuestion(){
    if(currentQuestionIndex > 0){
        currentQuestionIndex--;
        renderQuestion();
    }
}

function submitQuizForm(){
    var form = document.getElementById('quizForm');
    var formData = new FormData(form);
    formData.append('quiz', JSON.stringify(quizAnswers));
    // Изменено: используем telegramStoreUrl вместо '/submitQuiz'
    fetch(telegramStoreUrl, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
    }).then(response => response.json())
      .then(data => {
          alert("Спасибо, опрос отправлен!");
          closeQuizModal();
      })
      .catch(error => {
          console.error('Ошибка:', error);
      });
}

document.getElementById('quizModal').addEventListener('click', function(e){
    if(e.target.id === 'quizModal'){
        closeQuizModal();
    }
});
</script>

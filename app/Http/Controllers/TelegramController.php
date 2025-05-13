<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller
{
    // Изменено: убраны вызовы env() из объявления свойства
    private $botToken  = '7757340832:AAGXIb3wGYCRTAGJIh_Qtp_jyB5GYxyCIh4';
    private $chatId   = '-1002552982297';
    
    // Добавляем конструктор для инициализации $botToken
  

    public function store(Request $request)
    {
        // Получаем значение block и исключаем его из остальных данных
        $block = $request->input('block');
        $data = $request->except('block'); 

        // Формируем текст письма из всех параметров запроса
        $text = "<b>Новая заявка:</b>\n\n";  // изменено: начинаем с заголовка
        if ($block) {
            $text .= "<b>Блок:</b> " . $block . "\n\n";
        }
        foreach ($data as $key => $value) {
            if ($key === 'quiz') {
                $quizData = json_decode($value, true);
                if (is_array($quizData)) {
                    // Массив переводов остается без изменений
                    $translations = [
                        0 => [
                            "apartment" => "Квартира - новостройка",
                            "cottage"   => "Квартира - вторичка",
                            "office"    => "Дом, коттедж",
                            "commercia" => "Коммерческое помещение"
                        ],
                        1 => [
                            "designer" => "Дизайнерский",
                            "capital"  => "Капитальный",
                            "finish"   => "Чистовой",
                            "rough"    => "Черновой"
                        ],
                        2 => [
                            "40-70"   => "От 40 до 70 м²",
                            "70-100"  => "От 70 до 100 м²",
                            "100-150" => "От 100 до 150 м²",
                            "150+"    => "Больше 150 м²"
                        ],
                        3 => [
                            "yes"     => "Да",
                            "no"      => "Нет",
                            "without" => "Будем делать без проекта",
                            "unknown" => "Не знаю"
                        ]
                    ];
                    // Добавляем массив вопросов
                    $questions = [
                        0 => "Где Вы планируете делать ремонт?",
                        1 => "Какой тип ремонта Вас интересует?",
                        2 => "Какая у Вас общая площадь объекта?",
                        3 => "Требуется ли дизайн проект?"
                    ];
                    $text .= "<b>Мини-Квиз:</b>\n";
                    foreach ($quizData as $index => $answer) {
                        $qNumber = $index + 1;
                        $translated = isset($translations[$index][$answer]) ? $translations[$index][$answer] : $answer;
                        $questionText = isset($questions[$index]) ? $questions[$index] : "Вопрос {$qNumber}";
                        $text .= "  • {$questionText}:\n <i>{$translated}</i>\n";
                    }
                    continue;
                }
            }
            $text .= "<b>" . ucfirst($key) . "</b>: " . $value . "\n";
        }
        
        // Формируем URL для API запроса
        $url = "https://api.telegram.org/bot{$this->botToken}/sendMessage?" . http_build_query([
            'chat_id' => $this->chatId,
            'parse_mode' => 'HTML',
            'text' => $text
        ]);
        
        // Оборачиваем отправку запроса в блок try-catch для обработки ошибок
        try {
            file_get_contents($url);
            return redirect()->route('thanks'); // Перенаправление на страницу благодарности
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    /**
     * Отображает страницу благодарности
     */
    public function thanks()
    {
        // Улучшенные SEO данные
        $meta_title = 'Спасибо за заявку | ЮГСТИЛЬ';
        $meta_description = 'Спасибо за заявку. Наши специалисты свяжутся с Вами в ближайшее время для обсуждения деталей.';
        $meta_keywords = 'спасибо, заявка, ремонт, консультация, югстиль';
        $meta_author = 'ЮГСТИЛЬ';
        
        // Указываем, что страница не должна индексироваться
        $meta_robots = 'noindex, follow';
        
        // Микроразметка для страницы благодарности
        $schema_markup = json_encode([
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "Спасибо за заявку",
            "description" => "Спасибо за заявку. Наши специалисты свяжутся с Вами в ближайшее время.",
            "publisher" => [
                "@type" => "Organization",
                "name" => "ЮГСТИЛЬ",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => asset('img/icon/logo.svg')
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        
        return view('thanks', compact('meta_title', 'meta_description', 'meta_keywords', 'meta_author', 'meta_robots', 'schema_markup'));
    }
}

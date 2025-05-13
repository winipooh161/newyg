<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;
use App\Services\SeoService;

class GalleryController extends Controller
{
    public function index()
    {
        // Получаем все директории в папке gallery
        $directories = Storage::directories('public/gallery');
        
        // Создаем массив для хранения изображений по проектам
        $projectImages = [];
        
        // Для каждой директории получаем файлы и формируем массив путей
        foreach ($directories as $directory) {
            $dirName = basename($directory);
            $files = Storage::files($directory);
            
            // Пропускаем пустые директории
            if (empty($files)) continue;
            
            // Формируем массив путей с заменой public на storage для правильного отображения
            $images = array_map(function($file) {
                return str_replace('public', 'storage', $file);
            }, $files);
            
            // Сохраняем изображения под именем директории (ID проекта)
            $projectImages[$dirName] = $images;
        }
        
        // Для страницы галереи можно использовать до 10 проектов
        if (count($projectImages) > 10) {
            $projectImages = array_slice($projectImages, 0, 10, true);
        }
        
        // Если нет папок с проектами, проверяем наличие изображений непосредственно в gallery
        if (empty($projectImages)) {
            $files = Storage::files('public/gallery');
            if (!empty($files)) {
                $images = array_map(function($file) {
                    return str_replace('public', 'storage', $file);
                }, $files);
                
                // Для страницы галереи разбиваем на 10 слайдов
                $sliderCount = 10;
                $chunkSize = ceil(count($images) / $sliderCount);
                $chunkedImages = array_chunk($images, $chunkSize);
                
                // Ограничиваем количество слайдов до 10
                $chunkedImages = array_slice($chunkedImages, 0, 10);
                
                $projectImages['default'] = $images;
            } else {
                $chunkedImages = [];
            }
        } else {
            // Для совместимости создаем chunkedImages из всех изображений проектов
            $allImages = [];
            foreach ($projectImages as $images) {
                $allImages = array_merge($allImages, $images);
            }
            
            $sliderCount = 10;
            $chunkSize = ceil(count($allImages) / $sliderCount);
            $chunkedImages = array_chunk($allImages, $chunkSize);
            
            // Ограничиваем количество слайдов до 10
            $chunkedImages = array_slice($chunkedImages, 0, 10);
        }
        
        // Получаем все проекты для связывания с директориями
        $projects = Project::all()->keyBy('id');
        
        // Для страницы галереи всегда показываем заголовки проектов
        $showProjectTitles = true;
        
        // Для совместимости передаем allProjects
        $allProjects = $projects;

        // Улучшенные SEO данные для страницы галереи
        $meta_title = 'Фотогалерея ремонтов от ЮГСТИЛЬ - Примеры наших работ';
        $meta_description = 'Обширная фотогалерея дизайнерских интерьеров и ремонтов квартир, домов и коммерческих помещений от компании ЮГСТИЛЬ. Более 200 реализованных проектов с фото до и после.';
        $meta_keywords = 'галерея ремонтов, фото интерьеров, примеры ремонта квартир, дизайн-проекты, ремонт под ключ, фотографии ремонта, югстиль, ростовская область';
        $meta_author = 'ЮГСТИЛЬ';
        
        // Расширенные Open Graph теги для лучшего отображения в соцсетях
        $og_title = 'Фотогалерея дизайнерских решений и ремонта от ЮГСТИЛЬ';
        $og_description = 'Вдохновитесь нашими лучшими проектами по ремонту и дизайну интерьеров квартир и домов. Более 200 выполненных работ в Ростовской области.';
        $og_type = 'website';
        
        // Каноническая ссылка для SEO
        $canonical_url = url('/gallery');
        
        // Twitter карточка
        $twitter_card = 'summary_large_image';
        $twitter_title = 'Фотогалерея ремонтов ЮГСТИЛЬ';
        $twitter_description = 'Смотрите фотогалерею наших лучших работ по ремонту и дизайну интерьеров';
        
        // Получаем одно из изображений для превью (OpenGraph и Twitter)
        $preview_image = null;
        if (!empty($projectImages) && !empty(reset($projectImages))) {
            $preview_image = asset(reset($projectImages)[0]);
            $og_image = $preview_image;
            $twitter_image = $preview_image;
        }
        
        // Создаем расширенную микроразметку Schema.org для галереи
        $schema_markup = $this->getGallerySchema($projectImages, $projects);
        
        return view('gallery', compact(
            'projectImages', 
            'allProjects', 
            'showProjectTitles',
            'meta_title', 
            'meta_description', 
            'meta_keywords', 
            'meta_author',
            'og_title', 
            'og_description', 
            'og_image', 
            'og_type',
            'canonical_url',
            'twitter_card',
            'twitter_title',
            'twitter_description',
            'twitter_image',
            'schema_markup'
        ));
    }
    
    /**
     * Генерирует расширенную микроразметку Schema.org для страницы галереи
     *
     * @param array $projectImages Массив изображений проектов
     * @param \Illuminate\Database\Eloquent\Collection $projects Коллекция проектов
     * @return string JSON микроразметка
     */
    private function getGallerySchema($projectImages, $projects)
    {
        // Базовая информация о сайте и организации
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                // Информация о странице
                [
                    '@type' => ['WebPage', 'CollectionPage', 'ImageGallery'],
                    '@id' => url('/gallery') . '#webpage',
                    'url' => url('/gallery'),
                    'name' => 'Фотогалерея ремонтов от ЮГСТИЛЬ - Примеры наших работ',
                    'description' => 'Обширная фотогалерея дизайнерских интерьеров и ремонтов квартир, домов и коммерческих помещений от компании ЮГСТИЛЬ.',
                    'isPartOf' => [
                        '@id' => url('/') . '#website'
                    ],
                    'inLanguage' => 'ru-RU',
                    'datePublished' => '2023-01-01T10:00:00+03:00',
                    'dateModified' => date('c')
                ],
                // Информация о веб-сайте
                [
                    '@type' => 'WebSite',
                    '@id' => url('/') . '#website',
                    'url' => url('/'),
                    'name' => 'ЮГСТИЛЬ',
                    'description' => 'Ремонт квартир и домов «под ключ» в Ростовской области',
                    'publisher' => [
                        '@id' => url('/') . '#organization'
                    ],
                    'inLanguage' => 'ru-RU'
                ],
                // Информация об организации
                [
                    '@type' => 'Organization',
                    '@id' => url('/') . '#organization',
                    'name' => 'ЮГСТИЛЬ',
                    'url' => url('/'),
                    'logo' => [
                        '@type' => 'ImageObject',
                        'url' => asset('img/icon/logo.svg'),
                        'width' => '180',
                        'height' => '60'
                    ],
                    'image' => [
                        '@id' => url('/') . '#logo'
                    ],
                    'contactPoint' => [
                        [
                            '@type' => 'ContactPoint',
                            'telephone' => '+7-XXX-XXX-XX-XX', // Рекомендуется заменить на реальный номер
                            'contactType' => 'customer service',
                            'availableLanguage' => 'Russian'
                        ]
                    ]
                ],
                // Хлебные крошки для страницы
                [
                    '@type' => 'BreadcrumbList',
                    '@id' => url('/gallery') . '#breadcrumb',
                    'itemListElement' => [
                        [
                            '@type' => 'ListItem',
                            'position' => 1,
                            'name' => 'Главная',
                            'item' => url('/')
                        ],
                        [
                            '@type' => 'ListItem',
                            'position' => 2,
                            'name' => 'Галерея',
                            'item' => url('/gallery')
                        ]
                    ]
                ]
            ]
        ];
        
        // Добавляем изображения из проектов в микроразметку
        $imageItems = [];
        $position = 1;
        
        foreach ($projectImages as $projectId => $images) {
            $projectName = isset($projects[$projectId]) ? $projects[$projectId]->title : 'Проект';
            
            foreach ($images as $image) {
                $imageUrl = asset($image);
                
                $imageItems[] = [
                    '@type' => 'ImageObject',
                    'contentUrl' => $imageUrl,
                    'name' => "{$projectName} - фото {$position}",
                    'description' => "Фотография из проекта {$projectName} от компании ЮГСТИЛЬ",
                    'position' => $position++
                ];
            }
        }
        
        // Если есть изображения, добавляем их в граф
        if (!empty($imageItems)) {
            $schema['@graph'][] = [
                '@type' => 'ItemList',
                '@id' => url('/gallery') . '#imagelist',
                'itemListElement' => $imageItems,
                'numberOfItems' => count($imageItems),
                'name' => 'Галерея проектов ЮГСТИЛЬ'
            ];
        }
        
        return json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}

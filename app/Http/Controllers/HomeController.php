<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Feedback;
use App\Services\SeoService;

class HomeController extends Controller
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
            $images = array_map(function ($file) {
                return str_replace('public', 'storage', $file);
            }, $files);

            // Сохраняем изображения под именем директории (ID проекта)
            $projectImages[$dirName] = $images;
        }

        // Сортируем проекты по убыванию ключей (идентификаторов)
        $projectImages = collect($projectImages)->sortKeysDesc()->toArray();

        // Для главной страницы ограничиваем количество проектов до 3
        if (!empty($projectImages)) {
            // Ограничиваем до 3 проектов для главной страницы
            $projectImages = array_slice($projectImages, 0, 3, true);
        }

        // Если нет папок с проектами, проверяем наличие изображений непосредственно в gallery
        if (empty($projectImages)) {
            $files = Storage::files('public/gallery');
            if (!empty($files)) {
                $images = array_map(function ($file) {
                    return str_replace('public', 'storage', $file);
                }, $files);

                // Для главной страницы создаем 3 слайда
                $sliderCount = 3;
                $chunkSize = ceil(count($images) / $sliderCount);
                $chunkedImages = array_chunk($images, $chunkSize);

                // Оставляем только первые 3 слайда (если их больше)
                $chunkedImages = array_slice($chunkedImages, 0, 3);

                // Сохраняем изображения в 'default' для новой структуры
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

            $sliderCount = 3;
            $chunkSize = ceil(count($allImages) / $sliderCount);
            $chunkedImages = array_chunk($allImages, $chunkSize);

            // Оставляем только первые 3 слайда (если их больше)
            $chunkedImages = array_slice($chunkedImages, 0, 3);
        }

        // Получаем проекты для слайдера на главной странице
        $projects = Project::orderBy('id', 'desc')->take(6)->get();

        // Для главной страницы помечаем, что не нужно отображать заголовки проектов
        $showProjectTitles = false;

        // Получаем все проекты для связывания с директориями
        $allProjects = Project::all()->keyBy('id');

        // Получаем одобренные отзывы для отображения на главной странице
        $feedbacks = Feedback::where('approved', true)
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
        $title = 'ЮГСТИЛЬ - Ремонт квартир и домов «под ключ» в Ростовской области';
        $subtitle = 'Главная страница';
        $meta_title       = 'ЮГСТИЛЬ - Ремонт квартир и домов';
        $meta_description = 'Главная страница сайта о ремонте квартир и домов в Ростовской области.';
        $meta_keywords    = 'ремонт, квартиры, дома, дизайн, югстиль';
        $meta_author      = 'Название сайта';

        // SEO данные
        $meta_title = 'ЮГСТИЛЬ - Ремонт квартир и домов «под ключ» в Ростовской области';
        $meta_description = 'Профессиональный ремонт квартир, домов и коммерческих помещений в Ростовской области. Дизайн-проекты, отделочные работы любой сложности.';
        $meta_keywords = 'ремонт квартир, ремонт домов, дизайн интерьера, отделочные работы, югстиль, ростовская область';
        $meta_author = 'ЮГСТИЛЬ';
        
        // Добавляем микроразметку
        $schema_markup = SeoService::getHomeSchema();

        return view('welcome', compact('chunkedImages', 'projects', 'projectImages',
            'allProjects', 'showProjectTitles', 'feedbacks', 'title', 'subtitle',
            'meta_title', 'meta_description', 'meta_keywords', 'meta_author', 'schema_markup'));
    }
}

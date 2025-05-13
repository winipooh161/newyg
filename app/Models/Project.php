<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title', 
        'description', 
        'category', 
        'completed_date', 
        'area', 
        'cost',
        'duration',
        'location',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'content',
        'image',
        'price',
        'time',
        'slug',
        'video_path'
    ];
    
    /**
     * Преобразует дату завершения проекта в формат Carbon
     */
    protected $casts = [
        'completed_date' => 'date',
    ];
    
    /**
     * Получить основное изображение проекта для превью
     */
    public function getMainImage()
    {
        $images = $this->getGalleryImages();
        return !empty($images) ? $images[0] : asset('img/no-image.png');
    }
    
    /**
     * Получить все изображения галереи проекта
     */
    public function getGalleryImages()
    {
        $directory = 'public/gallery/' . $this->id;
        
        if (!Storage::exists($directory)) {
            return [];
        }
        
        $files = Storage::files($directory);
        
        return array_map(function($file) {
            return asset(str_replace('public', 'storage', $file));
        }, $files);
    }
    
    /**
     * Получить SEO заголовок страницы проекта
     */
    public function getSeoTitle()
    {
        return $this->meta_title ?? 'Проект: ' . $this->title . ' | ЮГСТИЛЬ';
    }
    
    /**
     * Получить SEO описание страницы проекта
     */
    public function getSeoDescription()
    {
        return $this->meta_description ?? $this->description ?? 'Подробная информация о проекте ' . $this->title . ' от компании ЮГСТИЛЬ';
    }
    
    /**
     * Получить SEO ключевые слова страницы проекта
     */
    public function getSeoKeywords()
    {
        return $this->meta_keywords ?? 'проект, ' . $this->title . ', ремонт, дизайн интерьера, отделка';
    }

    /**
     * Проверяет, есть ли у проекта видео
     */
    public function hasVideo()
    {
        return !empty($this->video_path) && file_exists(public_path($this->video_path));
    }
    
    /**
     * Получить URL видео проекта
     */
    public function getVideoUrl()
    {
        return $this->hasVideo() ? asset($this->video_path) : null;
    }
}

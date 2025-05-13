<?php

namespace App\Services;

use App\Models\Project;
use App\Models\VideoReel;
use Illuminate\Support\Facades\URL;

class SeoService
{
    /**
     * Get schema markup for home page
     */
    public static function getHomeSchema()
    {
        return json_encode([
            "@context" => "https://schema.org",
            "@type" => "Organization",
            "name" => "ЮГСТИЛЬ",
            "url" => url('/'),
            "logo" => asset('img/icon/logo.svg'),
            "contactPoint" => [
                "@type" => "ContactPoint",
                "telephone" => "+7-XXX-XXX-XXXX",
                "contactType" => "customer service"
            ],
            "sameAs" => [
                "https://vk.com/your-profile",
                "https://rutube.ru/your-profile"
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Get schema markup for gallery page
     */
    public static function getGallerySchema()
    {
        return json_encode([
            "@context" => "https://schema.org",
            "@type" => "ImageGallery",
            "name" => "ЮГСТИЛЬ - Галерея проектов",
            "description" => "Фотогалерея выполненных проектов по ремонту и дизайну",
            "url" => route('gallery'),
            "publisher" => [
                "@type" => "Organization",
                "name" => "ЮГСТИЛЬ",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => asset('img/icon/logo.svg')
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    /**
     * Get schema markup for video reels page
     */
    public static function getVideoReelsSchema()
    {
        $reels = VideoReel::where('is_active', 1)->limit(5)->get();
        
        $videoItems = [];
        foreach($reels as $reel) {
            $videoItems[] = [
                "@type" => "VideoObject",
                "name" => $reel->title,
                "description" => $reel->description,
                "thumbnailUrl" => $reel->thumbnail_url,
                "uploadDate" => $reel->created_at->toIso8601String(),
                "contentUrl" => $reel->video_url,
            ];
        }
        
        return json_encode([
            "@context" => "https://schema.org",
            "@type" => "ItemList",
            "itemListElement" => $videoItems
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
    
    /**
     * Get schema markup for a specific project
     */
    public static function getProjectSchema(Project $project)
    {
        return json_encode([
            "@context" => "https://schema.org",
            "@type" => "CreativeWork",
            "name" => $project->title,
            "description" => $project->description,
            "image" => $project->thumbnail ? asset('storage/'.$project->thumbnail) : asset('img/default-project.jpg'),
            "datePublished" => $project->created_at->toIso8601String(),
            "author" => [
                "@type" => "Organization",
                "name" => "ЮГСТИЛЬ"
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}

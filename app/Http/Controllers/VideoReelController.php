<?php

namespace App\Http\Controllers;

use App\Models\VideoReel;
use Illuminate\Http\Request;
use App\Services\SeoService;

class VideoReelController extends Controller
{
    public function index(Request $request)
    {
        $reels = VideoReel::where('is_active', 1)
            ->orderBy('order')
            ->paginate(8);
            
        if ($request->ajax()) {
            $view = view('video-reels.partials.reel-items', compact('reels'))->render();
            return response()->json([
                'html' => $view,
                'hasMorePages' => $reels->hasMorePages()
            ]);
        }
        
        // Улучшенные SEO данные для страницы видео рилсов
        $meta_title = 'Видео рилсы о ремонте и дизайне | ЮГСТИЛЬ';
        $meta_description = 'Смотрите наши видео рилсы о ремонте квартир, дизайне интерьера и строительстве от компании ЮГСТИЛЬ';
        $meta_keywords = 'видео рилсы, короткие видео, ремонт, дизайн интерьера, строительство, югстиль';
        $meta_author = 'ЮГСТИЛЬ';
        
        // Open Graph теги для видео контента
        $og_title = 'Видео рилсы о ремонте и дизайне интерьеров | ЮГСТИЛЬ';
        $og_description = 'Короткие видео о процессах ремонта, советы по дизайну и строительству';
        $og_type = 'video';
        
        // Добавляем микроразметку для видео галереи
        $schema_markup = SeoService::getVideoReelsSchema();
        
        return view('reels', compact('reels', 'meta_title', 'meta_description', 'meta_keywords', 
            'meta_author', 'og_title', 'og_description', 'og_type', 'schema_markup'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Services\SeoService;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        
        // Standard SEO data instead of project-specific
        $meta_title = 'ЮГСТИЛЬ - Ремонт квартир и домов';
        $meta_description = 'Ремонт квартир и домов «под ключ» в Ростовской области';
        $meta_keywords = 'ремонт, квартиры, дома, дизайн, югстиль';
        $meta_author = 'ЮГСТИЛЬ';
        
        // Use standard schema markup
        $schema_markup = json_encode([
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "ЮГСТИЛЬ - Ремонт квартир и домов",
            "description" => "Ремонт квартир и домов «под ключ» в Ростовской области",
            "publisher" => [
                "@type" => "Organization",
                "name" => "ЮГСТИЛЬ",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => asset('img/icon/logo.svg')
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        
        return view('projects.index', compact('projects', 'meta_title', 'meta_description', 'meta_keywords', 'meta_author', 'schema_markup'));
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        $galleryImages = $project->getGalleryImages();
        
        // Standard SEO data instead of project-specific
        $meta_title = 'ЮГСТИЛЬ - Ремонт квартир и домов';
        $meta_description = 'Ремонт квартир и домов «под ключ» в Ростовской области';
        $meta_keywords = 'ремонт, квартиры, дома, дизайн, югстиль';
        $meta_author = 'ЮГСТИЛЬ';
        
        // Standard Open Graph tags
        $og_title = 'ЮГСТИЛЬ - Ремонт квартир и домов';
        $og_description = 'Ремонт квартир и домов «под ключ» в Ростовской области';
        $og_image = asset('img/icon/logo.svg');
        $og_type = 'website';
        
        // Standard schema markup
        $schema_markup = json_encode([
            "@context" => "https://schema.org",
            "@type" => "WebPage",
            "name" => "ЮГСТИЛЬ - Ремонт квартир и домов",
            "description" => "Ремонт квартир и домов «под ключ» в Ростовской области",
            "publisher" => [
                "@type" => "Organization",
                "name" => "ЮГСТИЛЬ",
                "logo" => [
                    "@type" => "ImageObject",
                    "url" => asset('img/icon/logo.svg')
                ]
            ]
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        
        return view('projects.show', compact('project', 'galleryImages', 'meta_title', 'meta_description', 
            'meta_keywords', 'meta_author', 'og_title', 'og_description', 'og_image', 'og_type', 'schema_markup'));
    }

    public function gallery($id)
    {
        $project = Project::findOrFail($id);
        $images = $project->getGalleryImages();
        return response()->json($images);
    }
}

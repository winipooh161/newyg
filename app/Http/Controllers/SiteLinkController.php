<?php

namespace App\Http\Controllers;

use App\Models\SiteLink;
use Illuminate\Http\Request;

class SiteLinkController extends Controller
{
    /**
     * Отображение страницы со ссылками
     */
    public function index()
    {
        $siteLinks = SiteLink::all();
        $meta_title = 'Управление ссылками сайта';
        $meta_description = 'Страница управления ссылками и контактами сайта';
        $meta_keywords = 'ссылки, контакты, социальные сети, телефон, email';
        $meta_author = 'Администратор';
        
        return view('admin.site-links', compact('siteLinks', 'meta_title', 'meta_description', 'meta_keywords', 'meta_author'));
    }

    /**
     * Обновление ссылок
     */
    public function update(Request $request)
    {
        foreach ($request->links as $id => $value) {
            SiteLink::findOrFail($id)->update(['value' => $value]);
        }

        return redirect()->route('admin.site-links')->with('success', 'Ссылки успешно обновлены');
    }
}

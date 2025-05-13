<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    // Метод сохранения отзыва (доступен всем)
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'comment' => 'required|string',
        ]);

        // По умолчанию отзыв не одобрен администратором
        Feedback::create(array_merge($data, ['approved' => false]));

        return back()->with('message', 'Ваш отзыв отправлен и ожидает модерацию');
    }

    // Список отзывов для модерации (доступ только для admin)
    public function index()
    {
        $feedbacks = Feedback::orderBy('created_at', 'desc')->get();
        $meta_title       = 'ЮГСТИЛЬ - Отзывы для модерации';
        $meta_description = 'Отметки отзывов для модерации в админке';
        $meta_keywords    = 'отзывы, модерация';
        $meta_author      = 'Название сайта';
        return view('admin.feedback', compact('feedbacks', 'meta_title', 'meta_description', 'meta_keywords', 'meta_author'));
    }

    // Удаление отзыва (админ)
    public function destroy($id)
    {
        Feedback::findOrFail($id)->delete();
        return back()->with('message', 'Отзыв удалён');
    }

    // Одобрение отзыва (админ)
    public function approve($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->update(['approved' => true]);
        return back()->with('message', 'Отзыв одобрен');
    }
    
    // Отмена одобрения отзыва (админ)
    public function disapprove($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->update(['approved' => false]);
        return back()->with('message', 'Отзыв отклонен');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Project;
use App\Models\Feedback;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Можно добавить статистику для дашборда
        $usersCount = User::count();
        $projectsCount = Project::count();
        
        // Если есть модель Feedback для отзывов
        $feedbackCount = class_exists('App\Models\Feedback') ? Feedback::count() : 0;
        $meta_title       = 'ЮГСТИЛЬ - Админ панель - Статистика';
        $meta_description = 'Административная панель. Статистика сайта.';
        $meta_keywords    = 'админ, статистика, пользователи, проекты';
        $meta_author      = 'Название сайта';

        return view('admin.dashboard', compact('usersCount', 'projectsCount', 'feedbackCount', 'meta_title', 'meta_description', 'meta_keywords', 'meta_author'));
    }

    /**
     * Show the projects management page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function projects()
    {
        $projects = Project::orderBy('id', 'desc')->get();
        $meta_title       = 'Управление проектами';
        $meta_description = 'Управление проектами админки';
        $meta_keywords    = 'админ, проекты, управление';
        $meta_author      = 'Название сайта';

        return view('admin.projects', compact('projects', 'meta_title', 'meta_description', 'meta_keywords', 'meta_author'));
    }

    public function createProject(Request $request)
    {
        $meta_title       = 'Создание/Редактирование проекта';
        $meta_description = 'Создание/редактирование проекта';
        $meta_keywords    = 'проект, создание, редактирование, админ';
        $meta_author      = 'Название сайта';

        // Проверяем, если есть параметр edit, значит это редактирование
        if ($request->has('edit')) {
            $project = Project::findOrFail($request->edit);
            return view('admin.projects.create', compact('project', 'meta_title', 'meta_description', 'meta_keywords', 'meta_author'));
        }
        
        // Если нет параметра edit, значит это создание нового проекта
        return view('admin.projects.create', compact('meta_title', 'meta_description', 'meta_keywords', 'meta_author'));
    }

    public function storeProject(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'area' => 'nullable|string|max:100',
            'time' => 'nullable|string|max:100',
            'price' => 'nullable|string|max:100',
            'content' => 'nullable|string',
            'project_video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:307200', // 300MB максимум
        ]);

        // Генерация slug, если не указан
        $slug = $request->slug ? $request->slug : Str::slug($request->title);
        
        // Обработка загрузки основного изображения
        $imagePath = $request->file('image')->store('projects/images', 'public');
        
        // Обработка загрузки видео
        $videoPath = null;
        if ($request->hasFile('project_video')) {
            $videoPath = 'storage/' . $request->file('project_video')->store('projects/videos', 'public');
        }
        
        // Установка значений по умолчанию для NULL полей
        $area = $request->area ?: '0 м²';
        $time = $request->time ?: 'Не указано';
        $price = $request->price ?: 'По запросу';
        $content = $request->content ?: '';
        
        // Создание проекта
        $project = Project::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => 'storage/' . $imagePath,
            'area' => $area,
            'time' => $time,
            'price' => $price,
            'content' => $content,
            'video_path' => $videoPath,
            'slug' => $slug,
        ]);
        
        // Обработка загрузки галереи
        if ($request->hasFile('gallery')) {
            // Создаем директорию для галереи проекта
            $galleryPath = 'public/gallery/' . $project->id;
            if (!Storage::exists($galleryPath)) {
                Storage::makeDirectory($galleryPath);
            }
            
            foreach ($request->file('gallery') as $image) {
                // Сохраняем изображение в папку галереи проекта
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::putFileAs($galleryPath, $image, $filename);
            }
        }
        
        return redirect()->route('admin.projects')->with('success', 'Проект успешно создан');
    }

    public function updateProject(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'area' => 'nullable|string|max:100',
            'time' => 'nullable|string|max:100',
            'price' => 'nullable|string|max:100',
            'content' => 'nullable|string',
            'project_video' => 'nullable|file|mimes:mp4,mov,avi,wmv|max:307200', // 300MB максимум
        ]);
        
        // Генерация slug, если не указан
        $slug = $request->slug ? $request->slug : Str::slug($request->title);
        
        // Обработка загрузки изображения
        $imagePath = $project->image;
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($project->image && file_exists(public_path($project->image))) {
                unlink(public_path($project->image));
            }
            
            $imagePath = 'storage/' . $request->file('image')->store('projects/images', 'public');
        }
        
        // Обработка загрузки видео
        $videoPath = $project->video_path;
        if ($request->hasFile('project_video')) {
            // Удаляем старое видео
            if ($project->video_path && file_exists(public_path($project->video_path))) {
                unlink(public_path($project->video_path));
            }
            
            $videoPath = 'storage/' . $request->file('project_video')->store('projects/videos', 'public');
        }
        
        // Установка значений по умолчанию для NULL полей
        $area = $request->area ?: ($project->area ?: '0 м²');
        $time = $request->time ?: ($project->time ?: 'Не указано');
        $price = $request->price ?: ($project->price ?: 'По запросу');
        $content = $request->content !== null ? $request->content : $project->content;
        
        // Обновление проекта
        $project->update([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
            'area'        => $area,
            'time'        => $time,
            'price'       => $price,
            'content'     => $content,
            'slug'        => $slug,
            'video_path'  => $videoPath,
        ]);
        
        // Обработка удаления изображений из галереи:
        $existingFiles = $request->input('existing_gallery', []);
        $galleryPath = 'public/gallery/' . $project->id;
        if (Storage::exists($galleryPath)) {
            $files = Storage::files($galleryPath);
            foreach ($files as $file) {
                $filename = basename($file);
                if (!in_array($filename, $existingFiles)) {
                    Storage::delete($file);
                }
            }
        }
        
        // Обработка галереи: добавление новых изображений
        if ($request->hasFile('gallery')) {
            $galleryPath = 'public/gallery/' . $project->id;
            if (!Storage::exists($galleryPath)) {
                Storage::makeDirectory($galleryPath);
            }
            foreach ($request->file('gallery') as $image) {
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                Storage::putFileAs($galleryPath, $image, $filename);
            }
        }
        
        return redirect()->route('admin.projects')->with('success', 'Проект успешно обновлен');
    }

    public function destroyProject($id)
    {
        $project = Project::findOrFail($id);
        
        // Удаляем основное изображение, если существует
        if ($project->image && file_exists(public_path($project->image))) {
            unlink(public_path($project->image));
        }
        
        // Удаляем видео проекта, если существует
        if ($project->video_path && file_exists(public_path($project->video_path))) {
            unlink(public_path($project->video_path));
        }
        
        // Удаляем папку галереи проекта, если существует
        $galleryPath = 'public/gallery/' . $project->id;
        if (Storage::exists($galleryPath)) {
            Storage::deleteDirectory($galleryPath);
        }
        
        // Удаляем проект из БД
        $project->delete();
        
        return redirect()->route('admin.projects')->with('success', 'Проект успешно удалён');
    }
    
    // Новый метод для удаления видео проекта через AJAX
    public function deleteProjectVideo($id)
    {
        $project = Project::findOrFail($id);
        
        // Удаляем видео, если существует
        if ($project->video_path && file_exists(public_path($project->video_path))) {
            unlink(public_path($project->video_path));
        }
        
        $project->update(['video_path' => null]);
        
        return response()->json(['success' => true, 'message' => 'Видео успешно удалено']);
    }

    // Метод для создания пользователя через AJAX
    public function storeUser(Request $request)
    {
        try {
            $data = $request->validate([
                'name'     => 'required|string|max:255',
                'email'    => 'required|email|max:255|unique:users',
                'phone'    => 'required|string|max:20',
                'password' => 'required|string|min:6',
                'role'     => 'required|in:user,admin',
            ]);

            $data['password'] = bcrypt($data['password']);
            // Добавляем поле status – убедитесь, что оно существует и добавлено в fillable модели User
            $data['status'] = $data['role'];

            User::create($data);

            return response()->json(['message' => 'Пользователь успешно создан!'], 200);
        } catch (\Exception $e) {
            \Log::error('Ошибка при создании пользователя: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка при создании пользователя. Проверьте логи за деталями.'], 500);
        }
    }

    public function destroyUser(User $user)
    {
        try {
            $user->delete();
            return response()->json(['message' => 'Пользователь успешно удален!'], 200);
        } catch (\Exception $e) {
            \Log::error('Ошибка при удалении пользователя: ' . $e->getMessage());
            return response()->json(['message' => 'Ошибка при удалении пользователя. Проверьте логи за деталями.'], 500);
        }
    }
}

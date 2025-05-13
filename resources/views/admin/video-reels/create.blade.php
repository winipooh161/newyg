@extends('layouts.adm')

@section('content')
<div class="admin-container">
    <h1 class="admin-title">Добавить новый видео рилс</h1>
    
    <div class="admin-card">
        <form action="{{ route('admin.video-reels.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="admin-form-group mb-3">
                <label class="admin-label" for="title">Название</label>
                <input type="text" name="title" id="title" class="admin-input @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="admin-form-group mb-3">
                <label class="admin-label" for="video">Видео файл</label>
                <input type="file" name="video" id="video" class="admin-input file-input @error('video') is-invalid @enderror" accept="video/mp4,video/mov,video/ogg,video/webm" required>
                <small class="text-muted">Поддерживаемые форматы: MP4, MOV, OGG, WEBM. Максимальный размер: 100MB</small>
                @error('video')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="admin-form-group mb-3">
                <label class="admin-label" for="thumbnail">Постер для видео (опционально)</label>
                <input type="file" name="thumbnail" id="thumbnail" class="admin-input file-input @error('thumbnail') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg">
                <small class="text-muted">Загрузите изображение, которое будет показано до начала проигрывания видео. Рекомендуемое соотношение сторон 9:16</small>
                @error('thumbnail')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <div id="thumbnail-preview" class="mt-2" style="display: none;">
                    <img id="thumbnail-image" src="" alt="Предпросмотр постера" style="max-height: 200px; max-width: 100%; border-radius: 4px;">
                </div>
            </div>
            
            <div class="admin-form-group mb-3">
                <label class="admin-label" for="description">Описание (опционально)</label>
                <textarea name="description" id="description" rows="3" class="admin-textarea @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="admin-form-group mb-3">
                <label class="admin-label" for="order">Порядок отображения</label>
                <input type="number" name="order" id="order" class="admin-input @error('order') is-invalid @enderror" value="{{ old('order', 0) }}">
                @error('order')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="admin-form-group mb-3">
                <div class="form-check">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{ old('is_active') ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">Активен</label>
                </div>
            </div>
            
            <div class="video-preview-container mt-3 mb-3" style="display: none;">
                <h4>Предпросмотр видео</h4>
                <video id="video-preview" controls style="max-width: 100%; max-height: 400px;"></video>
            </div>
            
            <div class="flex-end">
                <a href="{{ route('admin.video-reels.index') }}" class="admin-btn admin-btn--secondary mr-2">Отмена</a>
                <button type="submit" class="admin-btn admin-btn--success">Сохранить</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('video').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const videoPreview = document.getElementById('video-preview');
            const videoUrl = URL.createObjectURL(file);
            videoPreview.src = videoUrl;
            document.querySelector('.video-preview-container').style.display = 'block';
        }
    });
    
    document.getElementById('thumbnail').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const thumbnailPreview = document.getElementById('thumbnail-image');
            const thumbnailUrl = URL.createObjectURL(file);
            thumbnailPreview.src = thumbnailUrl;
            document.getElementById('thumbnail-preview').style.display = 'block';
        }
    });
</script>
@endsection

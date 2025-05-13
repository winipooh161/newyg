@extends('layouts.adm')

@section('content')
<div class="admin-container">
    <h1 class="admin-title wow fadeInDown">{{ isset($project) ? 'Редактирование проекта' : 'Создание проекта' }}</h1>
    @if(session('success'))
        <div class="admin-alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="admin-alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="admin-card wow fadeInUp">
        <div class="header-section flex-between">
            <h5>{{ isset($project) ? 'Редактирование проекта: ' . $project->title : 'Новый проект' }}</h5>
            <a href="{{ route('admin.projects') }}" class="admin-btn admin-btn--link">
                <i class="fas fa-arrow-left"></i> Вернуться к списку
            </a>
        </div>
        <form action="{{ isset($project) ? route('admin.projects.update', $project->id) : route('admin.projects.store') }}" method="POST" enctype="multipart/form-data" id="projectForm">
            @csrf
            @if(isset($project))
                @method('PUT')
            @endif

            <!-- Основные данные проекта -->
            <div class="custom-row">
                <div class="custom-col-8">
                    <div class="admin-form-group">
                        <label for="title" class="admin-label">Название проекта <span class="custom-required">*</span></label>
                        <input type="text" id="title" name="title" class="admin-input" value="{{ old('title', $project->title ?? '') }}" required>
                    </div>
                    <div class="admin-form-group">
                        <label for="description" class="admin-label">Краткое описание <span class="custom-required">*</span></label>
                        <textarea id="description" name="description" rows="3" class="admin-textarea" required>{{ old('description', $project->description ?? '') }}</textarea>
                    </div>
                    <div class="row-form-group">
                        <div class="col-md-4 admin-form-group">
                            <label for="area" class="admin-label">Площадь объекта</label>
                            <input type="text" id="area" name="area" class="admin-input" value="{{ old('area', $project->area ?? '0 м²') }}">
                        </div>
                        <div class="col-md-5 admin-form-group">
                            <label for="time" class="admin-label">Сроки выполнения</label>
                            <input type="text" id="time" name="time" class="admin-input" value="{{ old('time', $project->time ?? 'Не указано') }}">
                        </div>
                        <div class="col-md-4 admin-form-group">
                            <label for="price" class="admin-label">Стоимость</label>
                            <input type="text" id="price" name="price" class="admin-input" value="{{ old('price', $project->price ?? 'По запросу') }}">
                        </div>
                    </div>
                    <div class="admin-form-group">
                        <label for="content" class="admin-label">Полное описание</label>
                        <textarea id="content" name="content" rows="10" class="admin-textarea">{{ old('content', $project->content ?? '') }}</textarea>
                    </div>
                </div>
                <div class="custom-col-4">
                    <div class="admin-form-group">
                        <label for="image" class="admin-label">Основное изображение <span class="custom-required">*</span></label>
                        <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="custom-input-file" {{ isset($project) ? '' : 'required' }}>
                        <small class="form-text text-muted">Поддерживаемые форматы: JPEG, PNG, JPG, GIF, WEBP. Максимальный размер: 2MB</small>
                        @if(isset($project) && $project->image)
                            <div class="custom-image-current">
                                <p class="custom-text-muted">Текущее изображение:</p>
                                <div class="custom-image-wrapper">
                                    <img src="{{ asset($project->image) }}" alt="{{ $project->title }}">
                                </div>
                            </div>
                        @endif
                    </div>
                    <div id="imagePreviewContainer" class="custom-image-preview" style="display:none;">
                        <p class="custom-text-muted">Предпросмотр:</p>
                        <img id="imagePreview" src="#" alt="Предпросмотр">
                    </div>
                    
                    <!-- Добавляем поле для видео проекта -->
                    <div class="admin-form-group mt-4">
                        <label for="project_video" class="admin-label">Видео проекта</label>
                        <input type="file" id="project_video" name="project_video" accept="video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv" class="custom-input-file">
                        <small class="form-text text-muted">Поддерживаемые форматы: MP4, MOV, AVI, WMV. Максимальный размер: 50MB</small>>
                        
                        @if(isset($project) && $project->video_path)
                            <div class="custom-video-current mt-3">
                                <p class="custom-text-muted">Текущее видео:</p>
                                <div class="custom-video-wrapper">
                                    <video width="100%" height="auto" controls>
                                        <source src="{{ asset($project->video_path) }}" type="video/mp4">
                                        Ваш браузер не поддерживает видео.
                                    </video>
                                </div>
                                <button type="button" class="admin-btn admin-btn--danger admin-btn--small mt-2" 
                                        onclick="deleteProjectVideo({{ $project->id }})">
                                    Удалить видео
                                </button>
                            </div>
                        @endif
                    </div>
                    <div id="videoPreviewContainer" class="custom-video-preview mt-3" style="display:none;">
                        <p class="custom-text-muted">Предпросмотр видео:</p>
                        <video id="videoPreview" width="100%" height="auto" controls></video>
                    </div>
                </div>
            </div>
            <div class="custom-col-12">
                <div class="admin-form-group">
                    <h5>Галерея изображений</h5>
                    <p class="custom-text-muted">Загрузите дополнительные изображения для проекта</p>
                    
                    <label for="gallery" class="admin-label">Добавить изображения в галерею</label>
                    <input type="file" id="gallery" name="gallery[]" accept="image/*" multiple class="custom-input-file">
                    
                    <div id="galleryPreviewContainer" class="custom-gallery-preview row"></div>
                    
                    @if(isset($project) && !empty($galleryImages = $project->getGalleryImages()))
                        <div class="custom-existing-gallery">
                            <h6>Существующие изображения</h6>
                            <div class="row">
                                @foreach($galleryImages as $image)
                                    <div class="col-md-3 custom-gallery-item">
                                        <div class="custom-image-wrapper">
                                            <img src="{{ asset($image) }}" alt="Gallery image">
                                            <button type="button" class="admin-btn admin-btn--danger custom-delete-gallery" data-image="{{ basename($image) }}">
                                                <i class="fas fa-times"></i>
                                            </button>
                                            <input type="hidden" name="existing_gallery[]" value="{{ basename($image) }}">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex-end" style="gap:15px; margin-top:20px;">
                <button type="button" class="admin-btn admin-btn--link" onclick="window.location.href='{{ route('admin.projects') }}'">
                    <!-- Arrow left SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 16 16">
                      <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 00-.708 0L4.5 7.793l6.146 6.147a.5.5 0 00.708-.708L5.707 8.5l5.647-5.646a.5.5 0 000-.708z" clip-rule="evenodd"/>
                    </svg>
                    <span class="btn-text"> Отмена</span>
                </button>
                <button type="submit" class="admin-btn">
                    <!-- Save icon SVG -->
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 16 16">
                      <path d="M8 0L3 5v11h10V5L8 0zM4.5 6h7a.5.5 0 01.5.5v8a.5.5 0 01-.5.5h-7a.5.5 0 01-.5-.5v-8a.5.5 0 01.5-.5z"/>
                    </svg>
                    <span class="btn-text"> {{ isset($project) ? 'Обновить проект' : 'Создать проект' }}</span>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
<style>
    div#imagePreviewContainer img {
    width: 250px;
}
</style>
<!-- Подключение jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
$(document).ready(function() {
    // Функция транслитерации для генерации slug
    function slugify(text) {
        const from = 'абвгдеёжзийклмнопрстуфхцчшщъыьэюя';
        const to = 'abvgdeejzijklmnoprstufhzcssyye';
        text = text.toLowerCase().trim();
        let result = '';
        for (let i = 0; i < text.length; i++) {
            const char = text[i];
            const index = from.indexOf(char);
            result += index >= 0 ? to[index] : char;
        }
        return result
            .replace(/[^a-z0-9-]/g, '-') // Заменяем не-алфавитные и не-цифровые символы на дефис
            .replace(/-+/g, '-')         // Заменяем множественные дефисы на одиночный
            .replace(/^-|-$/g, '');      // Удаляем дефисы в начале и конце
    }
    // Генерация slug из заголовка
    $('#generateSlug').click(function() {
        const titleValue = $('#title').val();
        if (titleValue) {
            $('#slug').val(slugify(titleValue));
        } else {
            alert('Сначала введите название проекта');
        }
    });
    // Предпросмотр основного изображения
    $('#image').change(function() {
        if (this.files && this.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').attr('src', e.target.result);
                $('#imagePreviewContainer').show(); // заменено removeClass('d-none') на show()
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
    // Предпросмотр изображений галереи
    $('#gallery').change(function() {
        $('#galleryPreviewContainer').empty();
        
        if (this.files) {
            for (let i = 0; i < this.files.length; i++) {
                const file = this.files[i];
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const previewCol = $('<div class="col-md-3 custom-gallery-item"></div>');
                    const previewImg = $('<img class="img-thumbnail" style="width:100%; height:150px; object-fit:cover;">');
                    
                    previewImg.attr('src', e.target.result);
                    previewCol.append(previewImg);
                    $('#galleryPreviewContainer').append(previewCol);
                }
                
                reader.readAsDataURL(file);
            }
        }
    });
    // Обработчик удаления изображения из галереи с делегированием событий
    $(document).on('click', '.custom-delete-gallery', function(e) {
        e.preventDefault();
        $(this).closest('.custom-gallery-item').remove();
    });
    
    // Проверка формы перед отправкой
    $('#projectForm').submit(function(e) {
        // Получение содержимого из TinyMCE
        if (tinymce.get('content')) {
            const contentValue = tinymce.get('content').getContent();
            $('#content').val(contentValue);
        }
    });
    // Маска для поля "Площадь объекта" - добавляет суффикс " м²" при потере фокуса, если его нет
    $('#area').on('blur', function() {
        let val = $(this).val().trim();
        if(val && !val.endsWith(' м²')) {
            $(this).val(val + ' м²');
        }
    });
    // Маска для поля "Стоимость" - добавляет префикс "р " при потере фокуса, если его нет
    $('#price').on('blur', function() {
        let val = $(this).val().trim();
        if(val && !val.startsWith('р ')) {
            $(this).val('р ' + val);
        }
    });
    // Строгая маска для поля "Площадь объекта": разрешаем только цифры и точку, затем добавляем суффикс " м²"
    $('#area').on('input', function() {
        let numeric = $(this).val().replace(/[^\d\.]/g, "");
        $(this).val(numeric + " м²");
    });
    
    // Строгая маска для поля "Стоимость": разрешаем только цифры, затем добавляем префикс "р " в начале
    $('#price').on('input', function() {
        let numeric = $(this).val().replace(/[^\d]/g, "");
        $(this).val("р " + numeric);
    });
    
    // Предпросмотр видео
    $('#project_video').change(function() {
        if (this.files && this.files[0]) {
            const file = this.files[0];
            
            // Проверка размера файла (300MB в байтах)
            if(file.size > 314572800) {
                alert('Файл слишком большой. Максимальный размер: 300MB');
                this.value = ''; // Очистка поля выбора файла
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const video = document.getElementById('videoPreview');
                video.src = URL.createObjectURL(file);
                $('#videoPreviewContainer').show();
                
                // Освобождаем память, когда видео загрузилось
                video.onloadeddata = function() {
                    URL.revokeObjectURL(video.src);
                };
            }
            reader.readAsDataURL(file);
        }
    });
});

document.addEventListener("DOMContentLoaded", function() {
    var areaField = document.getElementById("area");
    if (areaField) {
        areaField.addEventListener("blur", function() {
            var val = this.value.trim();
            if (val && !val.endsWith(" м²")) {
                this.value = val + " м²";
            }
        });
    }
    
    var priceField = document.getElementById("price");
    if (priceField) {
        priceField.addEventListener("blur", function() {
            var val = this.value.trim();
            if (val && !val.startsWith("р ")) {
                this.value = "р " + val;
            }
        });
    }
});

// Функция для удаления видео проекта
function deleteProjectVideo(projectId) {
    if (confirm('Вы уверены, что хотите удалить видео этого проекта?')) {
        $.ajax({
            url: '/admin/projects/' + projectId + '/delete-video',
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                $('.custom-video-current').fadeOut(300, function() {
                    $(this).remove();
                });
                alert('Видео успешно удалено');
            },
            error: function(xhr) {
                alert('Произошла ошибка при удалении видео');
                console.error(xhr.responseText);
            }
        });
    }
}
</script>



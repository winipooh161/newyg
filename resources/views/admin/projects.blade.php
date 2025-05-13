@extends('layouts.adm')

@section('content')
<div class="admin-container">
    <h1 class="admin-title wow fadeInDown">Управление проектами</h1>
    
    @if(session('success'))
        <div class="admin-alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="admin-card wow fadeInUp">
        <div class="header-section flex-between">
            <h5>Список проектов</h5>
            <a href="{{ route('admin.projects.create') }}" class="admin-btn">Добавить проект</a>
        </div>
        @if(isset($projects) && count($projects) > 0)
            <table class="admin-table" id="projectsTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Изображение</th>
                        <th>Название</th>
                        <th>Описание</th>
                        <th>Площадь</th>
                        <th>Сроки</th>
                        <th>Цена</th>
                        <th>Видео</th>
                        <th>Slug</th>
                        <th>Дата создания</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>
                            <img src="{{ asset($project->image) ?: asset('img/placeholder.jpg') }}" alt="{{ $project->title }}" class="project-thumbnail">
                        </td>
                        <td>{{ $project->title }}</td>
                        <td class="project-description">{{ Str::limit($project->description, 50) }}</td>
                        <td>{{ $project->area }}</td>
                        <td>{{ $project->time }}</td>
                        <td>{{ $project->price }}</td>
                        <td>
                            @if($project->hasVideo())
                                <span class="badge bg-success">
                                    <i class="fas fa-video"></i> Есть
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-times"></i> Нет
                                </span>
                            @endif
                        </td>
                        <td>{{ $project->slug }}</td>
                        <td>{{ $project->created_at->format('d.m.Y') }}</td>
                        <td class="actions">
                            <div class="btn-group">
                                <a href="{{ route('admin.projects.create') }}?edit={{ $project->id }}" class="admin-btn admin-btn--small edit-btn">
                                    <!-- Edit icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 16 16">
                                      <path d="M15.502 1.94a.5.5 0 00-.706 0L10.5 6.236l.707.707 4.296-4.296a.5.5 0 000-.707z"/>
                                      <path fill-rule="#fff" d="M6.854 7.146L2 12v1h1l4.854-4.854-.854-.854z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="btn-text"> Редактировать</span>
                                </a>
                                <button class="admin-btn admin-btn--small admin-btn--info content-view-btn" 
                                    data-id="{{ $project->id }}"
                                    data-title="{{ $project->title }}"
                                    data-content="{{ $project->content }}">
                                    <!-- Eye/view icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 16 16">
                                      <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                                      <path d="M8 5.5A2.5 2.5 0 108 10.5 2.5 2.5 0 008 5.5z"/>
                                    </svg>
                                    <span class="btn-text"> Просмотр</span>
                                </button>
                                <button class="admin-btn admin-btn--small admin-btn--danger delete-project-btn" 
                                    data-id="{{ $project->id }}"
                                    data-title="{{ $project->title }}">
                                    <!-- Trash icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 16 16">
                                      <path d="M5.5 5.5a.5.5 0 01.5.5v6a.5.5 0 01-1 0v-6a.5.5 0 01.5-.5zm5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0v-6a.5.5 0 01.5-.5z"/>
                                      <path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4H2.5a1 1 0 010-2h3a1 1 0 01.9-.546h2.2a1 1 0 01.9.546h3a1 1 0 011 1zM4.118 4l.82 9.576A1 1 0 005.93 15h4.14a1 0 00.992-.424L11.882 4H4.118z" clip-rule="evenodd"/>
                                      <path fill-rule="evenodd" d="M5.5 1a1 1 0 00-1 1v1h6V2a1 1 0 00-1-1h-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="btn-text"> Удалить</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="admin-alert-info">
                Проекты не найдены. <a href="{{ route('admin.projects.create') }}" class="admin-link">Добавьте первый проект</a>.
            </div>
        @endif
    </div>
</div>

<!-- Изменён блок модального окна для описания проекта -->
<div class="custom-modal" id="descriptionModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5>Описание проекта: <span id="projectTitle"></span></h5>
            <span class="custom-modal-close">&times;</span>
        </div>
        <div class="custom-modal-body">
            <p id="fullDescription"></p>
        </div>
        <div class="custom-modal-footer">
          
        </div>
    </div>
</div>

<!-- Изменён блок модального окна для галереи проекта -->
<div class="custom-modal" id="contentModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5>Галерея проекта: <span id="contentProjectTitle"></span></h5>
            <span class="custom-modal-close">&times;</span>
        </div> 
        <div class="custom-modal-body">
            <div id="galleryContent" class="gallery-collage">
                <!-- Здесь будут показаны изображения из: storage/app/public/gallery/{idproject}/.* -->
                <!-- Пример вывода изображений: -->
                <!-- <img src="/storage/gallery/123/image1.jpg" alt="Изображение проекта"> -->
            </div>
        </div>
        <div class="custom-modal-footer">
         
        </div>
    </div>
</div>

<!-- Изменён блок модального окна подтверждения удаления проекта -->
<div class="custom-modal" id="deleteConfirmModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5>Подтверждение удаления</h5>
            <span class="custom-modal-close">&times;</span>
        </div>
        <div class="custom-modal-body">
            <p>Вы действительно хотите удалить проект <strong id="deleteProjectTitle"></strong>?</p>
            <p class="text-danger">Это действие необратимо.</p>
        </div>
        <div class="custom-modal-footer">
           
            <form id="deleteProjectForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn danger-btn">Удалить</button>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Инициализация таблицы с проектами
        const projectsTable = $('#projectsTable').length ? $('#projectsTable').DataTable({
            responsive: true,
            dom: 'lfrtip', // отображает элемент lengthMenu
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/ru.json'
            },
            columnDefs: [
                { responsivePriority: 1, targets: 0 },
                { responsivePriority: 2, targets: 2 },
                { responsivePriority: 3, targets: -1 },
                { orderable: false, targets: [1, -1] }
            ],
            order: [[0, 'desc']],
            pageLength: 10,
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
            drawCallback: function() {
                // Переинициализируем обработчики событий после перерисовки таблицы
                initModalHandlers();
            }
        }) : null;
        
        // Функция для плавного показа уведомлений
        function showNotification(message, type = 'success') {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const icon = type === 'success' ? 
                '<i class="fas fa-check-circle me-2"></i>' : 
                '<i class="fas fa-exclamation-circle me-2"></i>';
                
            const alert = $(`
                <div class="alert ${alertClass} alert-dismissible fade show shadow-sm" role="alert" style="display:none; position:fixed; top:70px; right:20px; z-index:9999; min-width:300px;">
                    ${icon} ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `);
            
            $('body').append(alert);
            alert.slideDown(300).delay(4000).slideUp(300, function() {
                $(this).remove();
            });
        }
        
        // Функция для показа индикатора загрузки
        function showLoading() {
            const spinner = $(`
                <div class="loading-overlay" style="position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(0,0,0,0.5); z-index:9999; display:flex; align-items:center; justify-content:center;">
                    <div class="spinner-border text-light" role="status" style="width:3rem; height:3rem;">
                        <span class="visually-hidden">Загрузка...</span>
                    </div>
                </div>
            `);
            $('body').append(spinner);
            return spinner;
        }
        
        // Функция инициализации обработчиков для модальных окон
        function initModalHandlers() {
            // Обработка клика по описанию проекта
            $('.project-description').off('click').on('click', function() {
                const description = $(this).data('full-description') || $(this).text().trim();
                const title = $(this).closest('tr').find('td:eq(2)').text().trim();
                
                // Плавные анимации для содержимого
                $('#projectTitle').text(title);
                $('#fullDescription').hide().text(description).fadeIn(300);
                
                showModal('descriptionModal');
            });
            
            // Подготовка данных для полного описания при загрузке
            $('.project-description').each(function() {
                const fullText = $(this).text().trim();
                $(this).data('full-description', fullText);
                
                // Визуальный индикатор того, что элемент кликабелен
                $(this).css('cursor', 'pointer')
                    .attr('title', 'Нажмите, чтобы просмотреть полное описание')
                    .append('<i class="fas fa-expand-alt ms-2 text-muted" style="font-size:0.8em;"></i>');
            });
            
            // Обработка клика по кнопке просмотра контента
            $('.content-view-btn').off('click').on('click', function() {
                const projectId = $(this).data('id');
                const projectTitle = $(this).data('title');
                $('#contentProjectTitle').text(projectTitle);
                $('#galleryContent').empty(); // очистка контейнера для галереи
                
                // Формируем URL с использованием laravel route helper
                var url = "{{ route('admin.projects.gallery', ['id' => ':id']) }}";
                url = url.replace(':id', projectId);
                
                // AJAX-запрос для получения изображений галереи проекта
                $.ajax({
                    url: url,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if(response.length) {
                            response.forEach(function(imgUrl) {
                                $('#galleryContent').append(
                                    '<img src="' + imgUrl + '" alt="Изображение проекта" style="margin:5px; max-width:calc(33% - 10px);">'
                                );
                            });
                        } else {
                            $('#galleryContent').html('<div class="alert alert-info">Изображения отсутствуют</div>');
                        }
                        $('#galleryContent').fadeIn(300);
                    },
                    error: function() {
                        $('#galleryContent').html('<div class="alert alert-danger">Ошибка загрузки галереи</div>');
                        $('#galleryContent').fadeIn(300);
                    }
                });
                
                showModal('contentModal');
            });
            
            // Обработка клика по кнопке удаления
            $('.delete-project-btn').off('click').on('click', function() {
                const projectId = $(this).data('id');
                const projectTitle = $(this).data('title');
                
                // Настройка модального окна удаления
                $('#deleteProjectTitle').text(projectTitle).addClass('text-danger');
                $('#deleteProjectForm').attr('action', `/admin/projects/${projectId}`);
                
                // Анимация предупреждающего текста
                $('#deleteConfirmModal .text-danger').hide().fadeIn(500);
                
                showModal('deleteConfirmModal');
                
                // Фокус на кнопку "Отмена" для предотвращения случайного удаления
                setTimeout(() => {
                    $('#deleteConfirmModal button.btn-secondary').focus();
                }, 300);
            });
            
            // Эффекты при наведении на строки таблицы
            $('#projectsTable tbody tr').hover(
                function() {
                    $(this).addClass('row-highlight');
                },
                function() {
                    $(this).removeClass('row-highlight');
                }
            );
        }
        
        // Инициализация обработчиков при первой загрузке страницы
        initModalHandlers();
        
        // Обработчик формы удаления проекта
        $('#deleteProjectForm').submit(function(e) {
            e.preventDefault();
            
            const form = $(this);
            const url = form.attr('action');
            const projectTitle = $('#deleteProjectTitle').text();
            
            // Показываем индикатор загрузки
            const loader = showLoading();
            
            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                success: function(response) {
                    // Скрываем модальное окно
                    hideModal('deleteConfirmModal');
                    
                    // Удаляем индикатор загрузки
                    loader.remove();
                    
                    // Показываем уведомление об успехе
                    showNotification(`Проект "${projectTitle}" успешно удален.`, 'success');
                    
                    // Находим и удаляем строку из таблицы с анимацией
                    const projectId = url.split('/').pop();
                    const row = $('#projectsTable').find(`tr[data-id="${projectId}"]`);
                    
                    if (row.length) {
                        row.addClass('bg-danger text-white').fadeOut(500, function() {
                            if (projectsTable) {
                                projectsTable.row($(this)).remove().draw();
                            } else {
                                $(this).remove();
                            }
                        });
                    } else {
                        // Если строка не найдена, просто перезагружаем страницу
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    // Скрываем модальное окно
                    hideModal('deleteConfirmModal');
                    
                    // Удаляем индикатор загрузки
                    loader.remove();
                    
                    // Показываем уведомление об ошибке с деталями
                    let errorMessage = 'Произошла ошибка при удалении проекта.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ` ${xhr.responseJSON.message}`;
                    }
                    
                    showNotification(errorMessage, 'error');
                }
            });
        });
        
        // Добавление атрибута data-id ко всем строкам таблицы
        $('#projectsTable tbody tr').each(function() {
            const projectId = $(this).find('td:first').text().trim();
            $(this).attr('data-id', projectId);
        });
        
        // Инициализация всплывающих подсказок
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>

<script>
    // Функции открытия и закрытия кастомных модалок
    function showModal(modalId) {
        // Устанавливаем display: flex и затем запускаем fadeIn
        $('#' + modalId).css('display', 'flex').hide().fadeIn(200);
    }
    function hideModal(modalId) {
        // При закрытии после fadeOut сбрасываем display в none
        $('#' + modalId).fadeOut(200, function() {
            $(this).css('display','none');
        });
    }

    $(document).ready(function() {
        // Инициализация обработчиков для модальных окон открытия и закрытия кастомных модалок
        function initModalHandlers() {
            // Открытие модального окна описания
            $('.project-description').off('click').on('click', function() {
                var desc = $(this).data('full-description') || $(this).text().trim();
                var title = $(this).closest('tr').find('td:eq(2)').text().trim();
                $('#projectTitle').text(title);
                $('#fullDescription').hide().text(desc).fadeIn(300);
                showModal('descriptionModal');
            });

            // Визуальный индикатор кликабельного описания
            $('.project-description').each(function() {
                var fullText = $(this).text().trim();
                $(this).data('full-description', fullText)
                    .css('cursor', 'pointer')
                    .attr('title', 'Нажмите, чтобы просмотреть полное описание')
                    .append('<i class="fas fa-expand-alt ms-2 text-muted" style="font-size:0.8em;"></i>');
            });

            // Открытие модального окна галереи проекта
            $('.content-view-btn').off('click').on('click', function() {
                var projectId = $(this).data('id');
                var projectTitle = $(this).data('title');
                $('#contentProjectTitle').text(projectTitle);
                $('#galleryContent').empty().html('<div class="text-center py-5"><div class="spinner-border text-primary" role="status"></div><p class="mt-3">Загрузка изображений...</p></div>');
                
                // Показываем модальное окно с индикатором загрузки
                showModal('contentModal');
                
                // Делаем AJAX-запрос для получения изображений
                $.ajax({
                    url: '/admin/projects/gallery/' + projectId,
                    method: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        console.log('Получены пути к изображениям:', response);
                        
                        $('#galleryContent').empty();
                        
                        if(response && response.length > 0) {
                            // Создаём контейнер с сеткой для изображений
                            var gallery = $('<div class="gallery-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;"></div>');
                            
                            $.each(response, function(index, imgUrl) {
                                gallery.append(
                                    '<div class="gallery-item">' +
                                        '<img src="' + imgUrl + '" alt="Изображение проекта ' + (index+1) + '" ' +
                                        'style="width: 100%; height: auto; object-fit: cover; border-radius: 5px;opacity: 1;">' +        
                                    '</div>'
                                );
                            });
                            
                            $('#galleryContent').append(gallery).hide().fadeIn(300);
                        } else {
                            $('#galleryContent').html('<div class="alert alert-info">Изображения для данного проекта отсутствуют</div>');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Ошибка загрузки галереи:', xhr, status, error);
                        $('#galleryContent').html('<div class="alert alert-danger">Ошибка загрузки галереи. Пожалуйста, проверьте консоль для деталей.</div>');
                    }
                });
            });

            // Открытие модального окна удаления
            $('.delete-project-btn').off('click').on('click', function() {
                var projectId = $(this).data('id');
                var projectTitle = $(this).data('title');
                $('#deleteProjectTitle').text(projectTitle).addClass('text-danger');
                $('#deleteProjectForm').attr('action', '/admin/projects/' + projectId);
                showModal('deleteConfirmModal');
            });

            // Закрытие по кнопке "Закрыть" и по крестику
            $('.custom-modal .close-btn, .custom-modal .custom-modal-close').off('click').on('click', function() {
                $(this).closest('.custom-modal').fadeOut(200);
            });
        }

        // Инициализируем обработчики при загрузке страницы
        initModalHandlers();
        
        // Форма удаления проекта
        $('#deleteProjectForm').submit(function(e) {
            e.preventDefault();
            
            const form = $(this);
            const url = form.attr('action');
            const projectTitle = $('#deleteProjectTitle').text();
            
            // Показываем индикатор загрузки
            const loader = showLoading();
            
            $.ajax({
                type: 'POST',
                url: url,
                data: form.serialize(),
                success: function(response) {
                    // Скрываем модальное окно
                    hideModal('deleteConfirmModal');
                    
                    // Удаляем индикатор загрузки
                    loader.remove();
                    
                    // Показываем уведомление об успехе
                    showNotification(`Проект "${projectTitle}" успешно удален.`, 'success');
                    
                    // Находим и удаляем строку из таблицы с анимацией
                    const projectId = url.split('/').pop();
                    const row = $('#projectsTable').find(`tr[data-id="${projectId}"]`);
                    
                    if (row.length) {
                        row.addClass('bg-danger text-white').fadeOut(500, function() {
                            if (projectsTable) {
                                projectsTable.row($(this)).remove().draw();
                            } else {
                                $(this).remove();
                            }
                        });
                    } else {
                        // Если строка не найдена, просто перезагружаем страницу
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                },
                error: function(xhr) {
                    // Скрываем модальное окно
                    hideModal('deleteConfirmModal');
                    
                    // Удаляем индикатор загрузки
                    loader.remove();
                    
                    // Показываем уведомление об ошибке с деталями
                    let errorMessage = 'Произошла ошибка при удалении проекта.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage += ` ${xhr.responseJSON.message}`;
                    }
                    
                    showNotification(errorMessage, 'error');
                }
            });
        });
        
        // Закрытие модалок по Escape
        $(document).on('keydown', function(e) {
            if(e.key === 'Escape'){
                $('.custom-modal:visible').fadeOut(200);
            }
        });

        // Атрибуты data-id для строк таблицы
        $('#projectsTable tbody tr').each(function() {
            var id = $(this).find('td:first').text().trim();
            $(this).attr('data-id', id);
        });

        // Удаляем DataTables обработчик, если он мешает нашим модалкам
        if ($.fn.dataTable.isDataTable('#projectsTable')) {
            var table = $('#projectsTable').DataTable();
            table.on('draw', function() {
                // Переинициализация после перерисовки таблицы
                initModalHandlers();
            });
        }
    });
</script>
@endsection


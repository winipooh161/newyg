@extends('layouts.adm')

@section('content')
<div class="admin-container">
    <h1 class="admin-title">Управление видео рилсами</h1>
    
    <div class="admin-card">
        <div class="flex-between mb-4">
            <h2 class="section-title">Список видео рилсов</h2>
            <a href="{{ route('admin.video-reels.create') }}" class="admin-btn admin-btn--success">Добавить новый рилс</a>
        </div>
        
        @if(session('success'))
            <div class="alert alert-success mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        <table id="videoReelsTable" class="admin-table display responsive nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Превью</th>
                    <th>Название</th>
                    <th>Статус</th>
                    <th>Порядок</th>
                    <th>Дата создания</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reels as $reel)
                <tr>
                    <td>{{ $reel->id }}</td>
                    <td>
                        @if($reel->thumbnail)
                            <img src="{{ $reel->thumbnail_url }}" alt="{{ $reel->title }}" style="width: 80px; height: auto; border-radius: 4px;">
                        @elseif($reel->video_file)
                            <div style="width: 80px; height: 142px; background: #222; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                <i class="fas fa-video" style="color: #999;"></i>
                            </div>
                        @else
                            <div style="width: 80px; height: 142px; background: #222; display: flex; align-items: center; justify-content: center; border-radius: 4px;">
                                <i class="fas fa-code" style="color: #999;"></i>
                            </div>
                        @endif
                    </td>
                    <td>{{ $reel->title }}</td>
                    <td>
                        <span class="status-badge {{ $reel->is_active ? 'status-active' : 'status-inactive' }}">
                            {{ $reel->is_active ? 'Активен' : 'Неактивен' }}
                        </span>
                    </td>
                    <td>{{ $reel->order }}</td>
                    <td>{{ $reel->created_at->format('d.m.Y H:i') }}</td>
                    <td class="actions">
                        <div class="btn-actions-group">
                            <a href="{{ route('admin.video-reels.edit', $reel->id) }}" class="admin-btn admin-btn--warning btn-sm">
                                <i class="fas fa-edit"></i> Редактировать
                            </a>
                            <button class="admin-btn admin-btn--danger btn-sm delete-btn" 
                                data-id="{{ $reel->id }}" 
                                data-title="{{ $reel->title }}">
                                <i class="fas fa-trash"></i> Удалить
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Модальное окно подтверждения удаления -->
<div class="custom-modal" id="deleteModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <span class="custom-modal-title">Подтверждение удаления</span>
            <span class="custom-modal-close">&times;</span>
        </div>
        <div class="custom-modal-body">
            <p>Вы действительно хотите удалить видео рилс "<span id="deleteItemTitle"></span>"?</p>
            <p>Это действие нельзя будет отменить.</p>
        </div>
        <div class="custom-modal-footer">
            <button class="admin-btn" id="cancelDelete">Отмена</button>
            <form id="deleteForm" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="admin-btn admin-btn--danger">Удалить</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<!-- Добавляем ссылки на CSS для DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<script>
    $(document).ready(function() {
        // Инициализация DataTables с настройками
        $('#videoReelsTable').DataTable({
            responsive: true,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.11.5/i18n/ru.json'
            },
            columnDefs: [
                { 
                    targets: -1, // Колонка с действиями
                    orderable: false,
                    searchable: false
                }
            ],
            order: [[4, 'asc']] // Сортировка по умолчанию по полю "Порядок"
        });
        
        // Обработка кнопки удаления
        $('.delete-btn').on('click', function() {
            const id = $(this).data('id');
            const title = $(this).data('title');
            
            $('#deleteItemTitle').text(title);
            $('#deleteForm').attr('action', `{{ route('admin.video-reels.destroy', '') }}/${id}`);
            
            showModal('deleteModal');
        });
        
        // Закрытие модального окна
        $('#cancelDelete, .custom-modal-close').on('click', function() {
            hideModal('deleteModal');
        });
    });
</script>
@endsection

@extends('layouts.adm')

@section('content')
<div class="admin-container">
    <h1 class="admin-title wow fadeInDown">Модерация отзывов</h1>
    
    @if(session('message'))
        <div class="admin-alert-success">
            {{ session('message') }}
        </div>
    @endif
    
    <div class="admin-tabs">
        <ul class="admin-nav-tabs">
            <li class="admin-nav-tab active" data-target="pending">
                Неодобренные отзывы <span class="admin-badge-warning">{{ $feedbacks->where('approved', false)->count() }}</span>
            </li>
            <li class="admin-nav-tab" data-target="approved">
                Одобренные отзывы <span class="admin-badge-success">{{ $feedbacks->where('approved', true)->count() }}</span>
            </li>
        </ul>
    </div>
    
    <div class="admin-card wow fadeInUp">
        <div class="admin-tab-content" id="pending">
            @if($feedbacks->where('approved', false)->count() > 0)
                <div class="feedback-list">
                    <div class="admin-table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Имя</th>
                                    <th>Email</th>
                                    <th>Отзыв</th>
                                    <th>Дата</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($feedbacks->where('approved', false) as $feedback)
                                <tr>
                                    <td>{{ $feedback->id }}</td>
                                    <td>{{ $feedback->name }}</td>
                                    <td>{{ $feedback->email }}</td>
                                    <td class="feedback-text" data-feedback="{{ $feedback->comment }}">
                                        {{ Str::limit($feedback->comment, 50) }}
                                    </td>
                                    <td data-sort="{{ $feedback->created_at->timestamp }}">
                                        {{ $feedback->created_at->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="actions">
                                        <form action="{{ route('feedback.approve', $feedback->id) }}" method="POST" class="inline-form">
                                            @csrf
                                            <button type="submit" class="admin-btn admin-btn--success">
                                                <!-- Check icon SVG -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 16 16">
                                                  <path d="M13.485 1.929a.75.75 0 01.02 1.06L6.53 10.464a.75.75 0 01-1.06 0L2.5 7.506a.75.75 0 111.06-1.06L6 8.874l6.424-6.424a.75.75 0 011.06.03z"/>
                                                </svg>
                                                <span class="btn-text"> Одобрить</span>
                                            </button>
                                        </form>
                                        <button class="admin-btn admin-btn--danger delete-btn" 
                                                data-id="{{ $feedback->id }}" 
                                                data-name="{{ $feedback->name }}">
                                            <!-- Trash icon SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 16 16">
                                              <path d="M5.5 5.5a.5.5 0 01.5.5v6a.5.5 0 01-1 0v-6a.5.5 0 01.5-.5zm5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0v-6a.5.5 0 01.5-.5z"/>
                                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4H2.5a1 1 0 010-2h3a1 1 0 01.9-.546h2.2a1 1 0 01.9.546h3a1 1 0 011 1zM4.118 4l.82 9.576A1 1 0 005.93 15h4.14a1 1 0 00.992-.424L11.882 4H4.118z" clip-rule="evenodd"/>
                                              <path fill-rule="evenodd" d="M5.5 1a1 1 0 00-1 1v1h6V2a1 1 0 00-1-1h-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="btn-text"> Удалить</span>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <p class="no-feedback">Нет отзывов, ожидающих модерации.</p>
            @endif
        </div>
        
        <div class="admin-tab-content" id="approved" style="display:none;">
            @if($feedbacks->where('approved', true)->count() > 0)
                <div class="feedback-list">
                    <div class="admin-table-wrapper">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Имя</th>
                                    <th>Email</th>
                                    <th>Отзыв</th>
                                    <th>Дата</th>
                                    <th>Действия</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($feedbacks->where('approved', true) as $feedback)
                                <tr>
                                    <td>{{ $feedback->id }}</td>
                                    <td>{{ $feedback->name }}</td>
                                    <td>{{ $feedback->email }}</td>
                                    <td class="feedback-text" data-feedback="{{ $feedback->comment }}">
                                        {{ Str::limit($feedback->comment, 50) }}
                                    </td>
                                    <td data-sort="{{ $feedback->created_at->timestamp }}">
                                        {{ $feedback->created_at->format('d.m.Y H:i') }}
                                    </td>
                                    <td class="actions">
                                        <form action="{{ route('feedback.disapprove', $feedback->id) }}" method="POST" class="inline-form">
                                            @csrf
                                            <button type="submit" class="admin-btn admin-btn--warning">
                                                <!-- Undo icon SVG -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 16 16">
                                                  <path d="M8.5 1a.5.5 0 01.5.5v4.793l2.146-2.147a.5.5 0 01.708.708l-3 3a.5.5 0 01-.708 0l-3-3a.5.5 0 01.708-.708L8 6.293V1.5a.5.5 0 01.5-.5z"/>
                                                  <path d="M8 9a5 5 0 100-10A5 5 0 008 9z"/>
                                                </svg>
                                                <span class="btn-text"> Отозвать одобрение</span>
                                            </button>
                                        </form>
                                        <button class="admin-btn admin-btn--danger delete-btn" 
                                                data-id="{{ $feedback->id }}" 
                                                data-name="{{ $feedback->name }}">
                                            <!-- Trash icon SVG -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 16 16">
                                              <path d="M5.5 5.5a.5.5 0 01.5.5v6a.5.5 0 01-1 0v-6a.5.5 0 01.5-.5zm5 0a.5.5 0 01.5.5v6a.5.5 0 01-1 0v-6a.5.5 0 01.5-.5z"/>
                                              <path fill-rule="evenodd" d="M14.5 3a1 1 0 01-1 1H13v9a2 2 0 01-2 2H5a2 2 0 01-2-2V4H2.5a1 1 0 010-2h3a1 1 0 01.9-.546h2.2a1 1 0 01.9.546h3a1 1 0 011 1zM4.118 4l.82 9.576A1 1 0 005.93 15h4.14a1 1 0 00.992-.424L11.882 4H4.118z" clip-rule="evenodd"/>
                                              <path fill-rule="evenodd" d="M5.5 1a1 1 0 00-1 1v1h6V2a1 1 0 00-1-1h-4z" clip-rule="evenodd"/>
                                            </svg>
                                            <span class="btn-text"> Удалить</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach    
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <p class="no-feedback">Нет одобренных отзывов.</p>
            @endif
        </div>
    </div>
    
    <!-- Модальное окно для просмотра полного отзыва -->
    <div class="custom-modal" id="feedbackModal">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h5 class="custom-modal-title">Полный текст отзыва</h5>
                <span class="custom-modal-close">&times;</span>
            </div>
            <div class="custom-modal-body">
                <p id="fullFeedbackText"></p>
            </div>
            <div class="custom-modal-footer">
                <button class="admin-btn" onclick="hideModal('feedbackModal')">Закрыть</button>
            </div>
        </div>
    </div>
    
    <!-- Модальное окно подтверждения удаления -->
    <div class="custom-modal" id="deleteModal">
        <div class="custom-modal-content">
            <div class="custom-modal-header">
                <h5 class="custom-modal-title">Подтверждение удаления</h5>
                <span class="custom-modal-close">&times;</span>
            </div>
            <div class="custom-modal-body">
                <p>Вы действительно хотите удалить отзыв от <strong id="deleteName"></strong>?</p>
            </div>
            <div class="custom-modal-footer">
                <button class="admin-btn" onclick="hideModal('deleteModal')">Отмена</button>
                <form id="deleteForm" method="POST" style="display: inline-block;">
                    @csrf @method('DELETE')
                    <button type="submit" class="admin-btn admin-btn--danger">Удалить</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Простой переключатель вкладок
    document.querySelectorAll('.admin-nav-tab').forEach(tab => {
        tab.addEventListener('click', function() {
            document.querySelectorAll('.admin-nav-tab').forEach(t => t.classList.remove('active'));
            this.classList.add('active');
            const target = this.getAttribute('data-target');
            document.querySelectorAll('.admin-tab-content').forEach(content => {
                content.style.display = content.id === target ? 'block' : 'none';
            });
        });
    });
    
    // Открытие модального окна полного отзыва при клике по тексту
    document.querySelectorAll('.feedback-text').forEach(el => {
        el.style.cursor = 'pointer';
        el.addEventListener('click', function() {
            const feedback = this.getAttribute('data-feedback');
            document.getElementById('fullFeedbackText').innerText = feedback;
            showModal('feedbackModal');
        });
    });
    
    // Подтверждение удаления через модальное окно
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const name = this.getAttribute('data-name');
            
            document.getElementById('deleteName').textContent = name;
            document.getElementById('deleteForm').action = "{{ route('feedback.index') }}/" + id;
            
            showModal('deleteModal');
        });
    });
</script>
@endsection

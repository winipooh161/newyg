@extends('layouts.adm')

@section('content')
@php
    // Если контроллер не передал переменную $users, получаем всех пользователей
    $users = isset($users) && $users->count() ? $users : \App\Models\User::all();
@endphp
<div class="admin-container">
    <h1 class="admin-title wow fadeInDown">Управление пользователями</h1>
    
    @if(session('success'))
        <div class="admin-alert-success">
            {{ session('success') }}
        </div>
    @endif
    
    <div class="admin-card wow fadeInUp">
        <div class="header-section flex-between">
            <h5>Список пользователей</h5>
            <button class="admin-btn" onclick="showModal('addUserModal')">Добавить пользователя</button>
        </div>
        <div id="usersTable_wrapper" class="admin-dataTables-wrapper">
            <div class="admin-table-wrapper">
                <table class="admin-table" id="usersTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Имя</th>
                            <th>Телефон</th>
                            <th>Роль</th>
                            <th>Дата регистрации</th>
                            <th>Действия</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users ?? [] as $user)
                        <tr>
                            <td>{{ $user->id ?? '1' }}</td>
                            <td>{{ $user->name ?? 'Александр Иванов' }}</td>
                            <td>{{ $user->phone ?? 'Не указан' }}</td>
                            <td>
                                <span class="admin-badge {{ ($user->status ?? 'user') == 'admin' ? 'badge-danger' : 'badge-info' }}">
                                    {{ ($user->status ?? 'user') == 'admin' ? 'Администратор' : 'Пользователь' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at ?? '2023-06-15' }}</td>
                            <td class="actions">
                                <button class="admin-btn admin-btn--small edit-user-btn" data-id="{{ $user->id ?? '1' }}">
                                    <!-- Edit icon SVG -->
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#fff" viewBox="0 0 16 16">
                                      <path d="M15.502 1.94a.5.5 0 00-.706 0L10.5 6.236l.707.707 4.296-4.296a.5.5 0 000-.707z"/>
                                      <path fill-rule="evenodd" d="M6.854 7.146L2 12v1h1l4.854-4.854-.854-.854z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="btn-text"> Редактировать</span>
                                </button>
                                <button class="admin-btn admin-btn--small admin-btn--danger delete-user-btn" data-id="{{ $user->id ?? '1' }}">
                                    <!-- Trash icon SVG (как в feedback) -->
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
    </div>
</div>

<!-- Модальное окно для добавления пользователя -->
<div class="custom-modal" id="addUserModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">Добавить пользователя</h5>
            <span class="custom-modal-close">&times;</span>
        </div>
        <div class="custom-modal-body">
            <form id="addUserForm">
                <div class="admin-form-group">
                    <label for="name" class="admin-label">Имя</label>
                    <input type="text" class="admin-input" id="name" name="name" required>
                </div>
                <div class="admin-form-group">
                    <label for="email" class="admin-label">Email</label>
                    <input type="email" class="admin-input" id="email" name="email" required>
                </div>
                <div class="admin-form-group">
                    <label for="phone" class="admin-label">Телефон</label>
                    <input type="tel" class="admin-input maskphone" id="phone" name="phone" required>
                </div>
                <div class="admin-form-group">
                    <label for="password" class="admin-label">Пароль</label>
                    <input type="password" class="admin-input" id="password" name="password" required>
                </div>
                <div class="admin-form-group">
                    <label for="role" class="admin-label">Роль</label>
                    <select class="admin-select" id="role" name="role">
                        <option value="user">Пользователь</option>
                        <option value="admin">Администратор</option>
                    </select>
                </div>
                <div class="flex-end">
                    <button type="submit" class="admin-btn">Сохранить</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Модальное окно для редактирования пользователя -->
<div class="custom-modal" id="editUserModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">Редактировать пользователя</h5>
            <span class="custom-modal-close">&times;</span>
        </div>
        <div class="custom-modal-body">
            <form id="editUserForm">
                <input type="hidden" id="edit_id" name="id">
                <div class="admin-form-group">
                    <label for="edit_name" class="admin-label">Имя</label>
                    <input type="text" class="admin-input" id="edit_name" name="name" required>
                </div>
                <div class="admin-form-group">
                    <label for="edit_email" class="admin-label">Email</label>
                    <input type="email" class="admin-input" id="edit_email" name="email" required>
                </div>
                <div class="admin-form-group">
                    <label for="edit_phone" class="admin-label">Телефон</label>
                    <input type="tel" class="admin-input" id="edit_phone" name="phone" required>
                </div>
                <div class="admin-form-group">
                    <label for="edit_password" class="admin-label">Новый пароль (если нужно сменить)</label>
                    <input type="password" class="admin-input" id="edit_password" name="password">
                </div>
                <div class="admin-form-group">
                    <label for="edit_role" class="admin-label">Роль</label>
                    <select class="admin-select" id="edit_role" name="role">
                        <option value="user">Пользователь</option>
                        <option value="admin">Администратор</option>
                    </select>
                </div>
                <div class="flex-end">
                    <button type="submit" class="admin-btn">Сохранить изменения</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Модальное окно подтверждения удаления -->
<div class="custom-modal" id="deleteUserModal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">Подтверждение удаления</h5>
            <span class="custom-modal-close">&times;</span>
        </div>
        <div class="custom-modal-body">
            <p>Вы действительно хотите удалить пользователя <strong id="deleteUserName"></strong>?</p>
        </div>
        <div class="custom-modal-footer">
            <button class="admin-btn" onclick="hideModal('deleteUserModal')">Отмена</button>
            <button id="confirmDeleteBtn" class="admin-btn admin-btn--danger">Удалить</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Добавляем CSRF-токен для всех AJAX запросов
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        // Инициализация DataTables
        $('#usersTable').DataTable({
            responsive: true,
            language: {
                "sProcessing":     "Подождите...",
                "sSearch":         "Поиск:",
                "sLengthMenu":     "Показать _MENU_ записей",
                "sInfo":           "Показаны с _START_ по _END_ из _TOTAL_ записей",
                "sInfoEmpty":      "Показаны с 0 по 0 из 0 записей",
                "sInfoFiltered":   "(отфильтровано из _MAX_ записей)",
                "sLoadingRecords": "Загрузка записей...",
                "oPaginate": {
                    "sFirst": "Первая",
                    "sLast": "Последняя",
                    "sNext": "Следующая",
                    "sPrevious": "Предыдущая"
                },
                "oAria": {
                    "sSortAscending":  ": активировать для сортировки столбца по возрастанию",
                    "sSortDescending": ": активировать для сортировки столбца по убыванию"
                }
            }
        });

        // Обработчик для кнопки редактирования
        $('.edit-user-btn').click(function() {
            const userId = $(this).data('id');
            // Здесь должен быть AJAX запрос для получения данных пользователя
            // Для демонстрации используем фиктивные данные
            const userData = {
                id: userId,
                name: userId == 1 ? 'Александр Иванов' : (userId == 2 ? 'Мария Петрова' : 'Дмитрий Сидоров'),
                phone: userId == 1 ? '89001234567' : (userId == 2 ? '89007654321' : '89009876543'),
                role: userId == 3 ? 'admin' : 'user'
            };

            $('#edit_id').val(userData.id);
            $('#edit_name').val(userData.name);
            $('#edit_phone').val(userData.phone);
            $('#edit_role').val(userData.role);
            
            showModal('editUserModal');
        });

        // Обработчик для кнопки удаления
        $('.delete-user-btn').click(function() {
            const userId = $(this).data('id');
            // Получаем имя пользователя из ряда таблицы
            const userName = $(this).closest('tr').find('td:eq(1)').text();
            
            $('#deleteUserName').text(userName);
            $('#confirmDeleteBtn').data('id', userId);
            
            showModal('deleteUserModal');
        });
        
        // Подтверждение удаления
        $('#confirmDeleteBtn').click(function() {
            const userId = $(this).data('id');
            
            $.ajax({
                url: "{{ route('admin.users.destroy', ['user' => 'PLACEHOLDER']) }}".replace('PLACEHOLDER', userId),
                method: "DELETE",
                success: function(response) {
                    alert(response.message);
                    hideModal('deleteUserModal');
                    // Можно обновить таблицу или перезагрузить страницу
                    location.reload();
                },
                error: function(xhr) {
                    alert('Ошибка: ' + (xhr.responseJSON.message || 'Не удалось удалить пользователя'));
                }
            });
        });

        // Обработка формы добавления пользователя
        $('#addUserForm').submit(function(e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.ajax({
                url: "{{ route('admin.users.store') }}",
                method: "POST",
                data: formData,
                success: function(response) {
                    alert(response.message);
                    hideModal('addUserModal');
                    // Можно обновить таблицу или перезагрузить страницу
                    location.reload();
                },
                error: function(xhr) {
                    alert('Ошибка: ' + (xhr.responseJSON.message || 'Не удалось создать пользователя'));
                }
            });
        });

        // Обработка формы редактирования пользователя
        $('#editUserForm').submit(function(e) {
            e.preventDefault();
            // Здесь должен быть AJAX запрос для обновления данных пользователя
            alert('Данные пользователя успешно обновлены!');
            hideModal('editUserModal');
            
            // После успешного обновления обновляем таблицу или перезагружаем страницу
        });
    });
</script>
@endsection

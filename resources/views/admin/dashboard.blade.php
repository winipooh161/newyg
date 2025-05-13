@extends('layouts.adm')

@section('content')
<div class="admin-container">

    <div class="admin-card">
        <div class="admin-dashboard">
            <h1 class="dashboard-title wow fadeInUp">Административная панель</h1>
            <div class="stats">
                <div class="stat">
                    <div class="stat-header">Пользователи</div>
                    <div class="stat-number spanAnim">{{ $usersCount }}</div>
                    <div class="stat-footer">
                        <a href="{{ route('admin.users') }}" class="admin-btn admin-btn--link">Управление</a>
                    </div>
                </div>
                <div class="stat">
                    <div class="stat-header">Проекты</div>
                    <div class="stat-number spanAnim">{{ $projectsCount }}</div>
                    <div class="stat-footer">
                        <a href="{{ route('admin.projects') }}" class="admin-btn admin-btn--link">Управление</a>
                    </div>
                </div>
                <div class="stat">
                    <div class="stat-header">Отзывы</div>
                    <div class="stat-number spanAnim">{{ $feedbackCount }}</div>
                    <div class="stat-footer">
                        <a href="{{ route('feedback.index') }}" class="admin-btn admin-btn--link">Управление</a>
                    </div>
                </div>
                <div class="stat">
                    <div class="stat-header">Видео рилсы</div>
                    <div class="stat-number spanAnim">{{ $feedbackCount }}</div>
                    <div class="stat-footer">
                        <a href="{{ route('admin.video-reels.index') }}" class="admin-btn admin-btn--link">Управление</a>
                    </div>
                </div>
            </div>
            <div class="actions flex-between" style="margin-top:20px;">
                <div class="action wow fadeInLeft">
                    <h2>Добавить новый проект</h2>
                    <p>Создайте новый проект</p>
                    <a href="{{ route('admin.projects.create') }}" class="admin-btn">Добавить проект</a>
                </div>
               
            </div>
        </div>
    </div>
</div>
@endsection




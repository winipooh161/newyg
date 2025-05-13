<div id="{{ $id ?? 'customModal' }}" class="custom-modal">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h5 class="custom-modal-title">{{ $title ?? 'Модальное окно' }}</h5>
            <span class="custom-modal-close" onclick="hideModal('{{ $id ?? 'customModal' }}')">&times;</span>
        </div>
        <div class="custom-modal-body">
            {{ $slot ?? 'Содержимое модального окна' }}
        </div>
        @if(isset($footer))
            <div class="custom-modal-footer">
                {{ $footer }}
            </div>
        @else
            <div class="custom-modal-footer">
                <button class="admin-btn" onclick="hideModal('{{ $id ?? 'customModal' }}')">Закрыть</button>
            </div>
        @endif
    </div>
</div>

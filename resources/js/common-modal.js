function openCommonModal(options) {
    // options: { title, body, footer }
    document.getElementById('commonModalTitle').innerText = options.title || 'Информация';
    document.getElementById('commonModalBody').innerHTML = options.body || '';
    if(options.footer !== undefined) {
        document.getElementById('commonModalFooter').innerHTML = options.footer;
    }
    document.getElementById('commonModal').style.display = 'flex';
}

function closeCommonModal() {
    document.getElementById('commonModal').style.display = 'none';
}

// Закрытие модального окна при клике вне его содержимого
window.addEventListener('click', function(event) {
    let modal = document.getElementById('commonModal');
    if (event.target === modal) {
        closeCommonModal();
    }
});

function fetchData() {
    // Отримуємо поточну дату
    var currentDate = new Date();
    var currentYear = currentDate.getFullYear();
    var currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0');
    var currentDay = String(currentDate.getDate()).padStart(2, '0');
    var formattedCurrentDate = currentYear + '-' + currentMonth + '-' + currentDay;

    // Показуємо перекриття "Зачекайте"
    var loadingOverlay = document.getElementById('loading-overlay');
    loadingOverlay.style.display = 'flex';

    var startDate = document.getElementById('startDate').value;

    // Перевірка, чи вибрано дату. Якщо не вибрано, беремо поточну дату
    if (!startDate) {
        startDate = formattedCurrentDate;
    }

    // Формуємо URL для виклику PHP з параметрами дат
    var url = '2_4_ERPN_PHP.php?start=' + startDate;

    // Викликаємо PHP через AJAX з використанням fetch
    fetch(url)
        .then(response => response.text()) // Отримуємо текстовий результат з PHP
        .then(data => {
            // Виводимо результат в нижній div
            document.getElementById('lowerDiv').innerHTML = data;

            // Ховаємо перекриття "Зачекайте" після завершення завантаження
            loadingOverlay.style.display = 'none';
        })
        .catch(error => {
            console.error('Помилка AJAX-запиту:', error);
            // Ховаємо перекриття "Зачекайте" у разі виникнення помилки
            loadingOverlay.style.display = 'none';
        });
}

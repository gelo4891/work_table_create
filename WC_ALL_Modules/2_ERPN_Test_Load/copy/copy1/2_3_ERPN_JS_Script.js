function fetchData() {
  var startDate = document.getElementById('startDate').value;

  // Перевірка, чи вибрано дату. Якщо не вибрано, беремо поточну дату
  if (!startDate) {
      var currentDate = new Date();
      var sevenDaysAgo = new Date(currentDate);
      sevenDaysAgo.setDate(currentDate.getDate() - 7);

      // Форматуємо дату у формат yyyy-mm-dd
      var year = sevenDaysAgo.getFullYear();
      var month = String(sevenDaysAgo.getMonth() + 1).padStart(2, '0');
      var day = String(sevenDaysAgo.getDate()).padStart(2, '0');
      startDate = year + '-' + month + '-' + day;
  }

  // Формуємо URL для виклику PHP з параметрами дат
  var url = '2_4_ERPN_PHP.php?start=' + startDate;

  // Викликаємо PHP через AJAX з використанням fetch
  fetch(url)
      .then(response => response.text()) // Отримуємо текстовий результат з PHP
      .then(data => {
          // Виводимо результат в нижній div
          document.getElementById('lowerDiv').innerHTML = data;
      })
      .catch(error => {
          console.error('Помилка AJAX-запиту:', error);
      });
}

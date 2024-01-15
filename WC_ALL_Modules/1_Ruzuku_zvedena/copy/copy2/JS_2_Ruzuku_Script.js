window.addEventListener('load', function() {
  var submitBtn = document.getElementById('submit-btn');
  var codeInput = document.getElementById('code-input');
  var codeTable = document.getElementById('code-table');
  var exportBtn = document.getElementById('export-btn'); // Додана кнопка "Вивантаження Excel"

  submitBtn.addEventListener('click', function() {
    var codes = codeInput.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP_1_Ruzuku.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = xhr.responseText;
        codeTable.innerHTML = response;
        exportBtn.style.display = 'block'; // Показуємо кнопку "Вивантаження Excel" після отримання відповіді
        exportBtn.setAttribute('data-codes', codes); // Зберігаємо коди у атрибуті кнопки
      }
    };
    xhr.send('codes=' + encodeURIComponent(codes));
  });

  exportBtn.addEventListener('click', function() {
    var codes = exportBtn.getAttribute('data-codes'); // Отримуємо коди з атрибуту кнопки
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'export_excel.php?codes=' + encodeURIComponent(codes), true); // Додаємо коди до URL запиту
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.responseType = 'blob';
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var blob = new Blob([xhr.response], {type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'});
        var url = window.URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = 'results.xlsx';
        a.click();
        window.URL.revokeObjectURL(url);
      }
    };
    xhr.send();
  });
});

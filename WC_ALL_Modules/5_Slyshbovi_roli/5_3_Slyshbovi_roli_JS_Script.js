function sendRequestAndUpdate(updateElement, codesValue, dateValue, nomerValue){
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/WC_ALL_Modules/5_Slyshbovi_roli/5_4_Slyshbovi_roli_PHP_Select.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      updateElement.innerHTML = xhr.responseText;
      initializeDynamicSelect();
    }
  };
  xhr.send('codes=' + encodeURIComponent(codesValue) + '&date=' + encodeURIComponent(dateValue) + '&nomer=' + encodeURIComponent(nomerValue));
}

function initializeEventHandlers() {
  const elements = {
    select_PB_YDO: document.getElementById('html-select-PB-YDO'),
    loadingKrok2: document.getElementById('loading-krok2'),
    loadingKrok2Select: document.getElementById('html-loading-krok2-select'),    
    searchInput: document.getElementById('searchInput'),
  };

  elements.select_PB_YDO.addEventListener('input', () => {
    const isOption1or2 = ['1', '2'].includes(elements.select_PB_YDO.value);
    showHide(elements.loadingKrok2, isOption1or2);

    hideHtmlInputDate();

    if (isOption1or2) {
      sendRequestAndUpdate(elements.loadingKrok2Select, 'rozblok-loading-krok2');
    }
  });

  elements.searchInput.addEventListener('input', filterSelectOptions);
  elements.searchInput.addEventListener('focus', openSelectOptions);

}

function hideHtmlInputDate() {
  const hiddenBlock = document.getElementById('html-input-date');
  hiddenBlock.style.display = 'none';
  clearTextInputs();
}

function clearTextInputs() {
  document.querySelectorAll('input[type="text"], input[type="date"]').forEach(input => (input.value = ''));
}


function openSelectOptions() {
  const dynamicSelect = document.getElementById('PhpSelectMenu');
  if (dynamicSelect) {
    dynamicSelect.size = 5;
  }
}

function showHide(element, show) {
  element.style.display = show ? 'block' : 'none';
}

function initializeDynamicSelect() {
  const dynamicSelect = document.getElementById('PhpSelectMenu');

  if (dynamicSelect) {
    dynamicSelect.addEventListener('input', () => {
      const selectedDynamicValue = dynamicSelect.value;
      console.log('Обрано в динамічному select: ' + selectedDynamicValue);
    
      showHideHiddenBlock(selectedDynamicValue);
    });
  }
}

function showHideHiddenBlock(selectedDynamicValue) {
  const hiddenBlock = document.getElementById('html-input-date');
  hiddenBlock.style.display = selectedDynamicValue !== '' ? 'block' : 'none';
  filterSelectOptions();
}

function filterSelectOptions() {
  const searchTerm = document.getElementById('searchInput').value.toLowerCase();
  document.querySelectorAll('.select-option').forEach(option => {
    const text = option.textContent.toLowerCase();
    const isMatch = text.includes(searchTerm);
    option.style.display = isMatch ? 'block' : 'none';
  });
}

/*----------------------------------------------------------------------------------------*/


function clickButton() {
  const elements = {   
    submitBtn: document.getElementById('php-submit-btn'),
    inputeDate: document.getElementById('krok2-data'),
    inputeNomer: document.getElementById('krok2-nomer'),
    resultDiv: document.getElementById('resultDiv'),  // Додайте блок результатів
    // Додайте інші елементи, якщо потрібно
  };  

  // Додайте слухача події для поля inputeDate
  elements.inputeDate.addEventListener('input', function() {
    checkButtonState(elements);
  });

  // Додайте слухача події для поля inputeNomer
  elements.inputeNomer.addEventListener('input', function() {
    checkButtonState(elements);
  });

  // Додайте слухача події для кнопки submitBtn
  elements.submitBtn.addEventListener('click', function() {
    const dateValue = elements.inputeDate.value;
    const nomerValue = elements.inputeNomer.value;

    // Передача значень до функції sendRequestAndUpdate
    sendRequestAndUpdate(elements.resultDiv, 'insert-upadate-date', dateValue, nomerValue);

    // Очищення полів після відправки
    elements.inputeDate.value = '';
    elements.inputeNomer.value = '';

    // Встановлення кнопці disabled після відправки
    elements.submitBtn.disabled = true;
  });

  // Початкова перевірка стану кнопки
  checkButtonState(elements);
}

// Функція для перевірки стану кнопки
function checkButtonState(elements) {
  const dateValue = elements.inputeDate.value.trim();
  const nomerValue = elements.inputeNomer.value.trim();

  // Перевірка, чи обидва поля не порожні
  const bothInputsFilled = dateValue !== '' && nomerValue !== '';

  // Встановлення властивості disabled в залежності від умови
  elements.submitBtn.disabled = !bothInputsFilled;
}
/*----------------------------------------------------------------------------------------*/


// Викликаємо ініціалізацію для першого select
initializeEventHandlers();
clickButton();






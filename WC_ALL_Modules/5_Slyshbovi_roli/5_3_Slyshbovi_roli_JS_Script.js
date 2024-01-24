function sendRequestAndUpdate(updateElement, codesValue, dateValue, nomerValue,selectPidSys) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/WC_ALL_Modules/5_Slyshbovi_roli/5_4_Slyshbovi_roli_PHP_Select.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      updateElement.innerHTML = xhr.responseText;
      initializeDynamicSelect();
    }
  };
  xhr.send(`codes=${encodeURIComponent(codesValue)}&date=${encodeURIComponent(dateValue)}&nomer=${encodeURIComponent(nomerValue)}&selectPidSys=${encodeURIComponent(selectPidSys)}`);
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
  document.getElementById('html-input-date').style.display = 'none';
  clearTextInputs();
}

function clearTextInputs() {
  document.querySelectorAll('input[type="text"], input[type="date"]').forEach(input => input.value = '');
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
    dynamicSelect.addEventListener('input', () => showHideHiddenBlock(dynamicSelect.value));
  }
}

function showHideHiddenBlock(selectedDynamicValue) {
  document.getElementById('html-input-date').style.display = selectedDynamicValue !== '' ? 'block' : 'none';
  filterSelectOptions();
}

function filterSelectOptions() {
  const searchTerm = document.getElementById('searchInput').value.toLowerCase();
  document.querySelectorAll('.select-option').forEach(option => option.style.display = option.textContent.toLowerCase().includes(searchTerm) ? 'block' : 'none');
}

function clickButton() {
  const elements = {
    submitBtn: document.getElementById('php-submit-btn'),
    inputeDate: document.getElementById('krok2-data'),
    inputeNomer: document.getElementById('krok2-nomer'),
    resultDiv: document.getElementById('resultDiv'),
    selectPidSys: document.getElementById('html-select-PID-sys'),  // Додайте визначення для selectPidSys  
  };

  elements.inputeDate.addEventListener('input', checkButtonState);
  elements.inputeNomer.addEventListener('input', checkButtonState);
  elements.selectPidSys.addEventListener('change', checkButtonState);
 
  elements.submitBtn.addEventListener('click', () => {
    sendRequestAndUpdate(elements.resultDiv, 'insert-upadate-date', elements.inputeDate.value, elements.inputeNomer.value,elements.selectPidSys.value);
    elements.inputeDate.value = '';
    elements.inputeNomer.value = '';
    elements.selectPidSys.value = '';
    elements.submitBtn.disabled = true;
  });

  checkButtonState();
}

function checkButtonState() {
  const elements = {
    inputeDate: document.getElementById('krok2-data'),
    inputeNomer: document.getElementById('krok2-nomer'),
    submitBtn: document.getElementById('php-submit-btn'),
    selectPidSys: document.getElementById('html-select-PID-sys'),
  };

  const bothInputsFilled = elements.inputeDate.value.trim() !== '' &&
                           elements.inputeNomer.value.trim() !== '' &&
                           elements.selectPidSys.value !== '';

  elements.submitBtn.disabled = !bothInputsFilled;
}

initializeEventHandlers();
clickButton();
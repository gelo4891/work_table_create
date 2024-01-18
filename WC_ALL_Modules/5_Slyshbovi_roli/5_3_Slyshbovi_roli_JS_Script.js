function sendRequestAndUpdate(updateElement, codesValue) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/WC_ALL_Modules/5_Slyshbovi_roli/5_4_Slyshbovi_roli_PHP_Select.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      updateElement.innerHTML = xhr.responseText;
      initializeDynamicSelect();
    }
  };
  xhr.send('codes=' + encodeURIComponent(codesValue));
}

function initializeEventHandlers() {
  const elements = {
    select_PB_YDO: document.getElementById('html-select-PB-YDO'),
    loadingKrok2: document.getElementById('loading-krok2'),
    loadingKrok2Select: document.getElementById('html-loading-krok2-select'),
    krok2Data: document.getElementById('php-krok2-data'),
    krok2Nomer: document.getElementById('php-krok2-nomer'),
    submitBtn: document.getElementById('php-submit-btn'),
    hiddenBlockHtml: document.getElementById('html-input-date'),
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
  document.querySelectorAll('input[type="text"]').forEach(input => (input.value = ''));
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

// Викликаємо ініціалізацію для першого select
initializeEventHandlers();

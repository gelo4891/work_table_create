function sendRequestAndUpdate(updateElement, codesValue, paramsArray) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/WC_ALL_Modules/5_Slyshbovi_roli/5_4_Slyshbovi_roli_PHP_Select.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onreadystatechange = function () {
    if (xhr.readyState === 4 && xhr.status === 200) {
      updateElement.innerHTML = xhr.responseText;
      initializeDynamicSelect('PhpSelectMenu');
    }
  };

  // Підготовка рядка параметрів з масиву
  const paramsString = paramsArray.map(param => `${param.name}=${encodeURIComponent(param.value)}`).join('&');

  xhr.send(`codes=${encodeURIComponent(codesValue)}&${paramsString}`);
}

function initializeEventHandlers() {
  const elements = {
    select_PB_YDO: getElementById('html-select-PB-YDO'),
    loadingKrok2: getElementById('loading-krok2'),
    loadingKrok2Select: getElementById('html-loading-krok2-select'),
    searchInput: getElementById('searchInput'),
  };

  elements.select_PB_YDO.addEventListener('input', () => {
    const isOption1or2 = ['1', '2'].includes(elements.select_PB_YDO.value);
    showHide(elements.loadingKrok2, isOption1or2);
    hideHtmlInputDate();
    if (isOption1or2) {
      const paramsArray = []; // Опціонально, якщо є параметри для передачі
      sendRequestAndUpdate(elements.loadingKrok2Select, 'rozblok-loading-krok2', paramsArray);
    }
  });

  elements.searchInput.addEventListener('input', filterSelectOptions);
  elements.searchInput.addEventListener('focus', openSelectOptions,'PhpSelectMenu');
}

// Одноразова функція для отримання елемента за ID
function getElementById(id) {
  return document.getElementById(id);
}

function hideHtmlInputDate() {
  getElementById('html-input-date').style.display = 'none';
  clearTextInputs();
}

function clearTextInputs() {
  document.querySelectorAll('input[type="text"], input[type="date"]').forEach(input => input.value = '');
}

function openSelectOptions(SIZE_PhpSelectMenu) {
  const dynamicSelect = getElementById(SIZE_PhpSelectMenu);
  if (dynamicSelect) {
    dynamicSelect.size = 5;
  }
}

function showHide(element, show) {
  element.style.display = show ? 'block' : 'none';
}



function initializeDynamicSelect(ID_PhpSelectMenu) {
  const IdSelectValue = getElementById(ID_PhpSelectMenu);
  if (IdSelectValue) {
    IdSelectValue.addEventListener('input', () => {
    
    
      const selectedValue = IdSelectValue.value;
      console.log('Ви вибрали:', selectedValue);

      /*вибираємо дані про працівника*/
      const elements = {
        krok2SQL: getElementById('html-blok3_dani_user'),
      };

      const paramsArrayPib = [
        { name: 'PIB', value: selectedValue },
      ];
  
      sendRequestAndUpdate(elements.krok2SQL, 'selept-date-pib', paramsArrayPib);
      /*---------------------------------------------------------------------------------*/


      // Викликати функцію showHideHiddenBlock зі значенням
      showHideHiddenBlock(IdSelectValue);

    });
  }
}


function showHideHiddenBlock(selectedDynamicValue) {
  getElementById('html-input-date').style.display = selectedDynamicValue !== '' ? 'block' : 'none';
  const paramsArray = []; // Опціонально, якщо є параметри для передачі
  
 // sendRequestAndUpdate(elements.loadingKrok2Select, 'rozblok-loading-krok2', paramsArray);

  filterSelectOptions();
}

function filterSelectOptions() {
  const searchTerm = getElementById('searchInput').value.toLowerCase();
  document.querySelectorAll('.select-option').forEach(option => option.style.display = option.textContent.toLowerCase().includes(searchTerm) ? 'block' : 'none');
}

function clickButton() {
  const elements = {
    submitBtn: getElementById('php-submit-btn'),
    inputeDate: getElementById('krok2-data'),
    inputeNomer: getElementById('krok2-nomer'),
    resultDiv: getElementById('resultDiv'),
    selectPidSys: getElementById('html-select-PID-sys'),  
  };

  elements.inputeDate.addEventListener('input', checkButtonState);
  elements.inputeNomer.addEventListener('input', checkButtonState);
  elements.selectPidSys.addEventListener('change', checkButtonState);

  elements.submitBtn.addEventListener('click', () => {
    const paramsArray = [
      { name: 'date', value: elements.inputeDate.value },
      { name: 'nomer', value: elements.inputeNomer.value },
      { name: 'selectPidSys', value: elements.selectPidSys.value },
    ];

    sendRequestAndUpdate(elements.resultDiv, 'insert-upadate-date', paramsArray);

    elements.inputeDate.value = '';
    elements.inputeNomer.value = '';
    elements.selectPidSys.value = '0';
    elements.submitBtn.disabled = true;
  });

  checkButtonState();
}

function checkButtonState() {
  const elements = {
    inputeDate: getElementById('krok2-data'),
    inputeNomer: getElementById('krok2-nomer'),
    submitBtn: getElementById('php-submit-btn'),
    selectPidSys: getElementById('html-select-PID-sys'),
  };

  const bothInputsFilled = elements.inputeDate.value.trim() !== '' &&
                           elements.inputeNomer.value.trim() !== '' &&
                           elements.selectPidSys.value !== '0';

  elements.submitBtn.disabled = !bothInputsFilled;
}

initializeEventHandlers();
clickButton();
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

    HideHtmlinputdate();

    if (isOption1or2) {
      sendRequestAndUpdate(elements.loadingKrok2Select, 'rozblok-loading-krok2');
    }
  });

  elements.searchInput.addEventListener('input', filterSelectOptions);
  elements.searchInput.addEventListener('focus', openSelectOptions); // Додаємо обробник події для відкриття select при фокусі
  //elements.submitBtn.addEventListener('click', submitHandler);
  //initializeDynamicSelect();

}

function HideHtmlinputdate() {
  var hiddenBlock1 = document.getElementById('html-input-date');
    hiddenBlock1.style.display =  'none';
    clearTextInputs();
}

// Функція для очищення полів
function clearTextInputs() {
  var textInputs = document.querySelectorAll('input[type="text"]');
  textInputs.forEach(function (input) {
    input.value = '';
  });
}


function openSelectOptions() {
  var dynamicSelect = document.getElementById('PhpSelectMenu');
  if (dynamicSelect) {
    dynamicSelect.size = 5; // Збільшуємо розмір select, щоб він був видимим
  }
}
function showHide(element, show) {
  element.style.display = show ? 'block' : 'none';
}

function initializeDynamicSelect() {
  var dynamicSelect = document.getElementById('PhpSelectMenu');

  if (dynamicSelect) {
    dynamicSelect.addEventListener('input', function () {
      var selectedDynamicValue = this.value;
      console.log('Обрано в динамічному select: ' + selectedDynamicValue);
    
      // Викликаємо функцію для ініціалізації обробника подій для нового select 
      showHideHiddenBlock(selectedDynamicValue);
    });
  }
}

function showHideHiddenBlock(selectedDynamicValue) {
  
  var hiddenBlock = document.getElementById('html-input-date');
  hiddenBlock.style.display = selectedDynamicValue !== '' ? 'block' : 'none';
 
  filterSelectOptions(); // Оновлюємо фільтр опцій при зміні вмісту блоку
}

function filterSelectOptions() {
  var searchTerm = document.getElementById('searchInput').value.toLowerCase();
  var options = document.querySelectorAll('.select-option');

  options.forEach(function(option) {
    var text = option.textContent.toLowerCase();
    var isMatch = text.includes(searchTerm);
    option.style.display = isMatch ? 'block' : 'none';
  });
}

/*----------------------------------------------------------------------------*/
// Викликаємо ініціалізацію для першого select
initializeEventHandlers();

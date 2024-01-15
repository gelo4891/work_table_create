  function initializeEventHandlers() {
    const elements = {
      select_PB_YDO: document.getElementById('html-select-PB-YDO'),
      loadingKrok2: document.getElementById('loading-krok2'),
      loadingKrok2Select: document.getElementById('html-loading-krok2-select'),
      krok2Data: document.getElementById('php-krok2-data'),
      krok2Nomer: document.getElementById('php-krok2-nomer'),
      submitBtn: document.getElementById('php-submit-btn'),
    };

    elements.select_PB_YDO.addEventListener('change', () => {
      const isOption1or2 = elements.select_PB_YDO.value === '1' || elements.select_PB_YDO.value === '2';
      showHide(elements.loadingKrok2, isOption1or2);
          
      if (isOption1or2==true) {
        sendRequestAndUpdate(elements.loadingKrok2Select, 'rozblok-loading-krok2');
        //showHide(elements.inputDate, true);
      }
    });
  }
    
function sendRequestAndUpdate(updateElement, codesValue) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', '/WC_ALL_Modules/5_Slyshbovi_roli/5_4_Slyshbovi_roli_PHP_Select.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        updateElement.innerHTML = xhr.responseText;
      }
    };
    xhr.send('codes=' + encodeURIComponent(codesValue));
  }

    function showHide(element, show) {
    element.style.display = show ? 'block' : 'none';
  }



  /*---------------------------------------------------------------------------------*/
/*  function initializeDynamicSelect() {
      var dynamicSelect = document.getElementById('PhpSelectMenu');
    
      if (dynamicSelect) {
        // Додаємо обробник події для нового select
        dynamicSelect.addEventListener('change', function() {
          var selectedDynamicValue = this.value;
          console.log('Обрано в динамічному select: ' + selectedDynamicValue);
    
          // Ваш код для виконання додаткових дій
          // Наприклад, показ/приховування схованого блоку
          showHideHiddenBlock(selectedDynamicValue);
        });
      }
  }

  
  // Функція для виконання додаткових дій
  function showHideHiddenBlock(selectedDynamicValue) {
    var hiddenBlock = document.getElementById('html-input-date');
    
    if (selectedDynamicValue !== 'select_start') {
      // Ваша логіка для показу блоку
      hiddenBlock.style.display = 'block';
    } else {
      // Ваша логіка для приховування блоку
      hiddenBlock.style.display = 'none';
    }
  }

*/




  function initializeSelectChangeListener() {
    var selectMenu = document.getElementById('PhpSelectMenu');
  
    if (selectMenu) {
      selectMenu.addEventListener('change', function() {
        var selectedValue = selectMenu.value;
        console.log('Обрано значення: ' + selectedValue);
        // Ваш код для додаткових дій на основі вибраного значення
      });
    }
    else {
      console.log('Пустооооооооооооооо!!!!!!!!!!!!!! ');

    }
  }
  
  // Викликаємо функцію для ініціалізації обробника подій для select
  initializeSelectChangeListener();

/*---------------------------------------------------------------------------------*/
  initializeEventHandlers();

  // Викликаємо ініціалізацію для першого select
  //initializeDynamicSelect();

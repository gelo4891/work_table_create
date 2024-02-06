const elements = {
  select_PB_YDO: getElementById('html-select-PB-YDO'),
  loadingKrok2: getElementById('loading-krok1'),
  loadingKrok2Select: getElementById('html-loading-krok2-select'),
  searchInput: getElementById('searchInput'),
  PhpSelectMenu: getElementById('PhpSelectMenu'),
  krok2SQL: getElementById('html-blok3_dani_user'),
  HtmlUserInfo: getElementById('UserInfo'),
  resultDiv: getElementById('resultDiv'),
  url: '/WC_ALL_Modules/5_Slyshbovi_roli/5_4_Slyshbovi_roli_PHP_Select.php', // Додайте URL як новий параметр  
  swichKrok1: 'rozblok-loading-krok1',
  swichKrok2: 'select-date-pib',
  swichKrok3: 'select-date-pidrozdil',
  swichKrok4: 'insert-upadate-date',  
};

const elementsClik = {
  submitBtn: getElementById('php-submit-btn'),
  inputeDate: getElementById('krok2-data'),
  inputeNomer: getElementById('krok2-nomer'),    
  selectPidSys: getElementById('html-select-PID-sys')  
};

// Зовнішній об'єкт для зберігання стану
const state = {
  responseData1: null,
};

function sendRequestAndUpdate(options) {
  const xhr = new XMLHttpRequest();
  xhr.open('POST', options.url, true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

  xhr.onload = function () {
    if (xhr.status === 200) {
      // Перевірка, чи передано функцію для оновлення
      if (options.updateElement) {
        if (options.handleJsonResponse) {
          try {
            const responseData = JSON.parse(xhr.responseText);
            state.responseData1 = responseData; // Оновлення стану
            options.handleJsonResponse(responseData);
          } catch (error) {
              console.log('Raw response:', xhr.responseText);
          }
      } else {
        options.updateElement.innerHTML = xhr.responseText;
        initializeDynamicSelect('PhpSelectMenu');
      }
      }
    }
  };

  const paramsArray = options.paramsArr.map(param => `${param.name}=${encodeURIComponent(param.value)}`);
  const paramsString = paramsArray.join('&');

  xhr.send(`codes=${encodeURIComponent(options.codesValue)}&${paramsString}`);
}

function generateHtmlFromData(data) {
  // Перевірка, чи data - це масив
  if (Array.isArray(data)) {
    // Отримання елементу для виведення даних
    const userInfoElement = elements.HtmlUserInfo;

    // Перевірка, чи елемент існує
    if (userInfoElement) {
      // Отримання таблиці, якщо вона вже існує
      const existingTable = userInfoElement.querySelector('table');

      // Очищення вмісту таблиці, якщо вона вже існує
      if (existingTable) {
        existingTable.innerHTML = '';
      }

      // Якщо таблиці не існує, то створюємо нову
      const table = existingTable || document.createElement('table');
      table.id = 'phpTableUserDate';

      // Створення рядка заголовків
      const headerRow = document.createElement('tr');
      const customHeaders = ['Дата інформації', 'Індекс', 'ПІБ', 'Підрозділ', 'Посада','дата прийняття на роботу'];

      customHeaders.forEach(headerText => {
        const headerCell = document.createElement('th');
        headerCell.textContent = headerText;
        headerRow.appendChild(headerCell);
      });

      table.appendChild(headerRow);

      // Прохід по кожному елементу масиву
      data.forEach(row => {
        // Створення рядка даних
        const dataRow = document.createElement('tr');

        // Прохід по кожному полю у рядку
        for (const column in row) {
          if (row.hasOwnProperty(column)) {
            // Створення комірки для кожного поля
            const dataCell = document.createElement('td');
            const columnValue = row[column];
            dataCell.innerHTML = `${columnValue}`;
            dataRow.appendChild(dataCell);
          }
        }

        table.appendChild(dataRow);
      });

      // Додавання таблиці до елементу
      userInfoElement.appendChild(table);
    } else {
      console.error('Елемент UserInfo не знайдено.');
    }
  } else {
    console.error('Неправильний формат даних. Очікується масив.');
  }
}

function initializeEventHandlers() {
  const paramsArray = [];
   
  sendRequestAndUpdate({
        url: elements.url, // Використовуйте URL з об'єкта elements
        updateElement: elements.loadingKrok2Select,
        codesValue: elements.swichKrok1,
        paramsArr: paramsArray
      }
     );

      initializeDynamicSelect('PhpSelectMenu');

  elements.searchInput.addEventListener('input', filterSelectOptions);
  elements.searchInput.addEventListener('focus', () => openSelectOptions('PhpSelectMenu'));
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

function openSelectOptions(ID_PhpSelectMenu) {
  const SIZE_PhpSelectMenu = getElementById(ID_PhpSelectMenu);
  if (SIZE_PhpSelectMenu) {
    SIZE_PhpSelectMenu.size = 5;
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

      const paramsArrayPib = [
        { name: 'PIB', value: selectedValue },
      ];
  
      /*відображаємо дані про службові*/
      sendRequestAndUpdate({
        url: elements.url, // Використовуйте URL з об'єкта elements
        updateElement: elements.krok2SQL,
        codesValue: elements.swichKrok2,
        paramsArr: paramsArrayPib
      });

      sendRequestAndUpdate({
        url: elements.url, // Використовуйте URL з об'єкта elements
        updateElement: elements.HtmlUserInfo,
        codesValue: elements.swichKrok3,
        paramsArr: paramsArrayPib,
        handleJsonResponse: generateHtmlFromData
      });

      /*---------------------------------------------------------------------------------*/
     
      // Викликати функцію showHideHiddenBlock зі значенням
      showHideHiddenBlock(IdSelectValue);
    });
  }
}

function showHideHiddenBlock(selectedDynamicValue) {
  getElementById('html-input-date').style.display = selectedDynamicValue !== '' ? 'block' : 'none';
  const paramsArray = []; // Опціонально, якщо є параметри для передачі
  
  sendRequestAndUpdate({
    url: elements.url, // Використовуйте URL з об'єкта elements
    updateElement: elements.loadingKrok2Select,
    codesValue: elements.swichKrok1,
    paramsArr: paramsArray
  });
  
  filterSelectOptions();
}

function filterSelectOptions() {
  const searchTerm = getElementById('searchInput').value.toLowerCase();
  document.querySelectorAll('.select-option').forEach(option => option.style.display = option.textContent.toLowerCase().includes(searchTerm) ? 'block' : 'none');
}

function clickButton() {

  elementsClik.inputeDate.addEventListener('input', checkButtonState);
  elementsClik.inputeNomer.addEventListener('input', checkButtonState);
  elementsClik.selectPidSys.addEventListener('change', checkButtonState);
 
  elementsClik.submitBtn.addEventListener('click', () => {
    
    //console.log(state.responseData1);///////// тут зміни 
    //console.log(state.responseData1[0])///////// тут зміни 
      
    const paramsArray = [
      { name: 'SL_DATE', value: elementsClik.inputeDate.value },
      { name: 'SL_NUMBER', value: elementsClik.inputeNomer.value },
      { name: 'SL_SYSTEM', value: elementsClik.selectPidSys.value },
    ];
    
    const responseData = state.responseData1[0];
    
    // Додавання всіх полів з responseData до paramsArray
    for (const key in responseData) {
      if (Object.prototype.hasOwnProperty.call(responseData, key)) {        
        const customFieldName = getCustomFieldName(key);
        paramsArray.push({ name: key, value: responseData[key] });
      }
    }

    // Тепер формуємо confirmationMessage на основі paramsArray
    let confirmationMessage = `Ви впевнені, що хочете зберегти дані?`;

    // Додавання інформації з paramsArray до confirmationMessage
    for (const param of paramsArray) {
      const customFieldName = getCustomFieldName(param.name);
      confirmationMessage += `
        ${customFieldName}: ${param.value}
      `;
    }
      //console.log(paramsArray);

    // Виклик вікна підтвердження з інформацією
    if (window.confirm(confirmationMessage)) { 

      sendRequestAndUpdate({
        url: elements.url, // Використовуйте URL з об'єкта elements
        updateElement: elements.resultDiv,
        codesValue: elements.swichKrok4,
        paramsArr: paramsArray,
      });

      
 
      // Очистка введених даних
      elementsClik.inputeDate.value = '';
      elementsClik.inputeNomer.value = '';
      elementsClik.selectPidSys.value = '0';
      elementsClik.submitBtn.disabled = true;
    }
  });

  checkButtonState();
}

// Функція для визначення власної назви за ключем
function getCustomFieldName(key) {
  // Тут ви можете встановити власні правила для визначення власних назв за ключами
  // Наприклад, можна використовувати об'єкт для відображення ключів на власні назви
  const customFieldNames = {
    SL_DATE: 'Дата  службової ',
    SL_NUMBER: 'Номер службової №',
    SL_SYSTEM: 'Система ',
    IP_SHTAT_MONTH: 'Оновлено дані ',
    IP_SHTAT_INDEX: 'Індекс підрозділу',
    IP_SHTAT_NAME_PIDR: 'Назва підрозділу',
    IP_SHTAT_PIB: 'PIB',
    IP_SHTAT_POSADA: 'Посада',
    IP_SHTAT_DATE_START: 'Почав працювати з ',
  };

  // Перевірка, чи існує власна назва для даного ключа
  return customFieldNames[key] || key;
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
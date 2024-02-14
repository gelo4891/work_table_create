const elements = {
  div_blok_rez: document.getElementById('blok-rez'),
  url: '/WC_ALL_Modules/6_Slyshbovi_roli_vuborki/6_4_Slyshbovi_roli_PHP_Select.php', // Додайте URL як новий параметр   
  swichKrok1: 'switch-select-all', 
};

const paramsArrayTEST = [
  { name: 'PIB', value: 'test' },
];

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
      }
      }
    }
  }; 

  const paramsArray = options.paramsArr.map(param => `${param.name}=${encodeURIComponent(param.value)}`);
  const paramsString = paramsArray.join('&');

  xhr.send(`codes=${encodeURIComponent(options.codesValue)}&${paramsString}`);
}

      sendRequestAndUpdate({
        url: elements.url, // Використовуйте URL з об'єкта elements
        updateElement: elements.div_blok_rez,
        codesValue: elements.swichKrok1,
        paramsArr: paramsArrayTEST,
      });    
 

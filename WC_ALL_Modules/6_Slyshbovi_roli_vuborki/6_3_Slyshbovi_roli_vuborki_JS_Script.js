const elements = {
  div_blok_rez: document.getElementById('blok-rez'),
  url: '/WC_ALL_Modules/6_Slyshbovi_roli_vuborki/6_4_Slyshbovi_roli_PHP_Select.php',
  swichKrok1: 'switch-select-all',
  exportBtn: document.getElementById('ButtonSave'),
  paramsArrayTEST: [
    { name: 'PIB', value: 'test' },
  ],
};

var inputFields;
var selectSystem;
var selectPIB;

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
      if (options.updateElement) {
        if (options.handleJsonResponse) {
          try {
            const responseData = JSON.parse(xhr.responseText);
            state.responseData1 = responseData;
            options.handleJsonResponse(responseData);
          } catch (error) {
            console.log('Raw response:', xhr.responseText);
          }
        } else {
          options.updateElement.innerHTML = xhr.responseText;
           // Додайте обробник подій після оновлення DOM
           handleInputFields();
        }
      }
    }
  };

  const paramsArray = options.paramsArr.map(param => `${param.name}=${encodeURIComponent(param.value)}`);
  const paramsString = paramsArray.join('&');

  xhr.send(`codes=${encodeURIComponent(options.codesValue)}&${paramsString}`);
}

function exportTableToExcel(tableId, filename) {
  var table = document.getElementById(tableId);
  var html = table.outerHTML;
  var blob = new Blob([html], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

  var a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = filename + '.xls';
  a.click();
}

function filterTable() {
  var rows = document.getElementById('dani-slugbova').querySelectorAll('tr');

  for (var i = 1; i < rows.length; i++) {
    var showRow = true;

    var inputValuePIB = selectPIB.value.toLowerCase();
    var cellValuePIB = rows[i].cells[0].innerText.toLowerCase();

    if (cellValuePIB.indexOf(inputValuePIB) === -1) {
      showRow = false;
    }

    for (var j = 1; j < inputFields.length; j++) {
      var inputValue = inputFields[j].value.toLowerCase();
      var cellValue = rows[i].cells[j].innerText.toLowerCase();

      if (cellValue.indexOf(inputValue) === -1) {
        showRow = false;
        break;
      }
    }

    var selectedSystem = selectSystem.value;
    var systemCellValue = rows[i].cells[6].innerText.toLowerCase();

    if (selectedSystem !== '0' && systemCellValue.indexOf(selectedSystem) === -1) {
      showRow = false;
    }

    rows[i].style.display = showRow ? '' : 'none';
  }
}

function handleInputFields() {
  inputFields = document.querySelectorAll('#div-dani input[type="text"]');
  selectSystem = document.getElementById('select-system');
  selectPIB = document.getElementById('select-PIB');

  if (selectSystem && selectPIB) {
    inputFields.forEach(function (inputField) {
      inputField.addEventListener('input', filterTable);
    });

    selectSystem.addEventListener('change', filterTable);
    selectPIB.addEventListener('input', filterTable);
  } else {
    console.error("Елемент select-system або select-PIB не знайдено!");
  }
}

sendRequestAndUpdate({
  url: elements.url,
  updateElement: elements.div_blok_rez,
  codesValue: elements.swichKrok1,
  paramsArr: elements.paramsArrayTEST,
});
    
// Додати обробник подій на кнопку
document.getElementById('ButtonSave').addEventListener('click', function() {
  exportTableToExcel('dani-slugbova', 'results');
});


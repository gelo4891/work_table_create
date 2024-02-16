const elements = {
  blok_select: document.getElementById('blok_select'),
  div_blok_rez: document.getElementById('blok-rez'),
  url: '/WC_ALL_Modules/6_Slyshbovi_roli_vuborki/6_4_Slyshbovi_roli_PHP_Select.php',
  swichKrok1: 'switch-select-all',
  swichKrok2: 'switch-update',
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
/*--------------------------------------------------------------------------------------*/
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


/*--------------------------------------------------------------------------------------*/
function exportTableToExcel(tableId, filename, excludedColumns) {
  var table = document.getElementById(tableId);

  // Створити копію таблиці та приховати невідображені рядки
  var clonedTable = table.cloneNode(true);
  var rowsToHide = clonedTable.querySelectorAll('tr[style="display: none;"]');
  rowsToHide.forEach(function(row) {
    row.parentNode.removeChild(row);
  });

  // Видалити вказані стовпці
  excludedColumns.forEach(function(column) {
    var columnsToRemove = clonedTable.querySelectorAll('.' + column);
    columnsToRemove.forEach(function(col) {
      col.parentNode.removeChild(col);
    });
  });

  // Видалити всі <input type="text"> елементи
  var inputsToRemove = clonedTable.querySelectorAll('input[type="text"]');
  inputsToRemove.forEach(function(input) {
    input.parentNode.removeChild(input);
  });

  var html = clonedTable.outerHTML;
  var blob = new Blob([html], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });

  var a = document.createElement('a');
  a.href = URL.createObjectURL(blob);
  a.download = filename + '.xls';
  a.click();
}

/*--------------------------------------------------------------------------------------*/
// Функція фільтрації таблиці
function filterTable() {
  var rows = document.getElementById('dani-slugbova').querySelectorAll('tr');

  for (var i = 0; i < rows.length; i++) {
    var showRow = true;

    // Перевірити кожен стовпець на співпадіння
    for (var j = 0; j < inputFields.length; j++) {
      var inputValue = inputFields[j].value.toLowerCase();
      var cellValue = rows[i].cells[j].innerText.toLowerCase();

      if (cellValue.indexOf(inputValue) === -1) {
        showRow = false;
        break;
      }
    }

    // Перевірити відповідний стовпець селекта на співпадіння
    var selectedSystem = selectSystem.value;
    var systemCellValue = rows[i].cells[inputFields.length].innerText.toLowerCase();

    if (selectedSystem !== '0' && systemCellValue.indexOf(selectedSystem.toLowerCase()) === -1) {
      showRow = false;
    }

    // Встановити стиль відображення рядка
    rows[i].style.display = showRow ? '' : 'none';
  }
}

/*--------------------------------------------------------------------------------------*/
// Оновлення функції handleInputFields для обробки select
// Виклик функції для обробки inputFields
function handleInputFields() {
  // Отримати всі поля вводу та select
  inputFields = document.querySelectorAll('#div-dani input[type="text"]');
  selectSystem = document.getElementById('select-system-filter');

  if (selectSystem) {
    // Додати обробник подій на всі поля вводу
    inputFields.forEach(function (inputField) {
      inputField.addEventListener('input', filterTable);
    });

    // Додати обробник подій на select
    selectSystem.addEventListener('change', filterTable);
  } else {
    console.error("Елемент select-system-filter не знайдено!");
  }
}
/*----------------------------------------------*/
// Додати обробник подій на document і делегувати його на кнопки
document.addEventListener('click', function(event) {
  var target = event.target;

  // Обробляти події тільки для кнопок редагування, збереження та скасування
  if (target.classList.contains('edit-btn')) {
    handleEditButton(target);
  } else if (target.classList.contains('save-btn')) {
    handleSaveButton(target);
  } else if (target.classList.contains('cancel-btn')) {
    handleCancelButton(target);
  }
});

/*--------------------------------------------------------------------------------------*/
function handleEditButton(button) {
  var row = button.closest('tr');
  var editableCells = row.querySelectorAll('.editable-column');
  var editInputs = row.querySelectorAll('.edit-input');

  editableCells.forEach(function(cell, index) {
      editInputs[index].value = cell.querySelector('.cell-value').innerText;
  });

  toggleElementVisibility(row, '.editable-column .cell-value', 'none');
  toggleElementVisibility(row, '.editable-column .edit-input', 'inline-block');
  toggleElementVisibility(row, '.edit-btn', 'none');
  toggleElementVisibility(row, '.save-btn', 'inline-block');
  toggleElementVisibility(row, '.cancel-btn', 'inline-block');
}

/*--------------------------------------------------------------------------------------*/
function handleSaveButton(button) {
  var row = button.closest('tr');
  var editInputs = row.querySelectorAll('.edit-input');
  var cellValues = row.querySelectorAll('.cell-value');

  var updatedData = {};
  editInputs.forEach(function(input, index) {
    var columnName = input.getAttribute('data-column-name');
    var columnValue = input.value;
    updatedData[columnName] = columnValue;
    cellValues[index].innerText = columnValue;
  });

  // Отримати ідентифікатор рядка
  var rowId = row.getAttribute('data-row-id');

  // Відправити дані на сервер або виконати інші дії
  toggleElementVisibility(row, '.cell-value', 'inline-block');
  toggleElementVisibility(row, '.edit-input', 'none');
  toggleElementVisibility(row, '.edit-btn', 'inline-block');
  toggleElementVisibility(row, '.save-btn', 'none');
  toggleElementVisibility(row, '.cancel-btn', 'none');

  // Підготувати дані для відправлення на сервер
  var paramsArray1 = [];
  for (var key in updatedData) {
    paramsArray1.push({ name: key, value: updatedData[key] });
  }

  // Додати ідентифікатор рядка до параметрів
  paramsArray1.push({ name: 'data-row-id', value: rowId });

  // Відправити дані на сервер
  sendRequestAndUpdate({
    url: elements.url,
    updateElement: elements.blok_select,
    codesValue: elements.swichKrok2,
    paramsArr: paramsArray1,
  });
}



/*--------------------------------------------------------------------------------------*/
function handleCancelButton(button) {
  var row = button.closest('tr');

  toggleElementVisibility(row, '.cell-value', 'inline-block');
  toggleElementVisibility(row, '.edit-input', 'none');
  toggleElementVisibility(row, '.edit-btn', 'inline-block');
  toggleElementVisibility(row, '.save-btn', 'none');
  toggleElementVisibility(row, '.cancel-btn', 'none');
}

function toggleElementVisibility(row, selector, displayValue) {
  row.querySelectorAll(selector).forEach(function(element) {
    element.style.display = displayValue;
  });
}


/*----------------------------------------------*/
sendRequestAndUpdate({
  url: elements.url,
  updateElement: elements.div_blok_rez,
  codesValue: elements.swichKrok1,
  paramsArr: elements.paramsArrayTEST,
});
    
// Додати обробник подій на кнопку
document.getElementById('ButtonSave').addEventListener('click', function() {
    var excludedColumns = ['exclude-from-export'];
    exportTableToExcel('dani-slugbova', 'results', excludedColumns);

});


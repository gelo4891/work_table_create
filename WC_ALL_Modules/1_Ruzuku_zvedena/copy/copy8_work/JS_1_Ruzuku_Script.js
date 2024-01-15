window.addEventListener('load', function() {
  var submitBtn = document.getElementById('submit-btn');
  var codeInput = document.getElementById('code-input');
  var codeTable = document.getElementById('code-table');
  var exportBtn = document.getElementById('export-btn');
  var loadingOverlay = document.getElementById('loading-overlay');

  submitBtn.addEventListener('click', function() {
    var codes = codeInput.value.trim();
    if (codes === '') {
      codeTable.innerHTML = '<p class="error">Будь ласка, введіть коди платників.</p>';
      return;
    }

    loadingOverlay.style.display = 'block';

    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/WC_ALL_Modules/1_Ruzuku_zvedena/PHP_1_Ruzuku.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = xhr.responseText;
        codeTable.innerHTML = response;
        exportBtn.style.display = 'block';
        exportBtn.setAttribute('data-codes', codes);
        loadingOverlay.style.display = 'none';
      }
    };
    xhr.send('codes=' + encodeURIComponent(codes));
  });

  exportBtn.addEventListener('click', function() {
    var codes = exportBtn.getAttribute('data-codes');
    var htmlContent = codeTable.innerHTML;

    var blob = new Blob([htmlContent], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
    var url = URL.createObjectURL(blob);
    var a = document.createElement('a');
    a.href = url;
    a.download = 'results.xls';
    a.click();
    URL.revokeObjectURL(url);
  });
});

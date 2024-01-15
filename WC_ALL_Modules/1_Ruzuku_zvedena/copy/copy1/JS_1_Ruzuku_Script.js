window.addEventListener('load', function() {
  var submitBtn = document.getElementById('submit-btn');
  var codeInput = document.getElementById('code-input');
  var codeTable = document.getElementById('code-table');

  submitBtn.addEventListener('click', function() {
    var codes = codeInput.value;
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'PHP_1_Ruzuku.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = xhr.responseText;
        codeTable.innerHTML = response;
      }
    };
    xhr.send('codes=' + encodeURIComponent(codes));
  });
});

class DataFetcher {
    constructor(buttonId, inputId, resultContainerId) {
      this.buttonId = buttonId;
      this.inputId = inputId;
      this.resultContainerId = resultContainerId;
      this.loadingOverlayId = 'loading-overlay';
  
      this.initializeEventHandlers();
    }
  
    fetchData() {
      this.showLoadingOverlay();
  
      var button = document.getElementById(this.buttonId);
      var file = button.dataset.file;
      var params = document.getElementById(this.inputId).value;
  
      var url = file + '?Push_date=' + params;
  
      fetch(url)
          .then(response => response.text())
          .then(data => {
              document.getElementById(this.resultContainerId).innerHTML = data;
              this.hideLoadingOverlay();
          })
          .catch(error => {
              console.error('Помилка AJAX-запиту:', error);
              this.hideLoadingOverlay();
          });
    }
  
    showLoadingOverlay() {
      var loadingOverlay = this.createLoadingOverlay();
      document.body.appendChild(loadingOverlay);
    }
  
    hideLoadingOverlay() {
      var loadingOverlay = document.getElementById(this.loadingOverlayId);
      if (loadingOverlay) {
        document.body.removeChild(loadingOverlay);
      }
    }
  
    createLoadingOverlay() {
        var loadingOverlay = document.createElement('div');
        loadingOverlay.id = this.loadingOverlayId;
        loadingOverlay.style.position = 'fixed';
        loadingOverlay.style.top = '0';
        loadingOverlay.style.left = '0';
        loadingOverlay.style.width = '100%';
        loadingOverlay.style.height = '100%';
        loadingOverlay.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
        loadingOverlay.style.display = 'flex';
        loadingOverlay.style.justifyContent = 'center';
        loadingOverlay.style.alignItems = 'center';
        loadingOverlay.style.zIndex = '9999';
      
        var loadingMessage = document.createElement('div');
        loadingMessage.id = 'loading-message';
        loadingMessage.textContent = 'Зачекайте, виконується запит...';
        loadingMessage.style.position = 'fixed';
        loadingMessage.style.top = '50%';
        loadingMessage.style.left = '50%';
        loadingMessage.style.transform = 'translate(-50%, -50%)';
        loadingMessage.style.width = '300px';
        loadingMessage.style.height = '300px';
        loadingMessage.style.backgroundColor = '#ffffff';
        loadingMessage.style.textAlign = 'center';
        loadingMessage.style.padding = '20px';
        loadingMessage.style.fontSize = '40px';
        loadingMessage.style.display = 'flex';
        loadingMessage.style.flexDirection = 'column';
        loadingMessage.style.justifyContent = 'center';
        loadingMessage.style.alignItems = 'center';
        loadingMessage.style.color = 'red';
        loadingMessage.style.borderRadius = '30%';
      
        // Додамо анімацію прямо в стилі loadingMessage
        loadingMessage.style.animation = `
          blinkBorder 2s infinite
        `;
      
        // Також створимо стилі @keyframes прямо в коді
        var blinkBorderAnimation = `
          @keyframes blinkBorder {
            0% {
              border: 30px solid chartreuse;
            }
            50% {
              border: 20px solid blue;
            }
            100% {
              border: 10px solid green;
            }
          }
        `;
      
        // Створимо <style> тег для збереження стилів @keyframes
        var styleTag = document.createElement('style');
        styleTag.textContent = blinkBorderAnimation;
        document.head.appendChild(styleTag);
      
        loadingOverlay.appendChild(loadingMessage);
      
        return loadingOverlay;
      }
  
    initializeEventHandlers() {
      var button = document.getElementById(this.buttonId);
      button.addEventListener('click', () => this.fetchData());
    }
  }
  
  // Створення об'єкту DataFetcher з ідентифікаторами елементів
  var dataFetcher = new DataFetcher('fetch-button', 'startDate', 'lowerDiv');
  
  
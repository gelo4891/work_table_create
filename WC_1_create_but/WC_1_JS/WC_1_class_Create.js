class WC_1_ButtonCreator {
  constructor(buttonDataUrl, containerClass) {
    this.buttonDataUrl = buttonDataUrl;
    this.containerClass = containerClass;
  }

  WC_1_createButtons_not_text() {
    fetch(this.buttonDataUrl)
      .then((response) => response.json())
      .then((buttonsData) => {
        const buttonsContainer = document.querySelector(`.${this.containerClass}`);
        buttonsData.forEach((buttonData) => {
          const button = document.createElement("button");
          button.textContent = buttonData.title;
          button.addEventListener("click", () => {
            window.location.href = buttonData.link;
          });
          buttonsContainer.appendChild(button);
        });
      })
      .catch((error) => console.error(error));
  }

  WC_1_createButtons_text() {
    fetch(this.buttonDataUrl)
      .then((response) => response.json())
      .then((buttonsData) => {
        const buttonsContainer = document.querySelector(`.${this.containerClass}`);
        buttonsData.forEach((buttonData) => {
          const button = document.createElement("button");
          button.innerHTML = '<p>' + buttonData.title + '</p>';
         /* button.setAttribute('data-text', buttonData.text);*/
          button.addEventListener("click", () => {
            window.location.href = buttonData.link;
          });
          buttonsContainer.appendChild(button);
        });
      })
      .catch((error) => console.error(error));
  }



}


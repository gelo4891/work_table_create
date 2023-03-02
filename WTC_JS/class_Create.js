class ButtonCreator {
  constructor(buttonDataUrl, containerClass) {
    this.buttonDataUrl = buttonDataUrl;
    this.containerClass = containerClass;
  }

  createButtons() {
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
}


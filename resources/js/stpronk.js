
class stpronk {

  constructor () {
    this.navigation = false;

    this.eventListeners();
  }

  eventListeners() {
    document.querySelectorAll('.navigation__item[data-target]').forEach((element) => {
      element.addEventListener('click', (event) => {
        event.preventDefault();

        if ( ! this.navigation ) {
          return console.log('navigation has not been opened');
        }

        const data = event.target.getAttribute('data-target');

        if (data.startsWith('http')) {
          return window.open(data, '_blank')
        }

        const targetElement = document.querySelector('.' + data);

        if (targetElement) {
          return targetElement.scrollIntoView(true);
        }

        return console.log('"' + data + '" has not been found on the page and is not a link to a other website!')
      }, false);
    });

    document.querySelector('.navigation').addEventListener('mouseenter',  (event) => {
      event.target.classList.add('navigation--active');
      setTimeout(() => {
        this.navigation = true
      }, 200)
    }, false);

    document.querySelector('.navigation').addEventListener('mouseleave',  (event) => {
      event.target.classList.remove('navigation--active');
      this.navigation = false;
    }, false);

    document.querySelector('.intro-wrapper__scroll[data-target]').addEventListener('click', (event) => {
      const targetElement = event.target.getAttribute('data-target');

      document.querySelector('.' + targetElement).scrollIntoView(true);
    }, false);
  }
}

new stpronk();
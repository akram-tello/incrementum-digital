(function(window) {
  function ready(fn) {
    if (document.attachEvent ? document.readyState === "complete" : document.readyState !== "loading"){
      fn();
    } else {
      document.addEventListener('DOMContentLoaded', fn);
    }
  }

}(window));

// mobile menu

let hamburger = {
  nav: document.querySelector('.site-header'),
  navToggle: document.querySelector('.page-header-menu-button'),

  initialize() {
    this.navToggle.addEventListener('click', () => { this.toggle(); });
  },

  toggle() {
    this.navToggle.classList.toggle('active');
    this.nav.classList.toggle('active');
  },
};

hamburger.initialize();

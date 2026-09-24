/**
 * Medico front-end behaviour, without jQuery.
 *
 * The plugin calls keep the options they always had; ColorlibUI provides
 * drop-in versions of Owl Carousel and AjaxChimp that build the same markup,
 * so the theme's stylesheets apply unchanged.
 */
(function () {
  'use strict';

  var UI = window.ColorlibUI;
  if (!UI) return;

  UI.enhanceSelects('select');

  // menu fixed js code
  window.addEventListener('scroll', function () {
    var fixed = window.pageYOffset + 1 > 50;
    UI.toElements('.main_menu').forEach(function (menu) {
      menu.classList.toggle('menu_fixed', fixed);
      menu.classList.toggle('animated', fixed);
      menu.classList.toggle('fadeInDown', fixed);
    });
  }, { passive: true });

  UI.owl('.client_review_part', {
    items: 1,
    loop: true,
    dots: true,
    autoplay: true,
    autoplayHoverPause: true,
    autoplayTimeout: 5000,
    nav: false,
    smartSpeed: 2000
  });

  //------- Mailchimp js --------//
  UI.ajaxChimp('#mc_embed_signup form');
}());

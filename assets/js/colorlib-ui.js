/**
 * The interactive pieces these themes actually use, without jQuery.
 *
 * It replaces Owl Carousel, Slick, Magnific Popup, jQuery Nice Select,
 * CounterUp with the Waypoints library it needed, and WOW.js, which together
 * weigh about 40KB gzipped before jQuery itself is counted.
 * Those libraries are general-purpose; the themes use a narrow slice of them:
 * a looping carousel, a slider with a thumbnail strip, a lightbox for images
 * and video embeds, a styled select, numbers that count up and elements that
 * animate in as they scroll into view.
 *
 * Markup is read from the same class names and data attributes the old
 * plugins used, so templates do not change.
 *
 * Each piece is optional: if the markup is not on the page, nothing runs.
 */
(function () {
  'use strict';

  var PREFERS_REDUCED = window.matchMedia
    ? window.matchMedia('(prefers-reduced-motion: reduce)').matches
    : false;

  /* ------------------------------------------------------------------ *
   * Carousel
   *
   * One track, any number of slides, optional dots, arrows and autoplay.
   * Slides are moved with a transform on the track, so there is no layout
   * work per frame.
   * ------------------------------------------------------------------ */

  function Carousel(root, options) {
    var opts = Object.assign(
      { perView: 1, loop: true, autoplay: 0, dots: false, arrows: false, gap: 0 },
      options || {}
    );

    var slides = Array.prototype.slice.call(root.children);
    if (slides.length === 0) return null;

    var viewport = document.createElement('div');
    var track = document.createElement('div');
    viewport.className = 'cl-carousel__viewport';
    track.className = 'cl-carousel__track';

    root.classList.add('cl-carousel');
    slides.forEach(function (slide) {
      slide.classList.add('cl-carousel__slide');
      track.appendChild(slide);
    });
    viewport.appendChild(track);
    root.appendChild(viewport);

    var index = 0;
    var timer = null;
    var dotsWrap = null;

    function perView() {
      // A number, or a map of minimum widths to a number.
      if (typeof opts.perView === 'number') return opts.perView;
      var width = window.innerWidth;
      var best = 1;
      Object.keys(opts.perView)
        .map(Number)
        .sort(function (a, b) { return a - b; })
        .forEach(function (bp) {
          if (width >= bp) best = opts.perView[bp];
        });
      return best;
    }

    function maxIndex() {
      return Math.max(0, slides.length - perView());
    }

    function layout() {
      var n = perView();
      var basis = 'calc(' + (100 / n) + '% - ' + (opts.gap * (n - 1) / n) + 'px)';
      slides.forEach(function (slide) {
        slide.style.flex = '0 0 ' + basis;
        slide.style.maxWidth = basis;
        slide.style.marginRight = opts.gap + 'px';
      });
      go(Math.min(index, maxIndex()), true);
    }

    function go(next, instant) {
      var limit = maxIndex();
      if (next < 0) next = opts.loop ? limit : 0;
      if (next > limit) next = opts.loop ? 0 : limit;
      index = next;

      var slide = slides[0];
      var step = slide.getBoundingClientRect().width + opts.gap;
      track.style.transition = instant || PREFERS_REDUCED ? 'none' : 'transform .45s ease';
      track.style.transform = 'translate3d(' + -(step * index) + 'px,0,0)';

      if (dotsWrap) {
        Array.prototype.forEach.call(dotsWrap.children, function (dot, i) {
          dot.classList.toggle('is-active', i === index);
          dot.setAttribute('aria-selected', i === index ? 'true' : 'false');
        });
      }
      root.dispatchEvent(new CustomEvent('cl:change', { detail: { index: index } }));
    }

    if (opts.dots) {
      dotsWrap = document.createElement('div');
      dotsWrap.className = 'cl-carousel__dots';
      dotsWrap.setAttribute('role', 'tablist');
      slides.forEach(function (_, i) {
        var dot = document.createElement('button');
        dot.type = 'button';
        dot.className = 'cl-carousel__dot';
        dot.setAttribute('role', 'tab');
        dot.setAttribute('aria-label', 'Go to slide ' + (i + 1));
        dot.addEventListener('click', function () { go(i); restart(); });
        dotsWrap.appendChild(dot);
      });
      root.appendChild(dotsWrap);
    }

    if (opts.arrows) {
      ['prev', 'next'].forEach(function (dir) {
        var button = document.createElement('button');
        button.type = 'button';
        button.className = 'cl-carousel__arrow cl-carousel__arrow--' + dir;
        button.setAttribute('aria-label', dir === 'prev' ? 'Previous slide' : 'Next slide');
        button.innerHTML = dir === 'prev' ? '&#8249;' : '&#8250;';
        button.addEventListener('click', function () {
          go(index + (dir === 'next' ? 1 : -1));
          restart();
        });
        root.appendChild(button);
      });
    }

    function restart() {
      if (timer) clearInterval(timer);
      if (opts.autoplay > 0 && !PREFERS_REDUCED) {
        timer = setInterval(function () { go(index + 1); }, opts.autoplay);
      }
    }

    // Pause while the pointer is over it, and while the tab is hidden.
    root.addEventListener('mouseenter', function () { if (timer) clearInterval(timer); });
    root.addEventListener('mouseleave', restart);
    document.addEventListener('visibilitychange', function () {
      if (document.hidden) { if (timer) clearInterval(timer); } else { restart(); }
    });

    // Touch, so a phone can swipe.
    var startX = null;
    viewport.addEventListener('touchstart', function (e) { startX = e.touches[0].clientX; }, { passive: true });
    viewport.addEventListener('touchend', function (e) {
      if (startX === null) return;
      var dx = e.changedTouches[0].clientX - startX;
      if (Math.abs(dx) > 40) go(index + (dx < 0 ? 1 : -1));
      startX = null;
      restart();
    }, { passive: true });

    window.addEventListener('resize', debounce(layout, 150));

    layout();
    restart();

    return { go: go, get index() { return index; }, length: slides.length, el: root };
  }

  /* ------------------------------------------------------------------ *
   * Lightbox
   *
   * Images and video embeds. Replaces Magnific Popup, which the themes use
   * for exactly these two cases.
   * ------------------------------------------------------------------ */

  function Lightbox() {
    var overlay = null;
    var group = [];
    var at = 0;

    function close() {
      if (!overlay) return;
      document.removeEventListener('keydown', onKey);
      overlay.remove();
      overlay = null;
      document.documentElement.style.overflow = '';
    }

    function onKey(e) {
      if (e.key === 'Escape') close();
      if (e.key === 'ArrowRight') show(at + 1);
      if (e.key === 'ArrowLeft') show(at - 1);
    }

    function show(i) {
      if (group.length === 0) return;
      at = (i + group.length) % group.length;
      var item = group[at];
      var stage = overlay.querySelector('.cl-lightbox__stage');
      stage.innerHTML = '';

      if (item.type === 'iframe') {
        var frame = document.createElement('iframe');
        frame.src = item.src;
        frame.allow = 'autoplay; fullscreen; picture-in-picture';
        frame.allowFullscreen = true;
        frame.title = item.title || 'Video';
        stage.appendChild(frame);
      } else {
        var img = document.createElement('img');
        img.src = item.src;
        img.alt = item.title || '';
        stage.appendChild(img);
      }
      overlay.querySelector('.cl-lightbox__count').textContent =
        group.length > 1 ? at + 1 + ' / ' + group.length : '';
    }

    function open(items, start) {
      group = items;
      overlay = document.createElement('div');
      overlay.className = 'cl-lightbox';
      overlay.setAttribute('role', 'dialog');
      overlay.setAttribute('aria-modal', 'true');
      overlay.innerHTML =
        '<button type="button" class="cl-lightbox__close" aria-label="Close">&times;</button>' +
        '<button type="button" class="cl-lightbox__nav cl-lightbox__nav--prev" aria-label="Previous">&#8249;</button>' +
        '<div class="cl-lightbox__stage"></div>' +
        '<button type="button" class="cl-lightbox__nav cl-lightbox__nav--next" aria-label="Next">&#8250;</button>' +
        '<p class="cl-lightbox__count"></p>';

      overlay.addEventListener('click', function (e) {
        if (e.target === overlay || e.target.classList.contains('cl-lightbox__close')) close();
        if (e.target.classList.contains('cl-lightbox__nav--next')) show(at + 1);
        if (e.target.classList.contains('cl-lightbox__nav--prev')) show(at - 1);
      });

      document.body.appendChild(overlay);
      document.documentElement.style.overflow = 'hidden';
      document.addEventListener('keydown', onKey);
      overlay.querySelector('.cl-lightbox__close').focus();

      // Only offer navigation when there is more than one item.
      if (group.length < 2) {
        Array.prototype.forEach.call(overlay.querySelectorAll('.cl-lightbox__nav'), function (b) {
          b.hidden = true;
        });
      }
      show(start);
    }

    return { open: open, close: close };
  }

  /* ------------------------------------------------------------------ *
   * Helpers
   * ------------------------------------------------------------------ */

  function debounce(fn, wait) {
    var t;
    return function () {
      clearTimeout(t);
      t = setTimeout(fn, wait);
    };
  }

  function videoSource(href) {
    var yt = href.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([\w-]+)/);
    if (yt) return 'https://www.youtube.com/embed/' + yt[1] + '?autoplay=1&rel=0';
    var vm = href.match(/vimeo\.com\/(?:video\/)?(\d+)/);
    if (vm) return 'https://player.vimeo.com/video/' + vm[1] + '?autoplay=1';
    return href;
  }


  /* ------------------------------------------------------------------ *
   * Select
   *
   * Builds the same markup jQuery Nice Select produced, because the themes
   * style that structure: .nice-select > .current, and a .list of .option.
   * The original select stays in the DOM and keeps carrying the value, so
   * forms submit exactly as before and assistive technology still sees it.
   * ------------------------------------------------------------------ */

  function enhanceSelect(select) {
    if (select.dataset.clEnhanced) return;
    select.dataset.clEnhanced = '1';

    var wrap = document.createElement('div');
    wrap.className = 'nice-select ' + (select.className || '');
    wrap.tabIndex = 0;
    wrap.setAttribute('role', 'button');
    wrap.setAttribute('aria-haspopup', 'listbox');
    wrap.setAttribute('aria-expanded', 'false');

    var current = document.createElement('span');
    current.className = 'current';

    var list = document.createElement('ul');
    list.className = 'list';
    list.setAttribute('role', 'listbox');

    Array.prototype.forEach.call(select.options, function (option) {
      var li = document.createElement('li');
      li.className = 'option' + (option.selected ? ' selected' : '') +
        (option.disabled ? ' disabled' : '');
      li.textContent = option.textContent;
      li.dataset.value = option.value;
      li.setAttribute('role', 'option');
      li.setAttribute('aria-selected', option.selected ? 'true' : 'false');

      li.addEventListener('click', function (e) {
        // The wrapper toggles on click; without this the choice would bubble
        // up and reopen the list it just closed.
        e.stopPropagation();
        if (option.disabled) return;
        select.value = option.value;
        select.dispatchEvent(new Event('change', { bubbles: true }));
        sync();
        wrap.classList.remove('open');
        wrap.setAttribute('aria-expanded', 'false');
      });
      list.appendChild(li);
    });

    function sync() {
      var chosen = select.options[select.selectedIndex];
      current.textContent = chosen ? chosen.textContent : '';
      Array.prototype.forEach.call(list.children, function (li) {
        var on = li.dataset.value === select.value;
        li.classList.toggle('selected', on);
        li.setAttribute('aria-selected', on ? 'true' : 'false');
      });
    }

    wrap.addEventListener('click', function () {
      var open = wrap.classList.toggle('open');
      wrap.setAttribute('aria-expanded', open ? 'true' : 'false');
    });
    wrap.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); wrap.click(); }
      if (e.key === 'Escape') { wrap.classList.remove('open'); }
    });
    document.addEventListener('click', function (e) {
      if (!wrap.contains(e.target)) {
        wrap.classList.remove('open');
        wrap.setAttribute('aria-expanded', 'false');
      }
    });
    select.addEventListener('change', sync);

    wrap.appendChild(current);
    wrap.appendChild(list);
    select.parentNode.insertBefore(wrap, select);

    // Kept for the form and for assistive technology, but out of the way.
    select.style.position = 'absolute';
    select.style.width = '1px';
    select.style.height = '1px';
    select.style.opacity = '0';
    select.style.pointerEvents = 'none';

    sync();
  }

  /* ------------------------------------------------------------------ *
   * Running when the page is ready
   *
   * Callers are theme scripts in the footer and inline scripts printed by
   * widgets in the middle of the page; both are safe.
   * ------------------------------------------------------------------ */

  function ready(fn) {
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', fn);
    } else {
      fn();
    }
  }

  function each(selector, fn) {
    ready(function () {
      Array.prototype.forEach.call(document.querySelectorAll(selector), fn);
    });
  }

  /** $('select').niceSelect(), without jQuery. */
  function enhanceSelects(selector) {
    each(selector || 'select', function (select) {
      // Nice Select never handled multiple selects, and neither does this.
      if (select.multiple) return;
      enhanceSelect(select);
    });
  }


  /* ------------------------------------------------------------------ *
   * Counter
   *
   * Replaces jQuery CounterUp and the Waypoints library it depended on.
   * Like CounterUp, the number is read from the element's own text and left
   * untouched until the element scrolls into view; it then counts up from
   * zero and always finishes on the original text. Text that is not a plain
   * number ("24/7") is left alone.
   * ------------------------------------------------------------------ */

  function counter(selector, options) {
    var time = (options && options.time) || 1000;

    each(selector, function (el) {
      if (el.dataset.clCounter) return;
      el.dataset.clCounter = '1';

      var text = el.textContent.trim();
      var plain = text.replace(/,/g, '');
      if (!/^\d+(\.\d+)?$/.test(plain)) return;
      if (PREFERS_REDUCED || !('IntersectionObserver' in window)) return;

      var target = parseFloat(plain);
      var decimals = (plain.split('.')[1] || '').length;
      var commas = /\d,\d/.test(text);

      function format(n) {
        var s = n.toFixed(decimals);
        return commas ? s.replace(/\B(?=(\d{3})+(?!\d))/g, ',') : s;
      }

      var observer = new IntersectionObserver(function (entries) {
        if (!entries[0].isIntersecting) return;
        observer.disconnect();

        var start = null;
        function step(now) {
          if (start === null) start = now;
          var progress = Math.min((now - start) / time, 1);
          el.textContent = progress < 1 ? format(target * progress) : text;
          if (progress < 1) window.requestAnimationFrame(step);
        }
        window.requestAnimationFrame(step);
      });
      observer.observe(el);
    });
  }


  /* ------------------------------------------------------------------ *
   * Reveal on scroll
   *
   * Replaces WOW.js, against the same markup: an element with class "wow"
   * and an animate.css animation class, plus optional data-wow-duration,
   * data-wow-delay and data-wow-iteration. It is hidden until it scrolls
   * into view, then gets the "animated" class.
   *
   * The animation name is held at "none" until then, as WOW did: otherwise
   * the animation has already run (at zero duration) by the time "animated"
   * gives it a real one, and nothing moves. With reduced motion requested,
   * or no IntersectionObserver, elements are simply left visible.
   * ------------------------------------------------------------------ */

  function reveal(selector, options) {
    var offset = (options && options.offset) || 0;
    if (PREFERS_REDUCED || !('IntersectionObserver' in window)) return;

    each(selector || '.wow', function (el) {
      if (el.dataset.clReveal) return;
      el.dataset.clReveal = '1';

      el.style.visibility = 'hidden';
      el.style.animationName = 'none';

      var observer = new IntersectionObserver(function (entries) {
        if (!entries[0].isIntersecting) return;
        observer.disconnect();

        var data = el.dataset;
        if (data.wowDuration) el.style.animationDuration = data.wowDuration;
        if (data.wowDelay) el.style.animationDelay = data.wowDelay;
        if (data.wowIteration) el.style.animationIterationCount = data.wowIteration;
        el.style.animationName = '';
        el.style.visibility = 'visible';
        el.classList.add('animated');
      }, { rootMargin: '0px 0px ' + (-offset) + 'px 0px' });
      observer.observe(el);
    });
  }

  window.ColorlibUI = {
    Carousel: Carousel,
    Lightbox: Lightbox,
    enhanceSelect: enhanceSelect,
    enhanceSelects: enhanceSelects,
    counter: counter,
    reveal: reveal,
    ready: ready,
    videoSource: videoSource,
    debounce: debounce
  };
}());

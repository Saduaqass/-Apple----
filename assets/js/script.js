(() => {
  'use strict';
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.main-nav');
  if (toggle && nav) toggle.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!open));
    nav.classList.toggle('is-open', !open);
  });

  document.querySelectorAll('img[data-fallback="true"]').forEach((image) => {
    const showFallback = () => {
      image.hidden = true;
      const placeholder = image.parentElement?.querySelector('.image-placeholder');
      if (placeholder) placeholder.classList.add('is-visible');
    };
    image.addEventListener('error', showFallback, { once: true });
    if (!image.getAttribute('src')) showFallback();
  });
})();

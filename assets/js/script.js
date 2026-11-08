document.addEventListener('DOMContentLoaded', () => {
  const menuButton = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.main-nav');
  const dropdownButton = document.querySelector('.dropdown-toggle');
  const dropdown = document.querySelector('.nav-dropdown');

  menuButton?.addEventListener('click', () => {
    const open = menuButton.getAttribute('aria-expanded') !== 'true';
    menuButton.setAttribute('aria-expanded', String(open));
    nav?.classList.toggle('is-open', open);
  });

  dropdownButton?.addEventListener('click', () => {
    const open = dropdownButton.getAttribute('aria-expanded') !== 'true';
    dropdownButton.setAttribute('aria-expanded', String(open));
    dropdown?.classList.toggle('is-open', open);
  });

  document.addEventListener('click', (event) => {
    if (dropdown && !dropdown.contains(event.target)) {
      dropdown.classList.remove('is-open');
      dropdownButton?.setAttribute('aria-expanded', 'false');
    }
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
      dropdown?.classList.remove('is-open');
      dropdownButton?.setAttribute('aria-expanded', 'false');
      nav?.classList.remove('is-open');
      menuButton?.setAttribute('aria-expanded', 'false');
    }
  });
});

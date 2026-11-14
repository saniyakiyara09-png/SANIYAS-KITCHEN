document.addEventListener('DOMContentLoaded', () => {
  const toggle = document.querySelector('.menu-toggle');
  const nav = document.querySelector('.main-nav');
  if (toggle && nav) toggle.addEventListener('click', () => nav.classList.toggle('open'));
  document.querySelectorAll('input[type="date"]').forEach(input => {
    if (!input.min) input.min = new Date().toISOString().slice(0, 10);
  });
});

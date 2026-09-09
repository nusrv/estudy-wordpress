document.addEventListener('DOMContentLoaded', function () {
  var button = document.querySelector('.menu');
  var nav = document.querySelector('.top nav');
  if (!button || !nav) return;
  button.addEventListener('click', function () {
    var open = button.getAttribute('aria-expanded') === 'true';
    button.setAttribute('aria-expanded', open ? 'false' : 'true');
    nav.classList.toggle('is-open', !open);
  });
});

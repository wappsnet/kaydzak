import 'bootstrap'

window.addEventListener('scroll', (e) => {
  const headerIcon = document.getElementById('app-header-icon');

  if (headerIcon) {
    const minSize = 50;
    const maxSize = 120;

    const newSize = Math.max(Math.min(maxSize, maxSize - window.scrollY), minSize);

    headerIcon.style.fontSize = `${newSize}px`;
  }
});
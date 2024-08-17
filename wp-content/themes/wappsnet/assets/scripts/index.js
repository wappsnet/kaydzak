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

document.addEventListener('DOMContentLoaded', () => {
  const openSearchButton = document.getElementById('search-open-toggle');
  const closeSearchButton = document.getElementById('search-close-toggle');
  const searchPopup = document.getElementById('search-container');

  if (searchPopup) {
    if (openSearchButton) {
      openSearchButton.addEventListener('click', () => {
        searchPopup.classList.add('show');
        document.documentElement.classList.add('freeze');
      });
    }

    if (closeSearchButton) {
      closeSearchButton.addEventListener('click', () => {
        searchPopup.classList.remove('show');
        document.documentElement.classList.remove('freeze');
      });
    }
  }
  console.log('document is ready');
})
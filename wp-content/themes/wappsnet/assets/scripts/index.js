import 'bootstrap'
import axios from "axios";
import qs from "qs";

const Api = {
  search: {
    endpoint: '/wp-admin/admin-ajax.php',
    action: 'wp_search'
  },
  subscribe: {
    endpoint: '/wp-admin/admin-ajax.php',
    action: 'wp_subscribe'
  }
}

const Core = {
  initSearch: () => {
    const searchInput = document.getElementById('wp-search-input')
    const openSearchButton = document.getElementById('search-open-toggle');
    const closeSearchButton = document.getElementById('search-close-toggle');
    const searchPopup = document.getElementById('search-container');
    const searchOutPut = document.getElementById('wp-search-output');

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

    if (searchInput) {
      searchInput.addEventListener('input', (e) => {
        if (e.target.value.length > 2) {
          searchOutPut.classList.add('loading');
          axios.post(Api.search.endpoint, qs.stringify({
            action: Api.search.action,
            keyword: e.target.value,
          })).then((response) => {
            if (response.data.content) {
              searchOutPut.innerHTML = response.data.content;
            }
          }).finally(() => {
            searchOutPut.classList.remove('loading');
          });
        } else {
          searchOutPut.innerHTML = '';
          searchOutPut.classList.remove('loading');
        }
      })
    }
  },
  initSubscribe: () => {
    const subscribeInput = document.getElementById('wp-subscribe-input');
    const subscribeButton = document.getElementById('wp-subscribe-button');

    subscribeButton.addEventListener('click', () => {
      const value = subscribeInput.value();
      axios.post(Api.subscribe.endpoint, qs.stringify({
        action: Api.subscribe.action,
        email: value,
      })).then((response) => {
        if (response.data.content) {
          console.log(response.data.content);
        }
      })
    })
  }
}

window.addEventListener('scroll', () => {
  const headerIcon = document.getElementById('app-header-icon');

  if (headerIcon) {
    const minSize = 50;
    const maxSize = 150;

    const newSize = Math.max(Math.min(maxSize, maxSize - window.scrollY), minSize);

    headerIcon.style.fontSize = `${newSize}px`;
  }
});

document.addEventListener('DOMContentLoaded', () => {
  Core.initSearch();
  Core.initSubscribe();
})
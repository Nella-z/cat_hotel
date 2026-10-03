
const menuBtn = document.querySelector('.menu__btn');
const menu = document.querySelector('.menu__list');

menuBtn.addEventListener('click', () => {
    menu.classList.toggle('active');
});

const swiper = new Swiper('.room__swiper', {
 slidesPerView: 1,
 spaceBetween: 20,
  loop: true,
          pagination: {
    el: '.room__swiper-pagination',
  },

  navigation: {
    nextEl: '.swiper__arrow-next',
    prevEl: '.swiper__arrow-prev',
  },
});

const comment__swiper = new Swiper('.comment__swiper', {
 slidesPerView: 1,
 spaceBetween: 20,
  loop: true,
       breakpoints: {
          480: {
            slidesPerView: 2,
          },
          1024: {
            slidesPerView: 3,
          },
          1920: {
            slidesPerView: 4,
          },
        },
          pagination: {
    el: '.comment__swiper-pagination',
  },

  navigation: {
    nextEl: '.swiper__arrow-next',
    prevEl: '.swiper__arrow-prev',
  },
});
var map = L.map('map').setView([59.939748, 30.323762], 50);

  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
  }).addTo(map);

 const icon = L.icon({ iconUrl: './images/map.svg' });

L.marker([59.939748, 30.323762], { icon })
  .addTo(map)
  .openPopup();
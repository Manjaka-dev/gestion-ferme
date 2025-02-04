const carousel = document.querySelector(".carousel");
const rightBtn = document.querySelector(".right-carousel-btn");
const leftBtn = document.querySelector(".left-carousel-btn");

rightBtn.addEventListener('click', () => {
    carousel.style.transform = 'translateX(200px)';
});

leftBtn.addEventListener('click', () => {
    carousel.style.transform = 'translateX(-200px)';
});




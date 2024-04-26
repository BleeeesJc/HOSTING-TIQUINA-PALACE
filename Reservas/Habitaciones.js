let sliders = {
  roomCarousel1: 0,
  roomCarousel2: 0,
  roomCarousel3: 0,
  roomCarousel4: 0
};

function plusSlides(n, carouselId) {
  sliders[carouselId] += n;
  showSlides(sliders[carouselId], carouselId);
}

function showSlides(n, carouselId) {
  let slides = document.querySelectorAll('#' + carouselId + ' .carousel-slide');
  if (n >= slides.length) { sliders[carouselId] = 0; }
  if (n < 0) { sliders[carouselId] = slides.length - 1; }

  for (let slide of slides) {
      slide.style.display = "none";  
  }
  slides[sliders[carouselId]].style.display = "block";  
}
document.addEventListener('DOMContentLoaded', function() {
  showSlides(sliders.roomCarousel1, 'roomCarousel1');
  showSlides(sliders.roomCarousel2, 'roomCarousel2');
  showSlides(sliders.roomCarousel3, 'roomCarousel3');
  showSlides(sliders.roomCarousel4, 'roomCarousel4');
});
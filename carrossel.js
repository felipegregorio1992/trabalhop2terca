const carouselSlide = document.querySelector('.carousel-slide');
    const carouselImages = document.querySelectorAll('.carousel-slide img');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');

    let counter = 0;
    const slideWidth = carouselImages[0].clientWidth;

    function nextSlide() {
      if (counter >= carouselImages.length - 1) {
        counter = 0;
      } else {
        counter++;
      }
      carouselSlide.style.transform = `translateX(${-slideWidth * counter}px)`;
    }

    setInterval(nextSlide, 3000); // Troca de imagem a cada 3 segundos

    prevBtn.addEventListener('click', () => {
      if (counter <= 0) return;
      counter--;
      carouselSlide.style.transform = `translateX(${-slideWidth * counter}px)`;
    });

    nextBtn.addEventListener('click', () => {
      if (counter >= carouselImages.length - 1) return;
      counter++;
      carouselSlide.style.transform = `translateX(${-slideWidth * counter}px)`;
    });
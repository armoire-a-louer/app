<template>
  <swiper
    :spaceBetween="50"
    :centeredSlides="true"
    :pagination="{
      clickable: true,
    }"
    :grabCursor="true"
    :modules="modules"
    :loop="true"
    :slidesPerView="'auto'"
    class="mySwiper"
  >
    <swiper-slide class="slider-item">
        <img src="/images/feedback5.jpg" alt="Élise">
        <h3 class="title text-center">Élise</h3>
        <p class="text-center w-5/6 md:w-4/6 lg:3/6">
            "Le concept de L'Armoire à Louer est brillant et leur exécution est impeccable. La variété des marques, des tailles et des styles disponibles est impressionnante. Le processus de réservation est simple et l'option de paiement sécurisé est un plus indéniable."
        </p>
    </swiper-slide>

    <swiper-slide class="slider-item">
        <img src="/images/feedback1.jpg" alt="Jeanne">
        <h3 class="title text-center">Jeanne</h3>
        <p class="text-center w-5/6 md:w-4/6 lg:3/6">
            "L'Armoire à Louer a complètement révolutionné ma façon de faire du shopping. J'adore l'idée de pouvoir louer des vêtements de marque pour des occasions spéciales sans avoir à dépenser une fortune. Le service client est exceptionnel, toujours prêt à aider."
        </p>
    </swiper-slide>

    <swiper-slide class="slider-item">
        <img src="/images/feedback2.jpg" alt="Pierre">
        <h3 class="title text-center">Pierre</h3>
        <p class="text-center w-5/6 md:w-4/6 lg:3/6">
            "Je suis absolument ravi de l'expérience que j'ai eue avec L'Armoire à Louer. Le processus de location était facile à comprendre et à suivre. J'ai été impressionné par la variété des articles disponibles et la facilité avec laquelle je pouvais naviguer sur le site."
        </p>
    </swiper-slide>

    <swiper-slide class="slider-item">
        <img src="/images/feedback3.jpg" alt="Marc">
        <h3 class="title text-center">Marc</h3>
        <p class="text-center w-5/6 md:w-4/6 lg:3/6">
            "J'ai récemment loué une tenue pour un mariage via L'Armoire à Louer et j'ai été très satisfait de mon expérience. Non seulement j'ai économisé de l'argent, mais j'ai aussi reçu de nombreux compliments sur ma tenue."
        </p>
    </swiper-slide>

    <swiper-slide class="slider-item">
        <img src="/images/feedback4.jpg" alt="Anne">
        <h3 class="title text-center">Anne</h3>
        <p class="text-center w-5/6 md:w-4/6 lg:3/6">
            "L'Armoire à Louer est une véritable aubaine pour ceux qui, comme moi, aiment suivre la mode sans en payer le prix fort. Les articles que j'ai loués étaient toujours en excellent état, bien entretenus et livrés à temps."
        </p>
    </swiper-slide>
  </swiper>
</template>
<script>
  // Import Swiper Vue.js components
  import { Swiper, SwiperSlide } from 'swiper/vue';

  // Import Swiper styles
  import 'swiper/css/bundle';

  // import required modules
  import { Pagination } from 'swiper';

  export default {
    components: {
      Swiper,
      SwiperSlide,
    },
    setup() {
      return {
        modules: [Pagination],
      };
    },
  };
</script>

<style >
.slider-item {
    height: 430px;
    background: green;
    width: 40%;
    opacity: 0.5;
    transition: opacity 500ms ease;
    background: #FAF9F7 0% 0% no-repeat padding-box;
    border: 2px solid #C8BEAA;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 24px;
    flex-direction: column;
}

.slider-item img {
    height: 80px;
    border-radius: 100%;
    width: 80px;
    object-position: center;
    object-fit: cover;
}

.slider-item h3 {
    font-size: 30px;
}

@media screen and (max-width: 1200px) {
    .slider-item {
        width: 60%;
    }
}

@media screen and (max-width: 800px) {
    .slider-item {
        width: 70%;
    }

    .slider-item h3 {
        font-size: 25px;
    }
}

.mySwiper {
    margin-top: 90px;
    margin-bottom: 90px;
}

.slider-item.swiper-slide-active {
    opacity: 1 !important;
}

.swiper-pagination-bullet {
    height: 15px;
    width: 15px;
}

.swiper-pagination-bullet-active {
    background: black !important;
}
</style>

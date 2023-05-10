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
        <img src="/images/ig-1.png" alt="Romane">
        <h3 class="title text-center">Romane</h3>
        <p class="text-center w-5/6 md:w-4/6 lg:3/6">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
        </p>
    </swiper-slide>

    <swiper-slide class="slider-item">
        <img src="/images/ig-1.png" alt="Romane">
        <h3 class="title text-center">Romane</h3>
        <p class="text-center w-5/6 md:w-4/6 lg:3/6">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
        </p>
    </swiper-slide>

    <swiper-slide class="slider-item">
        <img src="/images/ig-1.png" alt="Romane">
        <h3 class="title text-center">Romane</h3>
        <p class="text-center w-5/6 md:w-4/6 lg:3/6">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
        </p>
    </swiper-slide>

    <swiper-slide class="slider-item">
        <img src="/images/ig-1.png" alt="Romane">
        <h3 class="title text-center">Romane</h3>
        <p class="text-center w-5/6 md:w-4/6 lg:3/6">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
        </p>
    </swiper-slide>

    <swiper-slide class="slider-item">
        <img src="/images/ig-1.png" alt="Romane">
        <h3 class="title text-center">Romane</h3>
        <p class="text-center w-5/6 md:w-4/6 lg:3/6">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
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

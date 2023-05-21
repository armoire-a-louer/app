<template>
  <div>
    <Navbar ref="navbar"/>
    <main class="overflow-hidden">
      <slot/>
      <Loading :loading="loading"/>
    </main>
    <Footer />
  </div>
</template>

<script>
import Navbar from "@/Components/Layout/Navbar.vue";
import Footer from "@/Components/Layout/Footer.vue";
import Loading from '@/Components/Layout/Loading.vue';
import AOS from 'aos';
import 'aos/dist/aos.css';

export default {
  components: {
    Navbar,
    Footer,
    Loading
  },

  props: ["loading"],

  methods: {
    setReservations(reservations) {
      this.$refs.navbar.setReservations(reservations);
    },
    toggleBasket() {
      this.$refs.navbar.toggleBasket();
    }
  },

  mounted() {
    AOS.init();
  }
};
</script>

<style>
.title {
  font-family: 'Roslindale', serif !important;
  font-size: 56px;
}

.smaller-title {
  font-family: 'Roslindale', serif !important;
  font-size: 46px;
  line-height: 59px;
}

@media screen and (max-width: 1100px){
    .smaller-title {
        font-size: 34px !important;
        line-height: 48px;
    }

    .title {
      font-size: 42px !important;
      line-height: 58px;
    }
}

@media screen and (max-width: 600px){
    .title, .smaller-title {
        font-size: 24px !important;
        line-height: 34px;
    }
}

body {
  overflow-x: hidden !important;
  font-family: "Avenir";
}

html {
    scroll-behavior: smooth;
}

@font-face {
  font-family: "Avenir";
  src: url(/fonts/Avenir/Avenir-Roman-12.ttf) format("truetype");
  font-weight: normal;
  font-style: normal;
}

@font-face {
  font-family: "Avenir";
  src: url(/fonts/Avenir/Avenir-Heavy-05.ttf) format("truetype");
  font-weight: 500;
  font-style: normal;
}

@font-face {
  font-family: "Avenir";
  src: url(/fonts/Avenir/Avenir-Black-03.ttf) format("truetype");
  font-weight: 900;
  font-style: normal;
}

@font-face {
  font-family: "Roslindale";
  src: local("Roslindale"),
    url(/fonts/RoslindaleText-Bold.ttf) format("truetype");
}

@font-face {
  font-family: "Gilroy-Bold";
  src: local("Gilroy-Bold"),
    url(/fonts/Gilroy-Bold.ttf) format("truetype");
}

@font-face {
  font-family: "SackersGothic";
  src: local("SackersGothic"),
    url(/fonts/SackersGothicStd-Medium.otf) format("opentype");
}

.font-sackers {
  font-family: "SackersGothic", sans-serif;
  font-size: 18px;
  letter-spacing: 2px;
  text-transform: lowercase;
}

.container {
    padding-left: 20px !important;
    padding-right: 20px !important;
}

.padding-navbar {
  padding-top: 160px;
}

.fade-right-enter-active,
.fade-right-leave-active {
  transition: transform 0.4s ease;
}

.fade-right-enter-from,
.fade-right-leave-to {
  transform: translateX(100%);
}

.fade-left-enter-active,
.fade-left-leave-active {
  transition: transform 0.4s ease;
}

.fade-left-enter-from,
.fade-left-leave-to {
  transform: translateX(-100%);
}

.fade-down-enter-active,
.fade-down-leave-active {
  transition: all 0.4s ease;
  opacity: 1;
}

.fade-down-enter-from,
.fade-down-leave-to {
  opacity: 0;
  transform: translateY(100%);
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
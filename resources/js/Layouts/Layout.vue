<template>
  <div>
    <Navbar />
    <main class="overflow-hidden">
      <slot/>
    </main>
  </div>
</template>

<script>
import Navbar from "@/Components/Layout/Navbar.vue";

export default {
  components: {
    Navbar,
  },
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
}

@media screen and (max-width: 600px){
    .title, .smaller-title {
        font-size: 24px !important;
        line-height: 34px;
    }
}

body {
  overflow-x: hidden !important;
}

@font-face {
  font-family: "Avenir";
  src: local("Avenir"),
    url(/fonts/Avenir/Avenir-Roman-12.ttf) format("truetype"),
    url(/fonts/Avenir/Avenir-Heavy-05.ttf) format("truetype");
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

.container {
    padding-left: 20px !important;
    padding-right: 20px !important;
}

.padding-navbar {
  padding-top: 180px;
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

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
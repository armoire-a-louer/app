<template>
  <div>
    <Navbar />
    <slot />
    <div style="height: 200vh;"></div>
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

.container {
    padding-left: 20px !important;
    padding-right: 20px !important;
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
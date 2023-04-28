<template>
  <div class="container mx-auto px-3 sm:px-5 2xl:px-10">
    <slot />
  </div>
</template>

<script>
export default {

}
</script>

<style>
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
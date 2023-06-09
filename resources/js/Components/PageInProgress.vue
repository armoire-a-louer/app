<template>
  <section class="flex flex-col items-center justify-center">
    <img src="/images/building_page.svg" alt="">

    <h1 class="building-title mt-20">Oups ! Cette page n’est pas encore prête…</h1>

    <p class="mt-3 text-center" style="width: 450px; max-width: 100%;">
        Cette page se prépare avec soin pour vous offrir une expérience de mode luxueuse et raffinée. Revenez plus tard !
    </p>

    <Button class="mt-6" text="Retourner à l'accueil" color="black" textColor="white" :route="route('index')"/>
  </section>
</template>

<script>
import Button from './Buttons/Button.vue'

export default {
    components: {
        Button
    }
}
</script>

<style scoped>
.building-title {
    font-size: 27px;
    font-family: 'Roslindale', serif;
    font-weight: bold;
}
</style>
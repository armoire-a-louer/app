<template>
  <Link class="button" :href="route">
    {{ text }}
  </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
    name: 'WhiteButton',

    props: ['text', 'route'],

    components: {
        Link
    }
}
</script>

<style scoped>
.button {
    background: #FFFFFF 0% 0% no-repeat padding-box;
    box-shadow: 0px 0px 20px #00000014;
    font-family: 'Gilroy-Bold', sans-serif;
    text-transform: uppercase;
    padding: 18px 37px;
    display: inline-block;
}
</style>
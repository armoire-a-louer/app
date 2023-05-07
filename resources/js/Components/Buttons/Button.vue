<template>
  <Link
    class="button"
    :class="[
      color ? 'bg-' + color : '',
      textColor ? 'text-' + textColor : '',
      border ? 'border border-' + border : ''
    ]"
    :href="route"
  >
    {{ text }}
  </Link>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  name: "Button",

  props: ["text", "route", "color", "textColor", "border"],

  components: {
    Link,
  },
};
</script>

<style scoped>
.button {
  background: #ffffff 0% 0% no-repeat padding-box;
  box-shadow: 0px 0px 20px #00000014;
  font-family: "Gilroy-Bold", sans-serif;
  text-transform: uppercase;
  padding: 18px 37px;
  display: inline-block;
  transition: 200ms ease;
  text-align: center;
}

@media screen and (max-width: 650px) {
  .button {
    padding: 12px 28px;
  }
}

.button:hover {
  transform: scale(1.02);
}

.border {
  border: 2px solid;
}

.bg-black {
  background-color: #000 !important;
}

.bg-white {
  background-color: #fff !important;
}

.text-black {
  color: #000 !important;
}

.text-white {
  color: #fff !important;
}
</style>
<template>
  <div class="card">
    <div>
        <img :src="product.image_url" alt="" />
      <div class="card__hover">
        <LikeButton :liked="false" />
        <Button
          class="w-full"
          text="voir de plus près"
          :route="route('product', product.id)"
          color="black"
          textColor="white"
        />
      </div>
    </div>

    <div class="flex flex-col gap-2">
      <Link :href="route('product', product.id)">
        <h4 class="text-center">{{ product.brand.name }}</h4>
        <h3 class="title text-center">{{ product.name }}</h3>
        <p class="text-center">{{ product.price_per_day }} euros / jour</p>
      </Link>
    </div>
  </div>
</template>

<script>
import LikeButton from "@/Components/Buttons/LikeButton.vue";
import { Link } from "@inertiajs/inertia-vue3";
import Button from "@/Components/Buttons/Button.vue";

export default {
  props: ["product"],

  data() {
    return {
        liked: false
    }
  },

  components: {
    Button,
    LikeButton,
    Link,
  },
};
</script>

<style scoped>
.card {
    overflow: hidden;
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.card div {
    position: relative;
    overflow: hidden;
}

.card:hover img{
    transform: scale(1.1);
}

.card img{
    transition: transform 300ms ease;
    height: 100%;
    width: 100%;
    object-fit: cover;
    object-position: center;
    height: 500px;
}

.card:hover .card__hover{
    display: flex;
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 1;
}

.card__hover{
    display: none;
    opacity: 0;
    transition: opacity 300ms ease;
    flex-direction: column;
    justify-content: space-between;
    padding: 25px;
    align-items: flex-start;
}

h3{
    font-size: 27px;
}
</style>
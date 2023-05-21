<template>
  <button v-if="isAuth" @click="click()" class="button" :class="isScaled ? 'scaled' : ''">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 512 512"><path :fill="isLiked ? '#000' : '#fff'" :stroke="isLiked ? '' : 'black'" :stroke-width="isLiked ? '0' : '26'" :stroke-opacity="isLiked ? '0' : '1'" d="M256 448a32 32 0 0 1-18-5.57c-78.59-53.35-112.62-89.93-131.39-112.8c-40-48.75-59.15-98.8-58.61-153C48.63 114.52 98.46 64 159.08 64c44.08 0 74.61 24.83 92.39 45.51a6 6 0 0 0 9.06 0C278.31 88.81 308.84 64 352.92 64c60.62 0 110.45 50.52 111.08 112.64c.54 54.21-18.63 104.26-58.61 153c-18.77 22.87-52.8 59.45-131.39 112.8a32 32 0 0 1-18 5.56Z"/></svg>
  </button>
  <div v-else></div>
</template>

<script>
import axios from 'axios';

export default {
    name: "LikeButton",

    props: ["liked", "productId"],

    data() {
        return {
            isLiked: this.liked,
            isScaled: false,
            isAuth: this.$page.props.auth.user
        }
    },

    methods: {
        click() {
            if (! this.productId) {
                return;
            }

            axios.post(route('like-or-dislike', this.productId))

            this.isLiked = !this.isLiked;
            this.isScaled = true;
            setTimeout(() => {
                this.isScaled = false;
            }, 150);
        },

        checkLiked() {
            if (! this.productId) {
                return;
            }

            axios.get(route('is-product-liked', this.productId))
                .then((response) => {
                    this.isLiked = response.data.liked;
                })
        }
    },

    mounted() {
        if (this.isAuth) {
            this.checkLiked();
        }
    }
}
</script>

<style scoped>
.button {
    background: #fff;
    border-radius: 150px;
    padding: 10px;
    transition: transform 150ms ease;
}

.scaled {
    transform: scale(1.1);
}
</style>
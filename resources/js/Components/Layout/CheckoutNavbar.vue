<template>
  <nav ref="navbar" class="navbar fixed top-0 left-0 w-full box-shadow flex items-center bg-white">
    <div class="container mx-auto flex justify-center items-center">
        <Link :href="route('index')" class="flex items-center">
          <img style="width: 200px" src="/images/logo_black.svg" />
        </Link>
    </div>
  </nav>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link,
  },

  methods: {
    handleScroll(event) {
        if (! this.isHomePage) return;

        if (window.scrollY > 50) {
            this.scrolled = true;
        } else {
            this.scrolled = false;
        }
    }
  },

  mounted() {
    this.handleScroll();
    window.addEventListener('scroll', this.handleScroll);
  },

  destroyed() {
    window.removeEventListener('scroll', this.handleScroll);
  },
};
</script>

<style scoped>
.box-shadow {
    box-shadow: rgba(0, 0, 0, 0.1) 0px 20px 25px -5px, rgba(0, 0, 0, 0.04) 0px 10px 10px -5px;
}

.navbar {
    transition: 300ms ease;
    z-index: 100000;
    height: 120px;
}

</style>
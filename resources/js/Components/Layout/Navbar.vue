<template>
  <nav ref="navbar" class="navbar fixed top-0 left-0 w-full" :style="[scrolled ? 'color: black; background-color: white;' : 'color: white;']" :class="scrolled ? 'box-shadow' : ''">
    <div class="container mx-auto">
      <div class="flex gap-10">
        <Link :href="route('index')" class="flex items-center">
          <img v-if="scrolled" style="width: 200px" src="/images/logo_black.svg" />
          <img v-else style="width: 200px" src="/images/logo.svg" />
        </Link>
        <div class="nav-links">
          <span class="nav-link">
            <Link class="nav-a py-2 px-4" :href="route('index')">Accueil</Link>
          </span>
          <span class="nav-dropdown">
            <Link class="nav-a py-2 px-4" :href="route('index')"
              >Collections
              <font-awesome-icon
                icon="fa-solid fa-chevron-down"
                class="text-xs pl-2"
            /></Link>
            <div class="nav-dropdown-menu">
              <div>
                <Link
                  :href="route('index')"
                  v-for="collection in collections"
                  :key="collection.id"
                  class="nav-dropdown-link"
                >
                  {{ collection.name }}
                </Link>
              </div>
            </div>
          </span>
          <span class="nav-dropdown">
            <Link class="nav-a py-2 px-4" :href="route('index')"
              >Marques
              <font-awesome-icon
                icon="fa-solid fa-chevron-down"
                class="text-xs pl-2"
            /></Link>
            <div class="nav-dropdown-menu">
              <div>
                <Link
                  :href="route('index')"
                  v-for="brand in brands"
                  :key="brand.id"
                  class="nav-dropdown-link"
                >
                  {{ brand.name }}
                </Link>
              </div>
            </div>
          </span>
          <span class="nav-link">
            <Link class="nav-a py-2 px-4" :href="route('concept')">Concept</Link>
          </span>
        </div>
      </div>
      <div class="flex gap-4 items-center">
        <span class="p-4 cursor-pointer" @click="searchOpened = true">
          <img v-if="scrolled" style="width: 17px" src="/images/icons/search_black.svg" />
          <img v-else style="width: 17px" src="/images/icons/search.svg" />
        </span>
        <Link class="p-4" :href="route('index')">
          <img v-if="scrolled" style="width: 17px" src="/images/icons/user_black.svg" />
          <img v-else style="width: 17px" src="/images/icons/user.svg" />
        </Link>
        <Link class="p-4 pr-0" :href="route('index')">
          <img v-if="scrolled" style="width: 17px" src="/images/icons/bag_black.svg" />
          <img v-else style="width: 17px" src="/images/icons/bag.svg" />
        </Link>
      </div>
    </div>
    <transition name="fade">
        <Search v-if="searchOpened" @close="searchOpened = false"/>
    </transition>
  </nav>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import Search from './Search.vue';

export default {
  components: {
    Link,
    Search
  },

  data() {
    return {
      collections: this.$inertia.page.props.collections,
      brands: this.$inertia.page.props.brands,

      isHomePage: this.$inertia.page.props.path === '/',
      scrolled: this.isHomePage ? false : true,

      searchOpened: false
    };
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
}

.navbar .container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.nav-links {
  display: flex;
  align-items: center;
  gap: 15px;
  height: 120px;
  font-size: 17px;
}

.nav-link {
  position: relative;
  height: 100%;
  display: flex;
  align-items: center;
}

.nav-dropdown {
  position: relative;
  display: inline-block;
  align-items: center;
}

.nav-link .nav-a {
  position: static;
}

.nav-link .nav-a::after {
  content: "";
  position: absolute;
  bottom: 0;
  left: 0;
  width: 0;
  height: 4px;
  background: black;
  transition: width ease 200ms;
}

.nav-link .nav-a:hover::after {
  width: 100%;
  cursor: pointer;
}

.nav-dropdown:hover .nav-dropdown-menu {
  display: flex;
  flex-direction: column;
  gap: 10px;
  align-items: center;
}

.nav-dropdown-menu {
  display: none;
  position: absolute;
  left: 0;
  color: black;
  z-index: 1000;
  min-width: 100%;
}

.nav-dropdown-menu div {
  background: white;
  margin-top: 10px;
  padding: 10px 20px;
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 10px;
  box-shadow: rgba(0, 0, 0, 0.15) 1.95px 1.95px 2.6px;
}

.nav-dropdown-link {    
    display: block;
}
</style>
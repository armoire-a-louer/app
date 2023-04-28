<template>
  <nav ref="navbar" class="navbar">
    <div class="container mx-auto">
      <div class="flex gap-10">
        <Link :href="route('index')" class="flex items-center">
          <img style="width: 200px" src="/images/logo.svg" />
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
                >
                  {{ brand.name }}
                </Link>
              </div>
            </div>
          </span>
          <span class="nav-link">
            <Link class="nav-a py-2 px-4" :href="route('index')">Concept</Link>
          </span>
        </div>
      </div>
      <div class="flex gap-4 items-center">
        <Link class="p-4" :href="route('index')">
          <img style="width: 17px" src="/images/icons/search.svg" />
        </Link>
        <Link class="p-4" :href="route('index')">
          <img style="width: 17px" src="/images/icons/user.svg" />
        </Link>
        <Link class="p-4" :href="route('index')">
          <img style="width: 17px" src="/images/icons/bag.svg" />
        </Link>
      </div>
    </div>
  </nav>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    Link,
  },

  data() {
    return {
      collections: this.$inertia.page.props.collections,
      brands: this.$inertia.page.props.brands,
    };
  },
};
</script>

<style scoped>
.navbar {
  background: green;
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
  color: white;
  position: relative;
  height: 100%;
  display: flex;
  align-items: center;
}

.nav-dropdown {
  color: white;
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
  width: 150%;
}

.nav-dropdown-menu div {
  background: white;
  margin-top: 10px;
  text-align: center;
  padding: 10px 20px;
  width: 100%;
}
</style>
<template>
  <nav ref="navbar" class="navbar fixed top-0 left-0 w-full" :style="[scrolled ? 'color: black; background-color: white;' : 'color: white;']" :class="scrolled ? 'box-shadow' : ''">
    <div class="container mx-auto flex justify-between">
      <div class="toggler cursor-pointer" @click="toggleMenu()">
        <span :class="scrolled ? 'bg-black' : 'bg-white'"></span>
        <span :class="scrolled ? 'bg-black' : 'bg-white'"></span>
        <span :class="scrolled ? 'bg-black' : 'bg-white'"></span>
      </div>
      <div class="flex gap-10">
        <Link :href="route('index')" class="flex items-center">
          <img class="logo" v-if="scrolled" style="width: 200px" src="/images/logo_black.svg" />
          <img class="logo" v-else style="width: 200px" src="/images/logo.svg" />
        </Link>
        <div class="nav-links mobile-hide">
          <span class="nav-link">
            <Link class="nav-a py-2 px-4" :href="route('index')">Accueil</Link>
          </span>
          <span class="nav-dropdown">
            <Link :href="route('search')" class="nav-a py-2 px-4">
              Collections
              <font-awesome-icon
                icon="fa-solid fa-chevron-down"
                class="text-xs pl-2"/>
            </Link>
            <div class="nav-dropdown-menu">
              <div>
                <Link
                  :href="route('search', { categories: [collection.id] })"
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
            <Link :href="route('search')">
              Marques
              <font-awesome-icon
                icon="fa-solid fa-chevron-down"
                class="text-xs pl-2"/>
            </Link>
            <div class="nav-dropdown-menu">
              <div>
                <Link
                  :href="route('search', { brands: [brand.id] })"
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
      <div class="flex gap-1 md:gap-4 items-center justify-end">
        <span class="p-4 cursor-pointer mobile-hide" @click="searchOpened = true">
          <img v-if="scrolled" style="width: 17px" src="/images/icons/search_black.svg" />
          <img v-else style="width: 17px" src="/images/icons/search.svg" />
        </span>
        <Link class="p-2 md:p-4" :href="route('dashboard')">
          <img v-if="scrolled" style="width: 17px" src="/images/icons/user_black.svg" />
          <img v-else style="width: 17px" src="/images/icons/user.svg" />
        </Link>
        <div class="p-2 md:p-4 pr-0 cursor-pointer relative" @click="toggleBasket()">
          <img v-if="scrolled" style="width: 17px" src="/images/icons/bag_black.svg" />
          <img v-else style="width: 17px" src="/images/icons/bag.svg" />

          <span class="absolute top-0 right-0 p-1 rounded-full text-xs px-2 text-white" style="background: #D5C4B6;" v-if="reservations.length">
            {{ reservations.length }}
          </span>
        </div>
      </div>
    </div>
    <transition name="fade">
        <Search v-if="searchOpened" @close="searchOpened = false"/>
    </transition>

    <section class="basket" v-if="basketOpened" data-aos="fade-left" @click.self="toggleBasket()">
      <div class="basket-container relative text-black px-10 gap-8">
        <div class="absolute top-10 right-10 cursor-pointer" @click="toggleBasket()">
          <font-awesome-icon icon="fa-solid fa-xmark" class="text-3xl"/>
        </div>
        <h2 class="font-serif text-xl md:text-2xl xl:text-3xl border-b-gray-200 w-full pb-8" style="border-bottom-width: 1px;">Votre panier.</h2>

        <div class="flex-1 flex flex-col gap-6 overflow-y-auto" v-if="reservations.length !== 0">
          <div v-for="reservation in reservations" data-aos="fade-up" :key="reservation.id" class="flex justify-start items-center gap-8 py-7">
              <img class="object-cover h-16 w-8" :src="reservation.item.first_image_url" :alt="reservation.item.product.name">

              <div>
                  <h3 class="text-sm lg:text-md font-gothic lowercase letter-spacing">{{ reservation.item.product.brand.name }}</h3>
                  <h2 class="font-serif text-xl md:text-2xl xl:text-3xl pt-2">{{ reservation.item.product.name }}</h2>

                  <span class="font-bold block pt-4">
                      Du {{ formatDate(reservation.earliest_date) }} au {{ formatDate(reservation.latest_date) }}
                  </span>
                  <span class="block">
                      {{ countDays(reservation.earliest_date, reservation.latest_date) }} jours de location
                  </span>

                  <button @click="removeFromBasket(reservation.reservation_common_uuid)" type="button" class="underline mt-3 text-beige">
                      Supprimer
                  </button>
              </div>
          </div>
        </div>

        <p class="flex-1 flex flex-col justify-center items-start" v-if="reservations.length === 0">
          <span>Votre panier est vide...</span>
          <span class="font-bold">Mais on a une solution !</span>
        </p>

        <div v-if="reservations.length !== 0" class="border-b-gray-200 pt-8 flex justify-between items-center w-full" style="border-top-width: 1px;">
          <span class="font-bold">
            Total
          </span>
          <span class="font-bold">
            {{ total }}
          </span>
        </div>

        <Button v-if="reservations.length === 0" :route="route('search')" text="découvrir nos produits" class="w-full" color="black" textColor="white" />
        <Button v-else :route="route('checkout')" text="valider" class="w-full" color="black" textColor="white"/>
      </div>
    </section>

    <transition name="fade-down">
      <div v-if="isMenuOpen" class="bg-white mobile-menu fixed w-full left-0 text-black" style="top: 120px;">
        <div class="container mx-auto flex flex-col gap-2 my-4" style="align-items: start !important;">
            <Link class="nav-a" :href="route('index')">Accueil</Link>

            <span class="nav-a">Collections</span>

            <div class="pl-2 flex flex-col gap-2">
              <Link
                :href="route('search', { categories: [collection.id] })"
                v-for="collection in collections"
                :key="collection.id"
              >
                {{ collection.name }}
              </Link>
            </div>

            <span class="nav-a">Marques</span>

            <div class="pl-2 flex flex-col gap-2">
              <Link
                :href="route('search', { brands: [brand.id] })"
                v-for="brand in brands"
                :key="brand.id"
              >
                {{ brand.name }}
              </Link>
            </div>

            <Link class="nav-a" :href="route('concept')">Concept</Link>
        </div>
      </div>
    </transition>
  </nav>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import Search from './Search.vue';
import Button from '../Buttons/Button.vue';

export default {
  components: {
    Link,
    Search,
    Button
  },

  data() {
    return {
      collections: this.$inertia.page.props.collections,
      brands: this.$inertia.page.props.brands,

      isHomePage: this.$inertia.page.props.path === '/',
      scrolled: this.isHomePage ? false : true,

      searchOpened: false,

      basketOpened: false,
      reservations: this.$inertia.page.props.reservations,

      isMenuOpen: false
    };
  },

  computed: {
    total() {
      let total = 0;
      this.reservations.forEach((reservation) => {
        total += parseInt(reservation.total_price);
      })

      return (total / 100).toFixed(2).replace('.', ',') + "€";
    }
  },

  methods: {
    handleScroll(event) {
        if (! this.isHomePage) return;

        if (window.scrollY > 50) {
            this.scrolled = true;
        } else {
            this.scrolled = false;
        }
    },

    toggleBasket() {
      this.basketOpened = ! this.basketOpened;
    },

    formatDate(date) {
      date = new Date(date);

      const day = String(date.getDate()).padStart(2, '0');
      const month = String(date.getMonth() + 1).padStart(2, '0');
      
      return `${day}/${month}`;
    },

    countDays(earliestDate, latestDate) {
      earliestDate = new Date(earliestDate);
      latestDate = new Date(latestDate);

      const oneDay = 24 * 60 * 60 * 1000;

      const diffInMilliseconds = Math.abs(latestDate - earliestDate);
      // ON AJOUTE UN JOUR CAR IL FAUT TOUS LES COMPTER (PAS QUE LA DIFFERENCE)
      const diffInDays = Math.floor(diffInMilliseconds / oneDay) + 1;

      return `${diffInDays}`;
    },

    removeFromBasket(reservationCommonUuid) {
      this.loading = true;
      axios.delete(route('remove-from-basket', reservationCommonUuid))
          .then((response) => {
              this.reservations = response.data.reservations;
              this.loading = false;
          })
          .catch((error) => {
              this.loading = false;
              console.log(error);
          })
    },

    setReservations(reservations) {
      this.reservations = reservations;
    },

    toggleMenu() {
      this.isMenuOpen = ! this.isMenuOpen;
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
  display: flex;
  align-items: center;
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

.nav-link a:hover, .nav-dropdown a:hover {
  text-decoration: underline;
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
  min-width: 150%;
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

.basket {
  position: absolute;
  top: 0;
  right: 0;
  z-index: 10000000;
  height: 100vh;
  width: 100vw;
  display: flex;
  justify-content: flex-end;
}

.basket .basket-container {
  width: 400px;
  background: white;
  height: 100%;
  max-width: 100%;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  padding-top: 100px;
  padding-bottom: 100px;
  overflow-x: hidden;
  overflow-y: auto;
}

.text-beige {
    color: #CABDA8;
}

.toggler {
  display: none;
}

.toggler span {
  width: 21px;
  height: 2px;
}

.toggler span:nth-child(2) {
  width: 13px;
}

@media screen and (min-width: 1031px) {
  .mobile-menu {
    display: none;
  }
}

@media screen and (max-width: 1030px) {
  .mobile-hide {
    display: none;
  }

  .toggler {
    display: flex;
    flex-direction: column;
    gap: 5px;
  }

  .navbar > div {
    flex: 1;
  }

  .logo {
    width: 120px !important;
  }
}
</style>
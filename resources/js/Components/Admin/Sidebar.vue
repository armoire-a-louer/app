<template>
  <!-- Desktop sidebar -->
  <aside
    class="
      z-20
      w-64
      overflow-y-auto
      bg-white
      md:block
      flex-shrink-0
    "
    :class="{ hidden: !toggleSideMenu }"
  >
    <div class="py-4 text-gray-500">
      <Link :href="route('admin.dashboard')">
        <img src="/images/logo_black.svg" class="w-28 ml-6 text-lg font-bold text-gray-800">
      </Link>
      <ul class="mt-6">
        <li class="relative px-6 py-3">
          <span
            v-if="path === '/admin'"
            class="
              absolute
              inset-y-0
              left-0
              w-1
              bg-purple-600
              rounded-tr-lg rounded-br-lg
            "
            aria-hidden="true"
          ></span>
          <Link
            href="/admin"
            class="
              inline-flex
              items-center
              w-full
              text-sm
              font-semibold
              transition-colors
              duration-150
              hover:text-gray-800
            "
            :class="{ 'text-gray-800': path === '/admin' }"
          >
            <font-awesome-icon icon="fa-solid fa-home" class="text-xl"/>
            <span class="ml-4">Tableau de bord</span>
          </Link>
        </li>
      </ul>
      <ul>
        <li class="relative px-6 py-3">
          <span
            v-if="path === '/admin/brands'"
            class="
              absolute
              inset-y-0
              left-0
              w-1
              bg-purple-600
              rounded-tr-lg rounded-br-lg
            "
            aria-hidden="true"
          ></span>
          <Link
            href="/admin/brands"
            class="
              inline-flex
              items-center
              w-full
              text-sm
              font-semibold
              transition-colors
              duration-150
              hover:text-gray-800
            "
            :class="{ 'text-gray-800': path === '/admin/brands' }"
          >
            <font-awesome-icon icon="fa-solid fa-copyright" class="text-xl"/> 
            <span class="ml-4">Marques</span>
          </Link>
        </li>
        <li class="relative px-6 py-3">
          <span
            v-if="path === '/admin/products'"
            class="
              absolute
              inset-y-0
              left-0
              w-1
              bg-purple-600
              rounded-tr-lg rounded-br-lg
            "
            aria-hidden="true"
          ></span>
          <Link
            href="/admin/products"
            class="
              inline-flex
              items-center
              w-full
              text-sm
              font-semibold
              transition-colors
              duration-150
              hover:text-gray-800
            "
            :class="{ 'text-gray-800': path === '/admin/products' }"
          >
            <font-awesome-icon icon="fa-solid fa-tags" class="text-xl"/> 
            <span class="ml-4">Produits</span>
          </Link>
        </li>
        <li class="relative px-6 py-3">
          <span
            v-if="path === '/admin/categories'"
            class="
              absolute
              inset-y-0
              left-0
              w-1
              bg-purple-600
              rounded-tr-lg rounded-br-lg
            "
            aria-hidden="true"
          ></span>
          <Link
            href="/admin/categories"
            class="
              inline-flex
              items-center
              w-full
              text-sm
              font-semibold
              transition-colors
              duration-150
              hover:text-gray-800
            "
            :class="{ 'text-gray-800': path === '/admin/categories' }"
          >
            <font-awesome-icon icon="fa-solid fa-venus-mars" class="text-xl"/> 
            <span class="ml-4">Catégories</span>
          </Link>
        </li>
        <li class="relative px-6 py-3">
          <span
            v-if="path === '/admin/colors'"
            class="
              absolute
              inset-y-0
              left-0
              w-1
              bg-purple-600
              rounded-tr-lg rounded-br-lg
            "
            aria-hidden="true"
          ></span>
          <Link
            href="/admin/colors"
            class="
              inline-flex
              items-center
              w-full
              text-sm
              font-semibold
              transition-colors
              duration-150
              hover:text-gray-800
            "
            :class="{ 'text-gray-800': path === '/admin/colors' }"
          >
            <font-awesome-icon icon="fa-solid fa-palette" class="text-xl"/> 
            <span class="ml-4">Couleurs</span>
          </Link>
        </li>
        <li class="relative px-6 py-3">
          <span
            v-if="path === '/admin/materials'"
            class="
              absolute
              inset-y-0
              left-0
              w-1
              bg-purple-600
              rounded-tr-lg rounded-br-lg
            "
            aria-hidden="true"
          ></span>
          <Link
            href="/admin/materials"
            class="
              inline-flex
              items-center
              w-full
              text-sm
              font-semibold
              transition-colors
              duration-150
              hover:text-gray-800
            "
            :class="{ 'text-gray-800': path === '/admin/materials' }"
          >
            <font-awesome-icon icon="fa-solid fa-recycle" class="text-xl"/> 
            <span class="ml-4">Matériaux</span>
          </Link>
        </li>
        <li class="relative px-6 py-3">
          <span
            v-if="path === '/admin/models'"
            class="
              absolute
              inset-y-0
              left-0
              w-1
              bg-purple-600
              rounded-tr-lg rounded-br-lg
            "
            aria-hidden="true"
          ></span>
          <Link
            href="/admin/models"
            class="
              inline-flex
              items-center
              w-full
              text-sm
              font-semibold
              transition-colors
              duration-150
              hover:text-gray-800
            "
            :class="{ 'text-gray-800': path === '/admin/models' }"
          >
            <font-awesome-icon icon="fa-solid fa-person-dress"  class="text-xl"/>
            <span class="ml-4">Modèles</span>
          </Link>
        </li>
        <li class="relative px-6 py-3">
          <span
            v-if="path.includes('transaction')"
            class="
              absolute
              inset-y-0
              left-0
              w-1
              bg-purple-600
              rounded-tr-lg rounded-br-lg
            "
            aria-hidden="true"
          ></span>
          <Link
            href="/admin/transactions"
            class="
              inline-flex
              items-center
              w-full
              text-sm
              font-semibold
              transition-colors
              duration-150
              hover:text-gray-800
            "
            :class="{ 'text-gray-800': path.includes('transaction') }"
          >
            <font-awesome-icon icon="fa-solid fa-sack-dollar" class="text-xl"/>
            <span class="ml-4">Transactions</span>
          </Link>
        </li>
        <li class="relative px-6 py-3">
          <span
            v-if="path.includes('user')"
            class="
              absolute
              inset-y-0
              left-0
              w-1
              bg-purple-600
              rounded-tr-lg rounded-br-lg
            "
            aria-hidden="true"
          ></span>
          <Link
            href="/admin/users"
            class="
              inline-flex
              items-center
              w-full
              text-sm
              font-semibold
              transition-colors
              duration-150
              hover:text-gray-800
            "
            :class="{ 'text-gray-800': path.includes('user') }"
          >
            <font-awesome-icon icon="fa-regular fa-user" class="text-xl"/>
            <span class="ml-4">Utilisateurs</span>
          </Link>
        </li>
      </ul>
    </div>
  </aside>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";

export default {
  props: ["toggleSideMenu"],

  components: {
    Link,
  },

  computed: {
    path() {
      return this.$inertia.page.props.path;
    }
  }
};
</script>

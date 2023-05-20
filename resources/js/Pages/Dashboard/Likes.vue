<template>
  <Head title="Mes adresses" />

  <AuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Mes favoris
        </h2>
    </template>

    <div class="container mx-auto">
      <div
        v-if="successMessage"
        class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mt-5"
        role="alert"
      >
        <p class="font-bold">Succès</p>
        <p>{{ successMessage }}</p>
      </div>

      <div
        v-else-if="errorMessage"
        class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mt-5"
        role="alert"
      >
        <p class="font-bold">Erreur</p>
        <p>{{ errorMessage }}</p>
      </div>
    </div>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900 gap-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4">
            <ProductCard v-for="product in user.likes" :key="product.id" :product="product"/>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import ProductCard from '@/Components/ProductCard.vue';

export default {
  props: ["user"],

  components: {
    AuthenticatedLayout,
    Head,
    ProductCard
  },

  methods: {
    
  },

  mounted() {
    console.log(this.user)
  },
};
</script>

<style scoped>

</style>
<template>
  <AdminLayout>
    <div class="container px-6 mx-auto grid">
      <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
        Marques
      </h2>

      <div class="grid-rows-4">
        <BrandCard v-for="brand in brands" :key="brand.id" :brand="brand"/>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import BrandCard from "@/Components/Admin/BrandCard.vue";

export default {
    name: 'Brands',

    props: ['brands'],

    components: {
        AdminLayout,
        BrandCard
    }
}
</script>

<style scoped>

</style>
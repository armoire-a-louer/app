<template>
  <AdminLayout>
    <div class="container px-6 mx-auto grid">
        <div class="flex">
            <Link :href="route('admin.transactions.index')" class="my-4 rounded-full py-2 px-4 bg-blue-500 text-white">
                Retour
            </Link>
        </div>
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

      <h2 class="my-6 text-2xl font-semibold text-gray-700">
        Transaction <span class="text-sm">{{ transaction.payment_intent_id }}</span>
    </h2>

      <h3 class="mb-4 text-md font-semibold text-gray-700 flex gap-6 items-center bg-white shadow-md rounded py-3 px-4">
        <font-awesome-icon icon="fa-regular fa-user" class="text-2xl"/>
        <div>
            {{ transaction.user.firstname }} {{ transaction.user.lastname.toUpperCase() }}
            <span class="block text-sm">
                {{ transaction.user.email }}
            </span>
        </div>
      </h3>

      <h3 class="mt-4 text-xl font-semibold">Réservations: </h3>

      <div class="bg-white rounded shadow-md py-3 px-4 mt-6 flex flex-col items-stretch gap-8">
        <div class="flex justify-between" v-for="reservation in transaction.reservations" :key="reservation.reservation_common_uuid">
            <div class="flex gap-6 items-center">
                <img :src="reservation.item.first_image_url" class="object-cover h-28">
                <div class="flex flex-col items-center justify-center gap-2">
                    <span class="text-lg">{{ reservation.item.product.name }}</span>
                    <span>Marque: {{ reservation.item.product.brand.name }}</span>
                    <span>Taille: {{ reservation.item.size.toUpperCase() }}</span>
                    <span class="flex items-center gap-3">
                        Couleur: <span class="h-4 w-4 block" :style="reservation.item.primary_color.hex_code ? 'background:' + reservation.item.primary_color.hex_code : ''"></span>
                    </span>
                </div>
            </div>
            <div class="flex flex-col items-center justify-center gap-2">
                <span>Date de livraison: {{ reservation.earliest_date }}</span>
                <span>Date de retour: {{ reservation.latest_date }}</span>
            </div>
        </div>
      </div>

      <h3 class="mt-4 text-xl font-semibold">Adresse: </h3>

      <div class="bg-white rounded shadow-md py-3 px-4 mt-6 flex flex-col items-start">
        <p>{{ transaction.address.address }}</p>
        <p>{{ transaction.address.postal_code }} {{ transaction.address.city.toUpperCase() }}</p>
        <p class="font-bold">{{ transaction.address.firstname }} {{ transaction.address.lastname.toUpperCase() }}</p>
        <p>{{ transaction.address.phone_number }}</p>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link } from '@inertiajs/inertia-vue3';

export default {
  props: ["transaction"],

  components: {
    AdminLayout,
    Link
  },

  data() {
    return {
        successMessage: "",
        errorMessage: ""
    }
  },

  mounted() {
    console.log(this.transaction);
  },
};
</script>

<style>
</style>
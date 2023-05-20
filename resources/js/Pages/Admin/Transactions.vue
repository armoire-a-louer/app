<template>
  <AdminLayout>
    <div class="container px-6 mx-auto grid">
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

      <h2 class="my-6 text-2xl font-semibold text-gray-700">Transactions</h2>

      <div class="w-full overflow-x-auto rounded-lg shadow-lg">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-100"
            >
              <th class="px-4 py-3">Client</th>
              <th class="px-4 py-3">Montant</th>
              <th class="px-4 py-3">Statut</th>
              <th class="px-4 py-3">Date</th>
              <th class="px-4 py-3"></th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y">
            <tr
              v-for="transaction in transactions"
              :key="transaction.id"
              class="text-gray-700"
            >
              <td class="px-4 py-3">
                <div class="flex items-center text-sm">
                  <div>
                    <p class="font-semibold">
                      {{ transaction.user.firstname }}
                      {{ transaction.user.lastname.toUpperCase() }}
                    </p>
                    <p class="text-xs text-gray-600">
                      {{ transaction.user.email }}
                    </p>
                  </div>
                </div>
              </td>
              <td class="px-4 py-3">
                {{ (transaction.amount / 100).toFixed(2) }} €
              </td>
              <td class="px-4 py-3">
                <span
                  class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full"
                >
                  Approuvée
                </span>
              </td>
              <td>
                {{ transaction.paid_at }}
              </td>
              <td class="px-4 py-3">
                <Link class="text-blue-500" :href="route('admin.transactions.show', transaction.id)">
                    Voir
                </Link>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Link } from '@inertiajs/inertia-vue3';

export default {
  components: {
    AdminLayout,
    Link
  },

  props: ["transactions"],

  data() {
    return {
      successMessage: "",
      errorMessage: "",
    };
  },
};
</script>

<style scoped>
</style>
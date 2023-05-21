<template>
  <AdminLayout>
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700">Utilisateurs</h2>

        <div class="w-full overflow-x-auto rounded-lg shadow-lg">
        <table class="w-full whitespace-no-wrap">
            <thead>
            <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-100"
            >
                <th class="px-4 py-3">Utilisateur</th>
                <th class="px-4 py-3">Téléphone</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">Date d'inscription</th>
                <th class="px-4 py-3"></th>
            </tr>
            </thead>
            <tbody class="bg-white divide-y">
            <tr
                v-for="user in users"
                :key="user.id"
                class="text-gray-700"
            >
                <td class="px-4 py-3">
                <div class="flex items-center text-sm">
                    <div>
                    <p class="font-semibold">
                        {{ user.firstname }}
                        {{ user.lastname.toUpperCase() }}
                    </p>
                    <p class="text-xs text-gray-600">
                        {{ user.email }}
                    </p>
                    </div>
                </div>
                </td>
                <td class="px-4 py-3">
                {{ user.phone.replace(/(.{2})/g, "$1 ") }}
                </td>
                <td class="px-4 py-3">
                {{ user.role }}
                </td>
                <td>
                {{ formatDate(user.created_at) }}
                </td>
                <td class="px-4 py-3">
                <Link
                    class="text-blue-500"
                    :href="route('admin.users.show', user.id)"
                >
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
import { Link } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import moment from 'moment';

export default {
  props: ["users"],

  components: {
    Link,
    AdminLayout,
  },

  data() {
    return {
      successMessage: "",
      errorMessage: "",
    };
  },

  methods: {
    formatDate(date) {
        return moment(date).format('DD/MM/YYYY');
    }
  }
};
</script>

<style scoped>
</style>
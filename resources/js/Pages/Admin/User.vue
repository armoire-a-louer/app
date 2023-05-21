<template>
  <AdminLayout>
    <div class="container px-6 mx-auto grid">
      <div class="flex">
        <Link
          :href="route('admin.users.index')"
          class="my-4 rounded-full py-2 px-4 bg-blue-500 text-white"
        >
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

      <h1 class="my-6 text-2xl font-semibold text-gray-700">
        {{ user.firstname }} {{ user.lastname.toUpperCase() }}
      </h1>
      <div class="bg-white shadow-md rounded py-4 px-5">
        <div>
          <form
            @submit.prevent="updateUser()"
            class="flex flex-col items-start gap-1"
          >
            <div class="flex flex-col">
              <label class="block text-gray-700 text-sm font-bold mb-2 mt-5"
                >Prénom:
              </label>
              <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                type="text"
                v-model="form.firstname"
              />
            </div>

            <div class="flex flex-col">
              <label class="block text-gray-700 text-sm font-bold mb-2 mt-5"
                >Nom:
              </label>
              <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                type="text"
                v-model="form.lastname"
              />
            </div>

            <div class="flex flex-col">
              <label class="block text-gray-700 text-sm font-bold mb-2 mt-5"
                >Email:
              </label>
              <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                type="text"
                v-model="form.email"
              />
            </div>

            <div class="flex flex-col">
              <label class="block text-gray-700 text-sm font-bold mb-2 mt-5"
                >Téléphone:
              </label>
              <input
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                type="text"
                v-model="form.phone"
              />
            </div>

            <div class="flex flex-col">
              <label class="block text-gray-700 text-sm font-bold mb-2 mt-5"
                >Rôle:
              </label>
              <select
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                v-model="form.role"
              >
                <option value="user">Utilisateur</option>
                <option value="admin">Administrateur</option>
              </select>
            </div>

            <button
              type="submit"
              class="my-4 rounded-full py-2 px-4 bg-blue-500 text-white"
            >
              Mettre à jour
            </button>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from "axios";

export default {
  components: {
    Link,
    AdminLayout,
  },

  mounted() {
    this.form.firstname = this.user.firstname;
    this.form.lastname = this.user.lastname;
    this.form.email = this.user.email;
    this.form.phone = this.user.phone;
    this.form.role = this.user.role;
  },

  data() {
    return {
      successMessage: "",
      errorMessage: "",
      user: this.$page.props.user,
      form: {
        firstname: null,
        lastname: null,
        email: null,
        phone: null,
        role: null,
      },
    };
  },

  methods: {
    updateUser() {
      axios
        .put(route("admin.users.update", this.user.id), this.form)
        .then((response) => {
          this.user = response.data.user;
          this.successMessage = "Utilisateur mis à jour avec succès !";
        })
        .catch((error) => {
          this.errorMessage = error.message;
        });
    },
  },
};
</script>

<style scoped>
</style>
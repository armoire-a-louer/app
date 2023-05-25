<template>
  <Head title="Mes adresses" />

  <AuthenticatedLayout>
    <template #header>
      <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Mes adresses
        </h2>
        <span class="underline cursor-pointer" @click="isAddModalOpen = true">Ajouter une adresse</span>
      </div>
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
          <div class="p-6 text-gray-900 flex flex-col gap-6">
            <div
              v-if="addresses && addresses.length"
              class="grid grid-cols-2 gap-6"
            >
              <div
                class="transition-all address cursor-pointer pl-3"
                v-for="address in addresses"
                :key="address.id"
                @click="setSelectedAddress(address)"
              >
                <p>
                  {{ address.firstname }} {{ address.lastname.toUpperCase() }}
                </p>
                <p>
                  {{ address.address }}, {{ address.postal_code }}
                  {{ address.city }}
                </p>
                <p>{{ address.phone_number }}</p>
              </div>
            </div>
            <p v-else>
              Vous n'avez aucune adresse enregistrée. Vous pouvez dès maintenant
              en
              <span @click="isAddModalOpen = true" class="underline cursor-pointer"
                >ajouter une.</span
              > 
            </p>
          </div>
        </div>
      </div>
    </div>

    <!-- UPDATE MODAL -->
    <transition name="fade">
    <div
      class="modal"
      v-if="selectedAddress"
      @click.self="selectedAddress = null"
    >
      <div
        class="bg-white w-11/12 sm:w-3/4 lg:w-1/2 xl:w-1/3 p-5 border border-gray-200 rounded-lg shadow-xl"
      >
        <div class="flex justify-end">
          <svg
            @click="selectedAddress = null"
            class="h-7 w-7 cursor-pointer"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
          >
            <g stroke="#000000" stroke-linecap="round" stroke-width="2">
              <path d="M6 18L18 6" />
              <path d="M18 18L6 6" />
            </g>
          </svg>
        </div>

        <h2 class="text-xl">Mettre à jour votre adresse</h2>
        <form @submit.prevent="updateAddress()">
          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="address"
            >Adresse</label
          >
          <input
            id="address"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            v-model="updateForm.address"
            required
          />
          <div v-if="errors && errors.address">
            <p
              class="text-red-500"
              v-for="error in errors.address"
              :key="error"
            >
              {{ error }}
            </p>
          </div>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="postal_code"
            >Code postal</label
          >
          <input
            id="postal_code"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            v-model="updateForm.postal_code"
            required
          />
          <div v-if="errors && errors.postal_code">
            <p
              class="text-red-500"
              v-for="error in errors.postal_code"
              :key="error"
            >
              {{ error }}
            </p>
          </div>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="city"
            >Ville</label
          >
          <input
            id="city"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            v-model="updateForm.city"
            required
          />
          <div v-if="errors && errors.city">
            <p class="text-red-500" v-for="error in errors.city" :key="error">
              {{ error }}
            </p>
          </div>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="firstname"
            >Prénom</label
          >
          <input
            id="firstname"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            v-model="updateForm.firstname"
            required
          />
          <div v-if="errors && errors.firstname">
            <p
              class="text-red-500"
              v-for="error in errors.firstname"
              :key="error"
            >
              {{ error }}
            </p>
          </div>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="lastname"
            >Nom</label
          >
          <input
            id="lastname"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            v-model="updateForm.lastname"
            required
          />
          <div v-if="errors && errors.lastname">
            <p
              class="text-red-500"
              v-for="error in errors.lastname"
              :key="error"
            >
              {{ error }}
            </p>
          </div>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="phone_number"
            >Télépone</label
          >
          <input
            id="phone_number"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="tel"
            v-model="updateForm.phone_number"
            required
          />
          <div v-if="errors && errors.phone_number">
            <p
              class="text-red-500"
              v-for="error in errors.phone_number"
              :key="error"
            >
              {{ error }}
            </p>
          </div>

          <div class="mt-5 flex gap-3 justify-end">
            <button
              @click="selectedAddress = null"
              class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full"
            >
              Annuler
            </button>
            <button
              class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
              type="submit"
            >
              Mettre à jour
            </button>
          </div>
        </form>

        <hr class="my-10" />

        <h2 class="text-xl">Supprimer votre adresse</h2>
        <button
          class="inline-block bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-full mt-3"
          type="submit"
          @click="deleteAddress()"
        >
          <font-awesome-icon icon="fa-solid fa-triangle-exclamation" />
          Supprimer
        </button>
      </div>
    </div>
    </transition>

    <!-- ADD MODAL -->
    <transition name="fade">
    <div
      class="modal"
      v-if="isAddModalOpen"
      @click.self="isAddModalOpen = false"
    >
      <div
        class="bg-white w-11/12 sm:w-3/4 lg:w-1/2 xl:w-1/3 p-5 border border-gray-200 rounded-lg shadow-xl"
      >
        <div class="flex justify-end">
          <svg
            @click="isAddModalOpen = false"
            class="h-7 w-7 cursor-pointer"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
          >
            <g stroke="#000000" stroke-linecap="round" stroke-width="2">
              <path d="M6 18L18 6" />
              <path d="M18 18L6 6" />
            </g>
          </svg>
        </div>

        <h2 class="text-xl">Mettre à jour votre adresse</h2>
        <form @submit.prevent="addAddress()">
          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="address"
            >Adresse</label
          >
          <input
            id="address"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            v-model="form.address"
            required
          />
          <div v-if="errors && errors.address">
            <p
              class="text-red-500"
              v-for="error in errors.address"
              :key="error"
            >
              {{ error }}
            </p>
          </div>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="postal_code"
            >Code postal</label
          >
          <input
            id="postal_code"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            v-model="form.postal_code"
            required
          />
          <div v-if="errors && errors.postal_code">
            <p
              class="text-red-500"
              v-for="error in errors.postal_code"
              :key="error"
            >
              {{ error }}
            </p>
          </div>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="city"
            >Ville</label
          >
          <input
            id="city"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            v-model="form.city"
            required
          />
          <div v-if="errors && errors.city">
            <p class="text-red-500" v-for="error in errors.city" :key="error">
              {{ error }}
            </p>
          </div>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="firstname"
            >Prénom</label
          >
          <input
            id="firstname"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            v-model="form.firstname"
            required
          />
          <div v-if="errors && errors.firstname">
            <p
              class="text-red-500"
              v-for="error in errors.firstname"
              :key="error"
            >
              {{ error }}
            </p>
          </div>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="lastname"
            >Nom</label
          >
          <input
            id="lastname"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            v-model="form.lastname"
            required
          />
          <div v-if="errors && errors.lastname">
            <p
              class="text-red-500"
              v-for="error in errors.lastname"
              :key="error"
            >
              {{ error }}
            </p>
          </div>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="phone_number"
            >Télépone</label
          >
          <input
            id="phone_number"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="tel"
            v-model="form.phone_number"
            required
          />
          <div v-if="errors && errors.phone_number">
            <p
              class="text-red-500"
              v-for="error in errors.phone_number"
              :key="error"
            >
              {{ error }}
            </p>
          </div>

          <div class="mt-5 flex gap-3 justify-end">
            <button
              @click="isAddModalOpen = false"
              class="inline-block bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-full"
            >
              Annuler
            </button>
            <button
              class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
              type="submit"
            >
              Ajouter
            </button>
          </div>
        </form>
      </div>
    </div>
    </transition>
  </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/inertia-vue3";
import axios from "axios";

export default {
  data() {
    return {
      addresses: this.$page.props.addresses,
      selectedAddress: null,
      updateForm: {
        address: null,
        postal_code: null,
        city: null,
        firstname: null,
        lastname: null,
        phone_number: null,
      },
      successMessage: null,
      errorMessage: null,
      errors: null,

      isAddModalOpen: false,
      form: {
        address: "",
        postal_code: "",
        city: "",
        firstname: "",
        lastname: "",
        phone_number: "",
      },
    };
  },

  components: {
    AuthenticatedLayout,
    Head,
  },

  methods: {
    setSelectedAddress(address) {
      this.updateForm = {
        address: address.address,
        postal_code: address.postal_code,
        city: address.city,
        firstname: address.firstname,
        lastname: address.lastname,
        phone_number: address.phone_number,
      };

      this.selectedAddress = address;
    },

    updateAddress() {
      axios
        .put(
          route("addresses.update", this.selectedAddress.id),
          this.updateForm
        )
        .then((response) => {
          this.addresses = response.data.addresses;
          this.successMessage = "Adresse mise à jour avec succès !";
          this.selectedAddress = null;
        })
        .catch((error) => {
          this.errorMessage = error.message;
        });
    },

    deleteAddress() {
      if (
        !window.confirm("Êtes-vous certain de vouloir supprimer cette adresse?")
      ) {
        return;
      }

      axios
        .delete(route("addresses.delete", this.selectedAddress.id))
        .then((response) => {
          this.addresses = response.data.addresses;
          this.successMessage = "Adresse supprimée avec succès !";
          this.selectedAddress = null;
        })
        .catch((error) => {
          this.errorMessage = error.message;
        });
    },

    addAddress() {
        axios.post(route('add-address'), this.form)
            .then((response) => {
                this.addresses = response.data.addresses;
                this.successMessage = "Adresse ajoutée avec succès !";
                this.isAddModalOpen = false;
            })
            .catch((error) => {
                this.errorMessage = error.message;
            })
    }
  },

  mounted() {
    console.log(this.addresses);
  },
};
</script>

<style scoped>
.address {
  box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
  padding: 10px 20px;
}

.modal {
  background: rgba(0, 0, 0, 0.2);
  height: 100vh;
  width: 100%;
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1000;
  display: flex;
  justify-content: center;
  align-items: center;
}
</style>
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

      <div class="flex justify-between items-center">
        <h2
          class="my-6 text-2xl font-semibold text-gray-700"
        >
          Catégories
        </h2>
        <button
          @click="toggleModal()"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
        >
          Ajouter
        </button>
      </div>

      
      <div class="flex gap-5">

      <div class="w-full">
        <h2 class="text-lg mb-5">Femmes</h2>
        <div class="w-full overflow-x-auto rounded-lg shadow-lg">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-100"
              >
                <th class="px-4 py-3">Nom</th>
                <th class="px-4 py-3 text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              <tr v-for="category in womenCategories" :key="category.id" class="text-gray-700">
                <td class="px-4 py-3">{{ category.name }}</td>
                <td class="px-4 py-3 flex gap-3 justify-center">
                  <button
                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:bg-green-200"
                  >
                    Edit
                  </button>
                  <button
                    class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:bg-red-200"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>

      

      <div class="w-full">
        <h2 class="text-lg mb-5">Hommes</h2>
        <div class="w-full overflow-x-auto rounded-lg shadow-lg">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-100"
              >
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3 text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              <tr v-for="category in menCategories" :key="category.id" class="text-gray-700">
                <td class="px-4 py-3">{{ category.name }}</td>
                <td class="px-4 py-3 flex gap-3 justify-center">
                  <button
                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:bg-green-200"
                  >
                    Edit
                  </button>
                  <button
                    class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:bg-red-200"
                  >
                    Delete
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    </div>

    <div class="add-modal" v-if="isAddModalOpen" @click.self="isAddModalOpen = false">
      <div
        class="bg-white w-11/12 sm:w-3/4 lg:w-1/2 xl:w-1/3 p-5 border border-gray-200 rounded-lg shadow-xl"
      >
        <div class="flex justify-end">
          <svg
            @click="toggleModal()"
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

        <h2 class="text-xl">Ajouter une catégorie</h2>
        <form @submit.prevent="store()">
          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="name"
            >Nom</label
          >
          <input
            id="name"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            type="text"
            v-model="form.name"
            required
          />
          <div v-if="errors && errors.name">
            <p class="text-red-500" v-for="error in errors.name" :key="error">
              {{ error }}
            </p>
          </div>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="sex"
            >Sexe</label
          >
          <select class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" name="sex" id="sex">
            <option value="Femme">Femme</option>
            <option value="Homme">Homme</option>
          </select>

          <label
            class="block text-gray-700 text-sm font-bold mb-2 mt-5"
            for="image"
            >Image</label
          >
          <input
            class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
            type="file"
            @input="form.image = $event.target.files[0]"
            required
          />
          <div v-if="errors && errors.image">
            <p class="text-red-500" v-for="error in errors.image" :key="error">
              {{ error }}
            </p>
          </div>

          <div class="mt-5 flex gap-3 justify-end">
            <button
              @click="toggleModal()"
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
  </AdminLayout>
</template>
  
  <script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from "axios";

export default {
  name: "Products",

  data() {
    return {
      isAddModalOpen: false,
      form: {
        name: null,
        sex: null,
        image: null
      },
      successMessage: null,
      errorMessage: null,
      errors: null,

      menCategories: this.$inertia.page.props.menCategories,
      womenCategories: this.$inertia.page.props.womenCategories,
    };
  },

  components: {
    AdminLayout,
  },

  methods: {
    toggleModal() {
      this.isAddModalOpen = !this.isAddModalOpen;
    },

    store() {
        axios.post(route('admin.categories.store'), this.form, {
                headers: {
                    "Content-Type": "multipart/form-data",
                }
            })
            .then((response) => {

            })
            .catch((error) => {

            });
    }
  },
};
</script>
  
  <style scoped>
.add-modal {
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
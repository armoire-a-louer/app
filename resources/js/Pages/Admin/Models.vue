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
        <h2 class="my-6 text-2xl font-semibold text-gray-700">Modèles</h2>
        <button
          @click="toggleAddModal()"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
        >
          Ajouter
        </button>
      </div>

      <div class="w-full overflow-x-auto rounded-lg shadow-lg">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-100"
            >
              <th class="px-4 py-3">#</th>
              <th class="px-4 py-3">Nom</th>
              <th class="px-4 py-3">Taille</th>
              <th class="px-4 py-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y">
            <tr v-for="model in models" :key="model.id" class="text-gray-700">
              <td>
                <img
                  class="h-20 w-20 object-cover"
                  :src="model.image_url"
                  alt=""
                />
              </td>
              <td class="px-4 py-3">{{ model.name }}</td>
              <td class="px-4 py-3">{{ model.size }} cm</td>
              <td class="px-4 py-3">
                <div class="justify-center items-center flex gap-3">
                  <button
                    class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:bg-green-200"
                    @click="toggleEditModal(model)"
                  >
                    Edit
                  </button>
                  <button
                    class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:bg-red-200"
                    @click="destroy(model)"
                  >
                    Delete
                  </button>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div
        class="add-modal"
        v-if="isAddModalOpen"
        @click.self="isAddModalOpen = false"
      >
        <div
          class="bg-white w-11/12 sm:w-3/4 lg:w-1/2 xl:w-2/3 p-5 border border-gray-200 rounded-lg shadow-xl"
        >
          <div class="flex justify-end">
            <svg
              @click="toggleAddModal()"
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

          <h2 class="text-xl">Ajouter un(e) modèle</h2>
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
              for="size"
              >Taille (en cm)</label
            >
            <input
              id="size"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              type="number"
              v-model="form.size"
              min="100"
              required
            />
            <div v-if="errors && errors.size">
              <p class="text-red-500" v-for="error in errors.size" :key="error">
                {{ error }}
              </p>
            </div>

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
              <p
                class="text-red-500"
                v-for="error in errors.image"
                :key="error"
              >
                {{ error }}
              </p>
            </div>

            <div class="mt-5 flex gap-3 justify-end">
              <button
                @click="toggleAddModal()"
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

      <div
        class="add-modal"
        v-if="isEditModalOpen"
        @click.self="isEditModalOpen = false"
      >
        <div
          class="bg-white w-11/12 sm:w-3/4 lg:w-1/2 xl:w-2/3 p-5 border border-gray-200 rounded-lg shadow-xl"
        >
          <div class="flex justify-end">
            <svg
              @click="isEditModalOpen = false"
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

          <h2 class="text-xl">Modifier un(e) modèle</h2>
          <form @submit.prevent="update()">
            <label
              class="block text-gray-700 text-sm font-bold mb-2 mt-5"
              for="name"
              >Nom</label
            >
            <input
              id="name"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              type="text"
              v-model="editForm.name"
              required
            />
            <div v-if="errors && errors.name">
              <p class="text-red-500" v-for="error in errors.name" :key="error">
                {{ error }}
              </p>
            </div>

            <label
              class="block text-gray-700 text-sm font-bold mb-2 mt-5"
              for="size"
              >Taille (en cm)</label
            >
            <input
              id="size"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              type="number"
              v-model="editForm.size"
              min="100"
              required
            />
            <div v-if="errors && errors.size">
              <p class="text-red-500" v-for="error in errors.size" :key="error">
                {{ error }}
              </p>
            </div>

            <label
              class="block text-gray-700 text-sm font-bold mb-2 mt-5"
              for="image"
              >Image (laisser vide pour ne pas modifier)</label
            >
            <input
              class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
              type="file"
              @input="editForm.image = $event.target.files[0]"
            />
            <div v-if="errors && errors.image">
              <p
                class="text-red-500"
                v-for="error in errors.image"
                :key="error"
              >
                {{ error }}
              </p>
            </div>

            <div class="mt-5 flex gap-3 justify-end">
              <button
                @click="isEditModalOpen = false"
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
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from "axios";

export default {
  name: "Models",

  data() {
    return {
      isAddModalOpen: false,
      isEditModalOpen: false,
      editModel: null,
      successMessage: "",
      errorMessage: "",
      form: {
        name: null,
        size: null,
        image: null,
      },
      errors: null,
      models: this.$inertia.page.props.models,
      editForm: {
        name: null,
        size: null,
        image: null,
      },
    };
  },

  methods: {
    toggleAddModal() {
      this.isAddModalOpen = !this.isAddModalOpen;
    },

    toggleEditModal(model) {
      this.isEditModalOpen = !this.isEditModalOpen;

      this.editForm.name = model.name;
      this.editForm.size = model.size;

      this.editModel = model;
    },

    destroy(model) {
        if (! window.confirm("Êtes-vous certain de vouloir supprimer ce modèle ?")) {
            return;
        }

      axios
        .delete(route("admin.models.delete", model.id))
        .then((response) => {
          this.models = response.data;
          this.successMessage = "Modèle supprimé avec succès !";
        })
        .catch((error) => {
          this.errorMessage = error.message;
        });
    },

    store() {
      axios
        .post(route("admin.models.store"), this.form, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.models = response.data;
          this.successMessage = "Modèle ajouté avec succès !";
          this.toggleAddModal();
        })
        .catch((error) => {
          this.errorMessage = error.message;
        });
    },

    update() {
      axios
        .post(route("admin.models.update", this.editModel.id), this.editForm, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.models = response.data;
          this.isEditModalOpen = false;
          this.successMessage = "Modèle mis à jour avec succès !";
        })
        .catch((error) => {
          this.errorMessage = error.message;
        });
    },
  },

  components: {
    AdminLayout,
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
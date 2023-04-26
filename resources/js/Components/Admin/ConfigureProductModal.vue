<template>
  <div class="edit-modal" @click.self="$emit('close')">
    <div
      class="bg-white w-11/12 sm:w-3/4 p-5 border border-gray-200 rounded-lg shadow-xl overflow-scroll"
    >
      <div class="flex justify-end">
        <svg
          @click="$emit('close')"
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

      <div
        v-if="successMessage"
        class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-5"
        role="alert"
      >
        <p class="font-bold">Succès</p>
        <p>{{ successMessage }}</p>
      </div>

      <div
        v-else-if="errorMessage"
        class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-5"
        role="alert"
      >
        <p class="font-bold">Erreur</p>
        <p>{{ errorMessage }}</p>
      </div>

      <h2 class="text-xl">Configurer un produit et ses articles</h2>

      <h3 class="text-lg mt-4">Articles</h3>

      <div class="w-full overflow-x-auto rounded-lg shadow-lg">
        <table class="w-full whitespace-no-wrap">
          <thead>
            <tr
              class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-100"
            >
              <th class="px-4 py-3 text-center">#</th>
              <th class="px-4 py-3 text-center">Couleur principale</th>
              <th class="px-4 py-3 text-center">Couleur secondaire</th>
              <th class="px-4 py-3 text-center">Taille</th>
              <th class="px-4 py-3 text-center">Quantité</th>
              <th class="px-4 py-3 text-center">Taille du modèle</th>
              <th class="px-4 py-3 text-center">Actif</th>
              <th class="px-4 py-3 text-center">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y">
            <tr
              v-for="item in product.items"
              :key="product.id"
              class="text-gray-700"
            >
              <td>
                <img
                  style="max-width: 50px; max-height: 50px; margin: auto"
                  :src="product.image_url"
                  :alt="product.name"
                />
              </td>
              <td>
                <div class="flex justify-center">
                  <div class="px-4 py-3 flex gap-3 items-center margin-auto">
                    <span
                      class="block h-6 w-6 border"
                      :style="
                        'background-color: ' + item.primary_color.hex_code
                      "
                    >
                    </span>
                    {{ item.primary_color.hex_code }}
                  </div>
                </div>
              </td>
              <td>
                <div class="flex justify-center">
                  <div class="px-4 py-3 flex gap-3 items-center margin-auto">
                    <span
                      class="block h-6 w-6 border"
                      :style="
                        'background-color: ' + item.secondary_color.hex_code
                      "
                    >
                    </span>
                    {{ item.secondary_color.hex_code }}
                  </div>
                </div>
              </td>
              <td class="text-center uppercase">
                {{ item.size }}
              </td>
              <td class="text-center">
                {{ item.quantity }}
              </td>
              <td class="text-center">{{ item.model_size }} cm</td>
              <td class="px-4 py-3 text-center">
                <font-awesome-icon
                  class="text-lime-500"
                  icon="fa-solid fa-circle-check"
                  v-if="item.active"
                />
                <font-awesome-icon
                  class="text-red-700"
                  icon="fa-solid fa-circle-xmark"
                  v-else
                />
              </td>
              <td class="px-4 py-3">
                  <div class="justify-center items-center flex gap-3">
                    <button
                      class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:bg-green-200"
                      @click="update(item)"
                    >
                      Edit
                    </button>
                    <button
                      class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:bg-red-200"
                      @click="destroy(item)"
                    >
                      Delete
                    </button>
                  </div>
                </td>
            </tr>
          </tbody>
        </table>
      </div>

      <div @click="isAddItemModalOpen = true" class="mt-5 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded text-center cursor-pointer">
        <font-awesome-icon icon="fa-solid fa-plus" />
            Ajouter un article
        </div>
    </div>

    <transition name="fade-left">
        <AddItemModal v-if="isAddItemModalOpen" @close="isAddItemModalOpen = false" :product="product" :colors="colors" :sizes="sizes" @success="successMessage = $event" @error="errorMessage = $event"/>
    </transition>
  </div>
</template>

<script>
import AddItemModal from './AddItemModal.vue';

export default {
  props: ["product", "colors", "sizes"],

  data() {
    return {
      successMessage: "",
      errorMessage: "",

      isAddItemModalOpen: false
    };
  },

  components: {
    AddItemModal
  },

  methods: {
    update(item) {

    },

    destroy(item) {
        if (! window.confirm("Êtes-vous sûr de vouloir supprimer cet article ?")) {
            return;
        }

        axios.delete(route('admin.products.items.delete', item.id))
            .then((response) => {
                this.$emit('updateProductsList', response.data);

                this.product.items = this.product.items.filter((el) => {
                    return el.id != item.id
                })

                this.successMessage = "Article supprimé avec succès !";
            })
            .catch((error) => {
                this.errorMessage = error.message;
            })
    }
  }
};
</script>

<style scoped>
.edit-modal {
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
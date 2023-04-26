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
        <h2 class="my-6 text-2xl font-semibold text-gray-700">Produits</h2>
        <button
          @click="toggleModal()"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full"
        >
          Ajouter
        </button>
      </div>

      <div class="w-full">
        <div class="w-full overflow-x-auto rounded-lg shadow-lg">
          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b bg-gray-100"
              >
                <th class="px-4 py-3 text-center">#</th>
                <th class="px-4 py-3 text-center">Nom</th>
                <th class="px-4 py-3 text-center">Marque</th>
                <th class="px-4 py-3 text-center">Catégorie</th>
                <th class="px-4 py-3 text-center">Matériau(x)</th>
                <th class="px-4 py-3 text-center">Prix par jour</th>
                <th class="px-4 py-3 text-center">Actif</th>
                <th class="px-4 py-3 text-center">Actions</th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y">
              <tr v-for="product in products" :key="product.id" class="text-gray-700">
                <td class="px-4 py-3">
                  <img style="max-width: 50px; max-height: 50px; margin: auto;" :src="product.image_url" :alt="product.name">
                </td>
                <td class="px-4 py-3 text-center">{{ product.name }}</td>
                <td class="px-4 py-3 text-center">{{ product.brand.name }}</td>
                <td class="px-4 py-3 text-center">{{ product.category.name }}</td>
                <td class="px-4 py-3 text-center">
                  <ul>
                    <li v-for="material in product.materials" :key="material.id">- {{ material.name }}</li>
                  </ul>
                </td>
                <td class="px-4 py-3 text-center">{{ product.price_per_day }} €</td>
                <td class="px-4 py-3 text-center">
                  <font-awesome-icon class="text-lime-500" icon="fa-solid fa-circle-check" v-if="product.active"/>
                  <font-awesome-icon class="text-red-700" icon="fa-solid fa-circle-xmark" v-else/>
                </td>
                <td class="px-4 py-3">
                  <div class="justify-center items-center flex gap-3">
                    <button
                      class="px-2 py-1 font-semibold leading-tight text-lime-700 bg-lime-100 rounded-md hover:bg-lime-200 focus:outline-none focus:bg-lime-200"
                      @click="configure(product)"
                    >
                      Configurer
                    </button>
                    <button
                      class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-md hover:bg-green-200 focus:outline-none focus:bg-green-200"
                      @click="update(product)"
                    >
                      Edit
                    </button>
                    <button
                      class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-md hover:bg-red-200 focus:outline-none focus:bg-red-200"
                      @click="destroy(product)"
                    >
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <transition name="fade">
      <div
        class="add-modal"
        v-if="isAddModalOpen"
        @click.self="isAddModalOpen = false"
      >
        <div
          class="bg-white w-11/12 sm:w-3/4 lg:w-1/2 xl:w-2/3 p-5 border border-gray-200 rounded-lg shadow-xl overflow-scroll"
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

          <h2 class="text-xl">Ajouter un produit</h2>
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
              for="price_per_day"
              >Prix</label
            >
            <input
              id="price_per_day"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              type="number"
              min="0"
              v-model="form.price_per_day"
              required
            />
            <div v-if="errors && errors.price_per_day">
              <p class="text-red-500" v-for="error in errors.price_per_day" :key="error">
                {{ error }}
              </p>
            </div>

            <label
              class="block text-gray-700 text-sm font-bold mb-2 mt-5"
              for="category_id"
            >
              Catégorie
            </label>
            <select
              v-model="form.category_id"
              name="category_id"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
              <optgroup label="Femme">
                <option
                  v-for="category in womenCategories"
                  :key="category.id"
                  :value="category.id"
                >
                  {{ category.name }}
                </option>
              </optgroup>
              <optgroup label="Homme">
                <option
                  v-for="category in menCategories"
                  :key="category.id"
                  :value="category.id"
                >
                  {{ category.name }}
                </option>
              </optgroup>
            </select>
            <div v-if="errors && errors.category_id">
              <p
                class="text-red-500"
                v-for="error in errors.category_id"
                :key="error"
              >
                {{ error }}
              </p>
            </div>

            <label
              class="block text-gray-700 text-sm font-bold mb-2 mt-5"
              for="brand_id"
            >
              Marque
            </label>
            <select
              v-model="form.brand_id"
              name="brand_id"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
              <option
                v-for="brand in brands"
                :key="brand.id"
                :value="brand.id"
              >
                {{ brand.name }}
              </option>
            </select>
            <div v-if="errors && errors.brand_id">
              <p
                class="text-red-500"
                v-for="error in errors.brand_id"
                :key="error"
              >
                {{ error }}
              </p>
            </div>

            <label
              class="block text-gray-700 text-sm font-bold mb-2 mt-5"
              for="season"
            >
              Saison
            </label>
            <select
              v-model="form.season"
              name="season"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
            >
              <option
                v-for="season in seasons"
                :key="season"
                :value="season"
              >
                {{ season }}
              </option>
            </select>
            <div v-if="errors && errors.season">
              <p
                class="text-red-500"
                v-for="error in errors.season"
                :key="error"
              >
                {{ error }}
              </p>
            </div>

            <label
              class="block text-gray-700 text-sm font-bold mb-2 mt-5"
              for="materials_ids"
            >
              Matériau(x)
            </label>
            <select
              v-model="form.materials_ids"
              name="materials_ids"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              required
              multiple
            >
              <option
                v-for="material in materials"
                :key="material"
                :value="material.id"
              >
                {{ material.name }}
              </option>
            </select>
            <div v-if="errors && errors.materials_ids">
              <p
                class="text-red-500"
                v-for="error in errors.materials_ids"
                :key="error"
              >
                {{ error }}
              </p>
            </div>

            <label
              class="block text-gray-700 text-sm font-bold mb-2 mt-5"
              for="description"
              >Description</label
            >
            <textarea
              id="description"
              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
              v-model="form.description"
              required
            ></textarea>
            <div v-if="errors && errors.description">
              <p class="text-red-500" v-for="error in errors.description" :key="error">
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
              <p class="text-red-500" v-for="error in errors.image" :key="error">
                {{ error }}
              </p>
            </div>

            <label class="relative inline-flex items-center cursor-pointer mt-5">
              <input
                type="checkbox"
                v-model="form.active"
                class="sr-only peer"
                checked
              />
              <div
                class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"
              ></div>
              <span class="ml-3 text-sm font-medium text-gray-900">Active</span>
            </label>

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
    </transition>
    <transition name="fade">
      <EditProductModal v-if="isEditModalOpen" @close="isEditModalOpen = false" @updateProductsList="products = $event" :product="editProduct" :menCategories="menCategories" :womenCategories="womenCategories" :brands="brands" :materials="materials" :seasons="seasons" @success="successMessage = $event"/>
    </transition>


    <transition name="fade">
      <ConfigureProductModal v-if="isConfigModalOpen" @close="isConfigModalOpen = false" :product="configProduct" @success="successMessage = $event" :colors="colors" :sizes="sizes" @updateProductsList="products = $event"/>
    </transition>
  </AdminLayout>
</template>
  
<script>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import axios from "axios";
import EditProductModal from '@/Components/Admin/EditProductModal.vue';
import ConfigureProductModal from '@/Components/Admin/ConfigureProductModal.vue';

export default {
  name: "Products",

  data() {
    return {
      isAddModalOpen: false,
      form: {
        name: null,
        price_per_day: null,
        category_id: null,
        brand_id: null,
        materials_ids: null,
        description: null,
        image: null,
        active: true,
        season: null
      },
      products: this.$inertia.page.props.products,
      successMessage: null,
      errorMessage: null,
      errors: null,
      womenCategories: this.$inertia.page.props.womenCategories,
      menCategories: this.$inertia.page.props.menCategories,
      brands: this.$inertia.page.props.brands,
      seasons: this.$inertia.page.props.seasons,
      materials: this.$inertia.page.props.materials,
      sizes: this.$inertia.page.props.sizes,
      colors: this.$inertia.page.props.colors,

      isEditModalOpen: false,
      editProduct: null,

      isConfigModalOpen: false,
      configProduct: null
    };
  },

  components: {
    AdminLayout,
    ConfigureProductModal,
    EditProductModal
  },

  methods: {
    toggleModal() {
      this.isAddModalOpen = !this.isAddModalOpen;
    },

    store() {
      this.form.active = this.form.active ? 1 : 0;

        axios
          .post(route('admin.products.store'), this.form, {
            headers: {
                "Content-Type": "multipart/form-data",
            }
          })
          .then((response) => {
            this.products = response.data;
            this.successMessage = "Produit ajouté avec succès !";

            this.form = {
              name: null,
              price_per_day: null,
              category_id: null,
              brand_id: null,
              materials_ids: null,
              description: null,
              image: null,
              active: true
            }
            this.isAddModalOpen = false;
          })
          .catch((error) => {
            this.errors = error.response.data.errors;
          });
    },

    destroy(product) {
      if (! window.confirm("Êtes-vous sûr de vouloir supprimer le produit " + product.name)) {
        return;
      }

      axios.delete(route("admin.products.delete", product.id))
        .then((response) => {
          this.products = response.data;
          this.successMessage = "Produit supprimé avec succès !";
        })
        .catch((error) => {
          this.errorMessage = error.message;
        })
    },

    update(product) {
      this.editProduct = product;
      this.isEditModalOpen = true;
    },

    configure(product) {
      this.isConfigModalOpen = true;
      this.configProduct = product;
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
  overflow: hidden;
  height: 100vh;
}

.add-modal > div {
  overflow: scroll;
  max-height: 90vh;
  margin-top: 150px;
  margin-bottom: 150px;
}
</style>
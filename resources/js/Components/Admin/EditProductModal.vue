<template>
  <div
      class="add-modal"
      @click.self="$emit('close')"
    >
      <div
        class="bg-white w-11/12 sm:w-3/4 lg:w-1/2 xl:w-2/3 p-5 border border-gray-200 rounded-lg shadow-xl overflow-scroll"
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

        <h2 class="text-xl">Modifier un produit</h2>
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
              :selected="product.materials.some(m => m.id === material.id)"
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
            >Image (laisser vide pour ne pas la changer)</label
          >
          <input
            class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
            type="file"
            @input="form.image = $event.target.files[0]"
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
              @click="$emit('close')"
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
</template>

<script>
import axios from "axios";

export default {
    name: "EditProductModal",

    props: ['product', 'menCategories', 'womenCategories', 'brands', 'seasons', 'materials'],

    data() {
        return {
            form: {
                name: this.product.name,
                price_per_day: this.product.price_per_day,
                category_id: this.product.category_id,
                brand_id: this.product.brand_id,
                materials_ids: this.product.materials.map((el) => {
                    return el.id
                }),
                description: this.product.description,
                image: null,
                active: this.product.active ? true : false,
                season: this.product.season
            },

            errors: null
        }
    },

    methods: {
        update() {
            this.form.active = this.form.active ? 1 : 0;

            axios.post(route('admin.products.update', this.product.id), this.form, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    }
                })
                .then((response) => {
                    this.$emit('updateProductsList', response.data);
                    this.$emit('success', "Produit mis à jour avec succès !");
                    this.$emit('close');
                })
                .catch((error) => {
                    this.errors = error.response.data.errors;
                })
        }
    }
}
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
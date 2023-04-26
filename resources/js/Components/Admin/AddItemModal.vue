<template>
  <div class="add-modal" @click.self="$emit('close')">
    <div
      class="bg-white w-11/12 sm:w-3/4 lg:w-1/2 xl:w-2/3 p-5 border border-gray-200 rounded-lg shadow-xl"
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

      <h2 class="text-xl">Ajouter un article</h2>
      <form @submit.prevent="store()">
        <label
          class="block text-gray-700 text-sm font-bold mb-2 mt-5"
          for="primary_color_id"
          >Couleur primaire</label
        >
        <input
          id="primary_color_id"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          type="color"
          v-model="form.primary_color_id"
          required
        />
        <div v-if="errors && errors.primary_color_id">
          <p
            class="text-red-500"
            v-for="error in errors.primary_color_id"
            :key="error"
          >
            {{ error }}
          </p>
        </div>

        <label
          class="block text-gray-700 text-sm font-bold mb-2 mt-5"
          for="secondary_color_id"
          >Couleur secondaire (facultative)</label
        >
        <input
          id="secondary_color_id"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          type="color"
          v-model="form.secondary_color_id"
        />
        <div v-if="errors && errors.secondary_color_id">
          <p
            class="text-red-500"
            v-for="error in errors.secondary_color_id"
            :key="error"
          >
            {{ error }}
          </p>
        </div>

        <label
          class="block text-gray-700 text-sm font-bold mb-2 mt-5"
          for="size"
          >Taille</label
        >
        <select
          v-model="form.size"
          name="size"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        >
          <option v-for="size in sizes" :key="size" :value="size">
            {{ size }}
          </option>
        </select>
        <div v-if="errors && errors.size">
          <p class="text-red-500" v-for="error in errors.size" :key="error">
            {{ error }}
          </p>
        </div>

        <label
          class="block text-gray-700 text-sm font-bold mb-2 mt-5"
          for="quantity"
          >Quantité (stock dispo)</label
        >
        <input
          id="quantity"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          type="number"
          min="1"
          v-model="form.quantity"
          required
        />
        <div v-if="errors && errors.quantity">
          <p class="text-red-500" v-for="error in errors.quantity" :key="error">
            {{ error }}
          </p>
        </div>

        <label
          class="block text-gray-700 text-sm font-bold mb-2 mt-5"
          for="model_size"
          >Taille du modèle (en cm)</label
        >
        <input
          id="model_size"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          type="number"
          min="1"
          max="220"
          v-model="form.model_size"
          required
        />
        <div v-if="errors && errors.model_size">
          <p
            class="text-red-500"
            v-for="error in errors.model_size"
            :key="error"
          >
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
            Ajouter
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  props: ["product", "colors", "sizes"],

  data() {
    return {
      form: {
        product_id: this.product.id,
        primary_color_id: null,
        secondary_color_id: null,
        size: null,
        quantity: null,
        model_size: null,
        active: true,
        principal_image: null,
        other_images: []
      },
    };
  },

  methods: {
    store() {
      axios
        .post(route("admin.products.items.store"), this.form, {
          headers: {
            "Content-Type": "multipart/form-data",
          },
        })
        .then((response) => {
          this.$emit("success", "Article ajouté avec succès !");
        })
        .catch((error) => {
          this.$emit("error", error.message);
        });
    },
  },
};
</script>

<style scoped>
.add-modal {
  background: rgba(0, 0, 0, 0.6);
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
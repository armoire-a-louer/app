<template>
  <div
      class="add-modal"
      @click.self="$emit('close')"
    >
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
    props: ['product', 'colors', 'sizes'],

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
                image1: null,
                image2: null,
                image3: null,
                image4: null,
            }
        }
    },

    methods: {
        store() {
            
        }
    },

    mounted() {
        console.log(this.product, this.colors, this.sizes);
    }
}
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
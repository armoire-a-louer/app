<template>
  <div
    class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-md"
  >
    <span v-if="brand.active" class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300 absolute">Active</span>
    <div class="flex flex-col items-center py-10">
      <img
        class="w-24 h-24 mb-3 rounded-full shadow-lg"
        :src="brand.image_url"
        :alt="brand.name"
      />
      <h5 class="mb-1 text-xl font-medium text-gray-900">{{ brand.name }}</h5>
      <!-- <span class="text-sm text-gray-500">Visual Designer</span> -->

      <div v-if="isModalOpen" class="modal">
        <div
          class="
            bg-white
            w-11/12
            sm:w-3/4
            lg:w-1/2
            xl:w-1/3
            p-5
            border border-gray-200
            rounded-lg
            shadow-xl
          "
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

          <h2 class="text-xl">Modifier une marque</h2>
          <form @submit.prevent="update()">
            <label
              class="block text-gray-700 text-sm font-bold mb-2 mt-5"
              for="name"
              >Nom</label
            >
            <input
              id="name"
              class="
                shadow
                appearance-none
                border
                rounded
                w-full
                py-2
                px-3
                text-gray-700
                leading-tight
                focus:outline-none focus:shadow-outline
              "
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
              for="image"
              >Image (ne pas choisir de fichier pour laisser l'image
              actuelle)</label
            >
            <input
              class="
                form-control
                block
                w-full
                px-3
                py-1.5
                text-base
                font-normal
                text-gray-700
                bg-white bg-clip-padding
                border border-solid border-gray-300
                rounded
                transition
                ease-in-out
                m-0
                focus:text-gray-700
                focus:bg-white
                focus:border-blue-600
                focus:outline-none
              "
              type="file"
              @input="form.image = $event.target.files[0]"
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

            <label
              class="relative inline-flex items-center cursor-pointer mt-5"
            >
              <input
                type="checkbox"
                v-model="form.active"
                class="sr-only peer"
                checked
              />
              <div
                class="
                  w-11
                  h-6
                  bg-gray-200
                  peer-focus:outline-none
                  peer-focus:ring-4
                  peer-focus:ring-blue-300
                  dark:peer-focus:ring-blue-800
                  rounded-full
                  peer
                  dark:bg-gray-700
                  peer-checked:after:translate-x-full
                  peer-checked:after:border-white
                  after:content-['']
                  after:absolute
                  after:top-[2px]
                  after:left-[2px]
                  after:bg-white
                  after:border-gray-300
                  after:border
                  after:rounded-full
                  after:h-5
                  after:w-5
                  after:transition-all
                  dark:border-gray-600
                  peer-checked:bg-blue-600
                "
              ></div>
              <span
                class="
                  ml-3
                  text-sm
                  font-medium
                  text-gray-900
                  dark:text-gray-300
                "
                >Active</span
              >
            </label>

            <div class="mt-5 flex gap-3 justify-end">
              <button
                @click="toggleModal()"
                class="
                  inline-block
                  bg-gray-500
                  hover:bg-gray-700
                  text-white
                  font-bold
                  py-2
                  px-4
                  rounded-full
                "
              >
                Annuler
              </button>
              <button
                class="
                  inline-block
                  bg-blue-500
                  hover:bg-blue-700
                  text-white
                  font-bold
                  py-2
                  px-4
                  rounded-full
                "
                type="submit"
              >
                Mettre à jour
              </button>
            </div>
          </form>
        </div>
      </div>

      <div class="flex mt-4 space-x-3 md:mt-6">
        <a
          href="#"
          class="
            inline-flex
            items-center
            px-4
            py-2
            text-sm
            font-medium
            text-center text-gray-900
            bg-white
            border border-gray-300
            rounded-lg
            hover:bg-gray-100
            focus:ring-4 focus:outline-none focus:ring-gray-200
          "
          @click="toggleModal()"
          >Modifier</a
        >
        <btn
          @click="softDelete()"
          class="
            cursor-pointer
            inline-flex
            items-center
            px-4
            py-2
            text-sm
            font-medium
            text-center text-white
            bg-red-600
            rounded-lg
            hover:bg-red-700
            focus:ring-4 focus:outline-none focus:ring-blue-300
          "
          >Supprimer</btn
        >
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "BrandCard",

  props: ["brand"],

  data() {
    return {
      isModalOpen: false,
      updatePending: false,
      form: {
        name: this.brand.name,
        image: null,
        active: this.brand.active ? true : false,
        id: this.brand.id,
      },
      errors: null,
    };
  },

  methods: {
    toggleModal() {
      this.isModalOpen = !this.isModalOpen;
    },

    update() {
      const url = route("admin.brands.update", this.form.id)
      const data = {
        id: this.form.id,
        name: this.form.name,
        image: this.form.image,
        active: this.form.active ? 1 : 0
      }
      const headers = {
        'Content-Type': 'multipart/form-data',
      }

      axios
        .post(url, data, { headers: headers })
        .then((response) => {
          this.$emit("brands", response.data);
          this.$emit('success', 'Entreprise mise à jour avec succès');
          this.isModalOpen = false;
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        });
    },

    softDelete() {
      if (! confirm('Êtes-vous sûr de vouloir supprimer cette marque et tous les articles associés ?')) {
        return;
      }

      axios
        .delete(route("admin.brands.delete", this.brand.id))
        .then((response) => {
          this.$emit("brands", response.data);
          this.$emit('success', 'Entreprise supprimée avec succès');
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
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
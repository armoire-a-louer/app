<template>
  <div class="add-modal">
    <div
      class="bg-white w-11/12 sm:w-3/4 lg:w-1/2 xl:w-1/3 p-5 border border-gray-200 rounded-lg shadow-xl"
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

        <label class="block text-gray-700 text-sm font-bold mb-2 mt-5" for="sex"
          >Sexe</label
        >
        <select
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          name="sex"
          id="sex"
          v-model="form.sex"
        >
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
</template>

<script>
export default {
  data() {
    return {

    };
  },
};
</script>

<style>
</style>
<template>
    <div
      id="defaultModal"
      tabindex="-1"
      class="fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full text-black"
      @click.self="$emit('close')"
    >
      <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow">
          <!-- Modal header -->
          <div
            class="flex items-center justify-between p-4 border-b rounded-t"
          >
            <div class="flex items-center">
                <img style="width: 20px" src="/images/icons/search_black.svg" />
                <input v-model="search" @keyup.enter="makeSearch(search)" class="search-input" type="text" autofocus placeholder="Robes, pantalons, vestes, manteaux et bien plus...">
            </div>
            <button
              type="button"
              class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
              data-modal-hide="defaultModal"
              @click="$emit('close')"
            >
              <svg
                class="w-5 h-5"
                fill="currentColor"
                viewBox="0 0 20 20"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  fill-rule="evenodd"
                  d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                ></path>
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-6 space-y-3">
            <p v-if="! ancientSearches.length" class="text-center text-lg">Aucune recherche récente</p>

            <p v-for="ancientSearch in ancientSearches" :key="ancientSearch" class="text-center text-lg cursor-pointer" @click="makeSearch(ancientSearch)">
              {{ ancientSearch }}
            </p>
          </div>
          <!-- Modal footer -->
          <div
            class="flex justify-end items-center p-6 space-x-2 border-t border-gray-200 rounded-b"
          >
            :)
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import { Inertia } from '@inertiajs/inertia'
import { Link } from '@inertiajs/inertia-vue3';

export default {
  data() {
    return {
      search: ""
    }
  },

  components: {
    Link
  },

  mounted() {
    if (this.$page.props.queryParams && this.$page.props.queryParams.search) {
      this.search = this.$page.props.queryParams.search;
    }
  },

  computed: {
    ancientSearches() {
      let ancientSearches = JSON.parse(localStorage.getItem("searches"));

      if (! ancientSearches) {
        ancientSearches = []
      }

      return Array.from(ancientSearches).reverse();
    }
  },

  methods: {
    makeSearch(search) {
      let ancientSearches = JSON.parse(localStorage.getItem("searches"));

      if (ancientSearches) {
        ancientSearches = Array.from(ancientSearches);
      } else {
        ancientSearches = [];
      }

      ancientSearches.push(search);

      if (ancientSearches && ancientSearches.length > 5) {
        ancientSearches = ancientSearches.slice(-5);
      }

      localStorage.setItem("searches", JSON.stringify(ancientSearches));

      const data = {
          search: search
      }

      const options = {
          method: 'get',
          data: data,
          preserveScroll: false,
          onSuccess: page => {

          },
      }

      Inertia.visit(route('search'), options);
    }
  }
};
</script>

<style scoped>
#defaultModal {
    backdrop-filter: blur(3px);
    background: rgba(0, 0, 0, 0.2);
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    justify-content: center;
    align-items: center;
    display: flex;
    box-shadow: rgba(0, 0, 0, 0.05) 0px 6px 24px 0px, rgba(0, 0, 0, 0.08) 0px 0px 0px 1px;
}

.search-input {
    border: 0;
    width: 500px;
    outline: none;
    max-width: 100%;
}

.search-input:focus {
    outline: none !important;
    box-shadow: none;
}
</style>
<template>
<div class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow-md">
    <div class="flex flex-col items-center py-10">
        <img class="w-24 h-24 mb-3 rounded-full shadow-lg" src="/docs/images/people/profile-picture-3.jpg" alt="Bonnie image"/>
        <h5 class="mb-1 text-xl font-medium text-gray-900">{{ brand.name }}</h5>
        <!-- <span class="text-sm text-gray-500">Visual Designer</span> -->

        <div ref="modal" class="modal" :class="{ 'open': isModalOpen }">
            <div class="bg-white w-11/12 sm:w-3/4 lg:w-1/2 xl:w-1/3 p-5 border border-gray-200 rounded-lg shadow-xl">
                <div class="flex justify-end">
                    <svg @click="toggleModal()" class="h-7 w-7 cursor-pointer" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" fill="none">
                        <g stroke="#000000" stroke-linecap="round" stroke-width="2">
                            <path d="M6 18L18 6"/>
                            <path d="M18 18L6 6"/>
                        </g>
                    </svg>
                </div>

            </div>
        </div>

        <div class="flex mt-4 space-x-3 md:mt-6">
            <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-gray-900 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-gray-200" @click="toggleModal()">Modifier</a>
            <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-300">Supprimer</a>
        </div>
    </div>
</div>
</template>

<script>
export default {
  name: "BrandCard",

  props: ["brand"],

  data() {
    return {
        isModalOpen: false
    }
  },

  methods: {
    toggleModal() {
        this.isModalOpen = ! this.isModalOpen;
    }
  }
};
</script>

<style scoped>
.modal {
    width: 0;
    height: 100vh;
    overflow: hidden;
    position: absolute;
    transition: 300ms ease;
    top: 0;
    left: 0;
}

.open {
    z-index: 1000;
    background: rgba(0, 0, 0, 0.2);
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
}
</style>
<template>
  <div
    class="flex h-screen bg-gray-50"
  >
    
    <Sidebar :toggleSideMenu="toggleSideMenu"/>

    <div class="flex flex-col flex-1 w-full">
      
      <Header @toggleSideMenu="toggleSideMenu = ! toggleSideMenu"/>

      <main class="h-full overflow-y-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script>
import Header from "@/Components/Admin/Header.vue";
import Sidebar from "@/Components/Admin/Sidebar.vue";

export default {
  components: {
    Header,
    Sidebar
  },

  data() {
    return {
      toggleSideMenu: false
    }
  }
};
</script>

<style scoped>
</style>
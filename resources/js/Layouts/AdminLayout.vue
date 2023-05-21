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

<style>
.fade-right-enter-active,
.fade-right-leave-active {
  transition: transform 0.4s ease;
}

.fade-right-enter-from,
.fade-right-leave-to {
  transform: translateX(100%);
}

.fade-left-enter-active,
.fade-left-leave-active {
  transition: transform 0.4s ease;
}

.fade-left-enter-from,
.fade-left-leave-to {
  transform: translateX(-100%);
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
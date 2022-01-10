<template>
  <div class="flex flex-col h-screen">
    <NavBar />
    <div class="h-full flex flex-row flex-wrap">
      <SideBar />
      <div class="bg-gray-100 flex-1 p-6">
        <slot />
      </div>
    </div>
  </div>
</template>

<script>
import NavBar from "@layouts/Base/NavBar.vue";
import SideBar from "@layouts/Base/SideBar.vue";

export default {
  components: {
    NavBar,
    SideBar,
  },
};
</script>

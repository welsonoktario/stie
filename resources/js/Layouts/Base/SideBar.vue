<template>
  <div
    id="sideBar"
    class="md:flex md:flex-col flex-wrap bg-white border-r border-gray-300 p-6 flex-none w-72 md:top-0 md:z-30 h-full md:shadow-xl"
    :class="{ hidden: !isSidebarOpen, fixed: isSidebarOpen }"
  >
    <!-- sidebar content -->
    <div class="flex flex-col">
      <p class="uppercase text-xs text-gray-600 mb-4 tracking-wider">
        master data
      </p>

      <!-- link -->
      <a
        href="./index.html"
        class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500"
      >
        <i class="fad fa-chart-pie text-xs mr-2"></i>
        Analytics dashboard
      </a>
      <!-- end link -->

      <!-- link -->
      <a
        href="./index-1.html"
        class="mb-3 capitalize font-medium text-sm hover:text-teal-600 transition ease-in-out duration-500"
      >
        <i class="fad fa-shopping-cart text-xs mr-2"></i>
        ecommerce dashboard
      </a>
      <!-- end link -->
    </div>

    <button
      @click="isSidebarOpen = !isSidebarOpen"
      :class="{ hidden: !isSidebarOpen }"
      class="fixed top-0 left-0 z-10 w-full h-full menu-overflow"
    ></button>
    <!-- end sidebar content -->
  </div>
  <!-- end sidbar -->
</template>

<script>
import eventBus from "@/eventBus";
import { onMounted, ref } from "vue";

export default {
  setup() {
    const isSidebarOpen = ref(false);

    onMounted(() =>
      eventBus.$on(
        "sidebar-toggle",
        () => (isSidebarOpen.value = !isSidebarOpen.value)
      )
    );

    return { isSidebarOpen };
  },
};
</script>

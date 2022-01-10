<template>
  <!-- start navbar -->
  <div
    class="md:w-full md:z-20 flex flex-row justify-between items-center bg-white p-6 border-b border-gray-300"
  >
    <!-- sidebar toggle -->
    <button @click="toggleSidebar()" id="navbarToggle" class="md:hidden pr-3">
      <MenuIcon class="h-5 w-5" />
    </button>
    <!-- end sidebar toggle -->

    <!-- logo -->
    <div
      class="md:flex-none w-full md:w-64 flex flex-row justify-center items-center"
    >
      <img
        src="https://stiebulungantarakan.ac.id/wp-content/uploads/2021/05/Logo-STIE_PNG.png"
        class="w-9 md:w-12 flex-none"
      />
      <div class="flex flex-col ml-2">
        <strong class="capitalize text-sm md:text-base">sistem informasi akademi</strong>
        <p class="text-xs md:text-sm">STIE Bulungan Tarakan</p>
      </div>
    </div>
    <!-- end logo -->

    <!-- navbar content toggle -->
    <button
      @click="isNavbarContentOpen = !isNavbarContentOpen"
      id="navbarToggle"
      class="hidden md:block md:fixed right-0 mr-6"
    >
      <ChevronDownIcon class="h-5 w-5" />
    </button>
    <!-- end navbar content toggle -->

    <!-- navbar content -->
    <div
      id="navbar"
      class="md:bg-white pl-3 md:flex flex-row justify-between items-end md:flex-col md:items-end md:mr-6"
    >
      <!-- right -->
      <div class="flex items-center">
        <!-- user -->
        <div class="dropdown relative md:static">
          <button
            @click="isNavbarContentOpen = !isNavbarContentOpen"
            class="menu-btn focus:outline-none focus:shadow-outline flex items-center"
          >
            <div class="w-8 h-8 overflow-hidden rounded-full">
              <img
                class="w-full h-full object-cover"
                src="https://picsum.photos/100"
              />
            </div>

            <div class="hidden ml-2 capitalize md:flex">
              <h1
                class="text-sm text-gray-800 font-semibold m-0 p-0 leading-none"
              >
                Welson
              </h1>
            </div>
          </button>

          <button
            @click="isNavbarContentOpen = !isNavbarContentOpen"
            :class="{ hidden: !isNavbarContentOpen }"
            class="fixed top-0 left-0 z-10 w-full h-full menu-overflow"
          ></button>

          <div
            class="text-gray-500 menu md:mt-4 md:mr-6 rounded bg-white shadow-md absolute z-20 right-0 w-40 mt-5 py-2"
            :class="{ hidden: !isNavbarContentOpen }"
          >
            <h1
              class="md:hidden text-gray-800 font-semibold mb-4 p-0 text-center"
            >
              Welson
            </h1>
            <!-- item -->
            <a
              class="px-4 py-2 flex flex-row content-center capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 hover:text-gray-900 transition-all duration-300 ease-in-out"
              href="#"
            >
              <UserIcon class="w-4 h-4 my-auto mr-2" />
              <span>ubah profil</span>
            </a>
            <!-- end item -->

            <hr />

            <!-- item -->
            <Link
              class="px-4 py-2 flex flex-row content-center capitalize font-medium text-sm tracking-wide bg-white hover:bg-gray-200 hover:text-gray-900 transition-all duration-300 ease-in-out"
              href="/logout"
              method="post"
              as="button"
              type="button"
            >
              <LogoutIcon class="w-4 h-4 my-auto mr-2" />
              <span>log out</span>
            </Link>
            <!-- end item -->
          </div>
        </div>
        <!-- end user -->
      </div>
      <!-- end right -->
    </div>
    <!-- end navbar content -->
  </div>
  <!-- end navbar -->
</template>

<script>
import eventBus from "@/eventBus";
import {
  ChevronDownIcon,
  LogoutIcon,
  MenuIcon,
  UserIcon,
} from "@heroicons/vue/solid";
import { Link } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

export default {
  components: {
    ChevronDownIcon,
    LogoutIcon,
    MenuIcon,
    UserIcon,
    Link,
  },
  setup() {
    const isNavbarContentOpen = ref(false);

    const toggleSidebar = () => eventBus.$emit("sidebar-toggle");

    return { isNavbarContentOpen, toggleSidebar };
  },
};
</script>

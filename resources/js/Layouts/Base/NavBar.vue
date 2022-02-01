<template>
  <!-- start navbar -->
  <nav
    class="md:w-full md:z-20 flex flex-row justify-between items-center bg-white dark:bg-zinc-800 p-6 border-b border-zinc-300 dark:border-zinc-700 text-zinc-800 dark:text-zinc-100"
  >
    <!-- sidebar toggle -->
    <button id="navbarToggle" class="md:hidden pr-3" @click="toggleSidebar()">
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
        <strong class="capitalize text-sm md:text-base"
          >sistem informasi akademi</strong
        >
        <p class="text-xs md:text-sm">STIE Bulungan Tarakan</p>
      </div>
    </div>
    <!-- end logo -->

    <!-- navbar content toggle -->
    <button
      id="navbarToggle"
      class="hidden md:block md:fixed right-0 mr-6"
      @click="isNavbarContentOpen = !isNavbarContentOpen"
    >
      <ChevronDownIcon class="h-5 w-5" />
    </button>
    <!-- end navbar content toggle -->

    <!-- navbar content -->
    <div
      id="navbar"
      class="md:bg-white dark:md:bg-zinc-800 pl-3 md:flex flex-row justify-between items-end md:flex-col md:items-end md:mr-6"
    >
      <!-- right -->
      <div class="flex items-center">
        <!-- user -->
        <div class="dropdown relative md:static">
          <button
            class="menu-btn focus:outline-none focus:shadow-outline flex items-center"
            @click="isNavbarContentOpen = !isNavbarContentOpen"
          >
            <div class="w-8 h-8 overflow-hidden rounded-full">
              <img
                class="w-full h-full object-cover"
                src="https://picsum.photos/100"
              />
            </div>

            <div class="hidden ml-2 capitalize md:flex">
              <h1 class="text-sm font-semibold m-0 p-0 leading-none">
                {{ $page.props.auth.user.name }}
              </h1>
            </div>
          </button>

          <button
            :class="{ hidden: !isNavbarContentOpen }"
            class="fixed top-0 left-0 z-10 w-full h-full menu-overflow"
            @click="isNavbarContentOpen = !isNavbarContentOpen"
          ></button>

          <div
            class="flex flex-col text-zinc-500 menu md:mt-4 md:mr-6 rounded bg-white dark:bg-zinc-700 dark:text-zinc-100 shadow-md absolute z-20 right-0 w-40 mt-5 py-2"
            :class="{ hidden: !isNavbarContentOpen }"
          >
            <h1
              class="md:hidden dark:text-zinc-200 font-semibold mb-4 p-0 text-center"
            >
              {{ $page.props.auth.user.name }}
            </h1>
            <!-- item -->
            <Link
              class="px-4 py-2 inline-flex content-center font-medium text-sm tracking-wide bg-white dark:bg-zinc-700 hover:bg-zinc-200 dark:hover:bg-zinc-600 hover:text-zinc-800 dark:hover:text-zinc-100 transition-all duration-300 ease-in-out"
              href="#"
              as="button"
              type="button"
            >
              <UserIcon class="w-4 h-4 my-auto mr-2" />
              <span class="flex-1 text-left">Ubah Profil</span>
            </Link>
            <!-- end item -->

            <hr />

            <!-- item -->
            <Link
              class="px-4 py-2 inline-flex content-center font-medium text-sm tracking-wide bg-white dark:bg-zinc-700 hover:bg-zinc-200 dark:hover:bg-zinc-600 hover:text-zinc-800 dark:hover:text-zinc-100 transition-all duration-300 ease-in-out"
              href="/logout"
              method="post"
              as="link"
              type="link"
            >
              <LogoutIcon class="w-4 h-4 my-auto mr-2" />
              <span class="flex-1 text-left">Log Out</span>
            </Link>
            <!-- end item -->
          </div>
        </div>
        <!-- end user -->
      </div>
      <!-- end right -->
    </div>
    <!-- end navbar content -->
  </nav>
  <!-- end navbar -->
</template>

<script>
import eventBus from "@/eventBus"
import {
  ChevronDownIcon,
  LogoutIcon,
  MenuIcon,
  UserIcon,
} from "@heroicons/vue/solid"
import { Link } from "@inertiajs/inertia-vue3"
import { ref } from "vue"

export default {
  components: {
    ChevronDownIcon,
    LogoutIcon,
    MenuIcon,
    UserIcon,
    Link,
  },
  setup() {
    const isNavbarContentOpen = ref(false)

    const toggleSidebar = () => eventBus.$emit("sidebar-toggle")

    return { isNavbarContentOpen, toggleSidebar }
  },
}
</script>

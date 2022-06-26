<template>
  <!-- start navbar -->
  <nav
    class="flex flex-row items-center justify-between border-b border-zinc-300 bg-white p-6 text-zinc-800 dark:border-zinc-700 dark:bg-zinc-800 dark:text-zinc-100 md:z-20 md:w-full"
  >
    <!-- sidebar toggle -->
    <button id="navbarToggle" class="pr-3 md:hidden" @click="toggleSidebar()">
      <MenuIcon class="h-5 w-5" />
    </button>
    <!-- end sidebar toggle -->

    <!-- logo -->
    <div
      class="flex w-full flex-row items-center justify-center md:w-64 md:flex-none"
    >
      <img
        src="https://stiebulungantarakan.ac.id/wp-content/uploads/2022/03/Logo-STIE-Bulungan-Tarakan_New.png"
        class="w-9 flex-none md:w-12"
      />
      <div class="ml-2 flex flex-col">
        <strong class="text-sm capitalize md:text-sm"
          >sistem informasi akademik</strong
        >
        <p class="text-xs md:text-sm">STIE Bulungan Tarakan</p>
      </div>
    </div>
    <!-- end logo -->

    <!-- navbar content toggle -->
    <button
      id="navbarToggle"
      class="right-0 hidden md:fixed md:block"
      @click="isNavbarContentOpen = !isNavbarContentOpen"
    ></button>
    <!-- end navbar content toggle -->

    <!-- navbar content -->
    <div
      id="navbar"
      class="flex-row items-end justify-between pl-3 md:flex md:flex-col md:items-end md:bg-white dark:md:bg-zinc-800"
    >
      <!-- right -->
      <div class="flex items-center">
        <!-- user -->
        <div class="dropdown relative md:static">
          <button
            class="menu-btn focus:shadow-outline flex items-center focus:outline-none"
            @click="isNavbarContentOpen = !isNavbarContentOpen"
          >
            <div class="h-8 w-8 overflow-hidden rounded-full">
              <img
                class="h-full w-full object-cover"
                src="https://picsum.photos/100"
              />
            </div>

            <div class="ml-2 hidden capitalize md:flex">
              <h1 class="m-0 p-0 text-sm font-semibold leading-none">
                {{ $page.props.auth.user.name }}
              </h1>
            </div>
          </button>

          <div
            class="text-zinc-1000 menu absolute right-0 z-20 mt-5 flex w-40 flex-col rounded bg-white py-2 shadow-md dark:bg-zinc-700 dark:text-zinc-100 md:mt-4 md:mr-6"
            :class="{ hidden: !isNavbarContentOpen }"
          >
            <h1
              class="mb-4 p-0 text-center font-semibold dark:text-zinc-200 md:hidden"
            >
              {{ $page.props.auth.user.name }}
            </h1>
            <!-- item -->
            <Link
              class="inline-flex content-center bg-white px-4 py-2 text-sm font-medium tracking-wide transition-all duration-300 ease-in-out hover:bg-zinc-200 hover:text-zinc-800 dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:hover:text-zinc-100"
              href="#"
              as="button"
              type="button"
            >
              <UserIcon class="my-auto mr-2 h-4 w-4" />
              <span class="flex-1 text-left">Ubah Profil</span>
            </Link>
            <!-- end item -->

            <hr />

            <!-- item -->
            <Link
              class="inline-flex content-center bg-white px-4 py-2 text-sm font-medium tracking-wide transition-all duration-300 ease-in-out hover:bg-zinc-200 hover:text-zinc-800 dark:bg-zinc-700 dark:hover:bg-zinc-600 dark:hover:text-zinc-100"
              href="/logout"
              method="post"
              as="link"
              type="link"
            >
              <LogoutIcon class="my-auto mr-2 h-4 w-4" />
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
import { LogoutIcon, MenuIcon, UserIcon } from "@heroicons/vue/solid"
import { Link } from "@inertiajs/inertia-vue3"
import { ref } from "vue"

export default {
  components: {
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

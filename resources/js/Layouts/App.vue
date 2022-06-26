<template>
  <Head :title="title ? title : 'SIAKAD'" />

  <div class="flex h-screen flex-col">
    <NavBar />
    <div class="flex h-screen flex-row flex-wrap">
      <SideBar />
      <main
        class="h-full flex-1 overflow-auto bg-zinc-100 p-6 dark:bg-zinc-900 dark:text-zinc-100"
      >
        <slot />
      </main>
    </div>
  </div>
</template>

<script>
import { Head } from "@inertiajs/inertia-vue3"
import NavBar from "@layouts/Base/NavBar"
import SideBar from "@layouts/Base/SideBar"

export default {
  components: {
    Head,
    NavBar,
    SideBar,
  },
  props: {
    title: {
      type: String,
      default: "",
      required: false,
    },
  },
}
</script>

<template>
  <Head :title="title ? title : 'SIAKAD'" />

  <div class="flex flex-col h-screen">
    <NavBar />
    <div class="h-screen flex flex-row flex-wrap">
      <SideBar />
      <main
        class="bg-zinc-100 dark:bg-zinc-900 dark:text-zinc-100 flex-1 h-full p-6 overflow-auto"
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

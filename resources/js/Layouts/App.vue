<template>
  <div class="flex flex-col h-screen">
    <NavBar />
    <div class="h-screen flex flex-row flex-wrap">
      <SideBar />
      <main class="bg-zinc-100 dark:bg-zinc-900 dark:text-zinc-100 flex-1 h-full p-6 overflow-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script>
import NavBar from "@layouts/Base/NavBar.vue"
import SideBar from "@layouts/Base/SideBar.vue"

export default {
  components: {
    NavBar,
    SideBar,
  },
}
</script>

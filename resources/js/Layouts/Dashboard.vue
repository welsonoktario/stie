<template>
  <div class="flex flex-col h-screen">
    <NavBar />
    <div class="h-full flex flex-row">
      <SideBar />
      <main class="bg-zinc-100 dark:bg-zinc-900 dark:text-zinc-100 flex-1 p-6">
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

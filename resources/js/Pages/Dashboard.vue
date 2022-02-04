<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg"
    >
      <div class="p-6">You're logged in!</div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/App.vue"

export default {
  components: {
    AppLayout,
  },
}
</script>

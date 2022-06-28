<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white shadow-sm dark:bg-zinc-800 sm:rounded-lg"
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

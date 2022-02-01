<template>
  <DashboardLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg"
    >
      <div class="p-6">You're logged in!</div>
    </div>
  </DashboardLayout>
</template>

<script>
import DashboardLayout from "@layouts/Dashboard.vue"

export default {
  components: {
    DashboardLayout,
  },
}
</script>

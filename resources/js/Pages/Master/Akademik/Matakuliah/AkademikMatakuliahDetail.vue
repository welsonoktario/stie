<template>
  <AppLayout>
    {{ matakuliah }}
    <br>
    <br>
    {{ kurikulums }}
  </AppLayout>
</template>

<script setup>
import AppLayout from "@layouts/App"

defineProps({
  kurikulums: Array,
  matakuliah: Object,
})
</script>

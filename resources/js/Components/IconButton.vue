<template>
  <button
    class="inline-flex items-center px-1 pt-1 text-sm font-medium dark:text-zinc-100 hover:text-teal-600 dark:hover-teal-500 transition duration-150 ease-in-out"
    :class="classes"
  >
    <slot></slot>
  </button>
</template>

<script setup>
defineProps({
  classes: String,
})
</script>

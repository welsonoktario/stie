<template>
  <button
    class="dark:hover-teal-500 inline-flex items-center px-1 pt-1 text-sm font-medium transition duration-150 ease-in-out hover:text-teal-600 dark:text-zinc-100"
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

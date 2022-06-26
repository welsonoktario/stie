<template>
  <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300">
    <span v-if="value">{{ value }}</span>
    <span v-else><slot /></span>
  </label>
</template>

<script>
export default {
  props: ["value"],
}
</script>

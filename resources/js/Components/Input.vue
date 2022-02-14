<template>
  <input
    ref="input"
    class="dark:bg-zinc-700 border-none dark:text-zinc-200 focus:ring focus:ring-teal-600 dark:focus-ring-teal-500 rounded-md shadow-sm"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
  />
</template>

<script>
export default {
  props: ["modelValue", "error"],

  emits: ["update:modelValue"],

  methods: {
    focus() {
      this.$refs.input.focus();
    },
  },
};
</script>

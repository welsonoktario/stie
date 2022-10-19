<template>
  <input
    ref="input"
    class="rounded-md border-none bg-zinc-100 shadow-sm focus:outline-none focus:ring-teal-500 dark:bg-zinc-700 dark:text-zinc-200 dark:focus:ring-teal-600"
    :value="modelValue"
    @input="$emit('update:modelValue', $event.target.value)"
    :required="required ?? null"
  />
</template>

<script>
export default {
  props: ["modelValue", "error", "required"],

  emits: ["update:modelValue"],

  methods: {
    focus() {
      this.$refs.input.focus()
    },
  },
}
</script>

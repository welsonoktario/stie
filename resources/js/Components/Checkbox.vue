<template>
  <input
    v-model="proxyChecked"
    type="checkbox"
    :value="value"
    class="rounded border-zinc-300 text-teal-500 shadow-sm focus:border-teal-300 focus:ring focus:ring-teal-200 focus:ring-opacity-50 dark:border-zinc-600 dark:text-teal-600"
  />
</template>

<script>
export default {
  props: {
    checked: {
      type: [Array, Boolean],
      default: false,
    },
    value: {
      default: null,
    },
  },
  emits: ["update:checked"],

  computed: {
    proxyChecked: {
      get() {
        return this.checked
      },

      set(val) {
        this.$emit("update:checked", val)
      },
    },
  },
}
</script>

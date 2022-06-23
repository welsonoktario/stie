<template>
  <button
    :type="type"
    class="px-4 py-2 bg-teal-600 dark:bg-teal-500 text-center rounded-md font-semibold text-white dark:text-teal-100 hover:bg-teal-700 hover:dark:bg-teal-600 focus:outline-none transition ease-in-out duration-150 text-xs md:text-sm"
  >
    <slot />
  </button>
</template>

<script>
export default {
  props: {
    type: {
      type: String,
      default: "submit",
    },
  },
}
</script>

<template>
  <button
    :type="type"
    class="rounded-md bg-teal-600 px-4 py-2 text-center text-xs font-semibold text-white transition duration-150 ease-in-out hover:bg-teal-700 focus:outline-none dark:bg-teal-500 dark:text-teal-100 hover:dark:bg-teal-600 md:text-sm"
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

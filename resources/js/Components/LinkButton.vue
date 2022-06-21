<template>
  <Link
    :as="as"
    :href="href"
    class="inline-flex items-center px-4 py-2 bg-teal-600 dark:bg-teal-500 border border-transparent rounded-md font-semibold text-sm text-white dark:text-teal-100 hover:bg-teal-700 hover:dark:bg-teal-600 focus:outline-none transition ease-in-out duration-150"
    :preserve-state="preserveState"
    :preserve-scroll="preserveScroll"
  >
    <slot />
  </Link>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3"

defineProps({
  as: String,
  href: String,
  preserveState: Boolean,
  preserveScroll: Boolean,
})
</script>

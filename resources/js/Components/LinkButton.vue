<template>
  <Link
    :as="as"
    :href="href"
    class="md:text-sm text-center px-4 py-2 rounded-md font-semibold text-xs transition ease-in-out duration-150"
    :class="classes"
    :preserve-state="preserveState"
    :preserve-scroll="preserveScroll"
  >
    <slot />
  </Link>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3"
import { computed } from "vue";

const props = defineProps({
  as: String,
  href: String,
  class: String,
  preserveState: Boolean,
  preserveScroll: Boolean,
})

const classes = computed(() =>
  !props.class
    ? "bg-teal-600 dark:bg-teal-500 text-white dark:text-teal-100 hover:bg-teal-700 hover:dark:bg-teal-600 focus:outline-none"
    : props.class
)
</script>

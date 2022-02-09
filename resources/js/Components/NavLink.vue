<template>
  <Link :href="href" :class="classes" preserve-state>
    <slot />
  </Link>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3"
import { computed } from "vue"

const props = defineProps({
  href: String,
  active: {
    type: Boolean,
    default: false,
  },
})

const classes = computed(() =>
  props.active
    ? "inline-flex items-center px-1 pt-1 text-sm font-medium text-teal-600 dark:text-zinc-100 transition duration-150 ease-in-out"
    : "inline-flex items-center px-1 pt-1 text-sm font-medium dark:text-teal-500 dark:text-zinc-100 hover:text-teal-600 dark:hover-teal-500 transition duration-150 ease-in-out"
)
</script>

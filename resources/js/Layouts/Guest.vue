<template>
  <div
    class="flex min-h-screen flex-col items-center bg-zinc-100 pt-6 dark:bg-zinc-900 sm:justify-center sm:pt-0"
  >
    <div>
      <Link href="/">
        <BreezeApplicationLogo class="h-20 w-20 fill-current text-gray-500" />
      </Link>
    </div>

    <div
      class="mt-6 w-full overflow-hidden bg-zinc-50 px-6 py-4 shadow-md dark:bg-zinc-800 sm:max-w-md sm:rounded-lg"
    >
      <slot />
    </div>
  </div>
</template>

<script>
import BreezeApplicationLogo from "@/Components/ApplicationLogo.vue"
import { Link } from "@inertiajs/inertia-vue3"

export default {
  components: {
    BreezeApplicationLogo,
    Link,
  },
}
</script>

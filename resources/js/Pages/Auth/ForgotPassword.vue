<template>
  <Head title="Forgot Password" />

  <div class="mb-4 text-sm text-gray-600">
    Forgot your password? No problem. Just let us know your email address and we
    will email you a password reset link that will allow you to choose a new
    one.
  </div>

  <div v-if="status" class="mb-4 text-sm font-medium text-teal-600">
    {{ status }}
  </div>

  <BreezeValidationErrors class="mb-4" />

  <form @submit.prevent="submit">
    <div>
      <BreezeLabel for="email" value="Email" />
      <BreezeInput
        id="email"
        v-model="form.email"
        type="email"
        class="mt-1 block w-full"
        required
        autofocus
        autocomplete="username"
      />
    </div>

    <div class="mt-4 flex items-center justify-end">
      <BreezeButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Email Password Reset Link
      </BreezeButton>
    </div>
  </form>
</template>

<script>
import BreezeButton from "@/Components/Button.vue"
import BreezeGuestLayout from "@/Layouts/Guest.vue"
import BreezeInput from "@/Components/Input.vue"
import BreezeLabel from "@/Components/Label.vue"
import BreezeValidationErrors from "@/Components/ValidationErrors.vue"
import { Head } from "@inertiajs/inertia-vue3"

export default {
  components: {
    BreezeButton,
    BreezeInput,
    BreezeLabel,
    BreezeValidationErrors,
    Head,
  },
  layout: BreezeGuestLayout,

  props: {
    status: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        email: "",
      }),
    }
  },

  methods: {
    submit() {
      this.form.post(this.route("password.email"))
    },
  },
}
</script>

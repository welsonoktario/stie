<template>
  <Head title="Reset Password" />

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

    <div class="mt-4">
      <BreezeLabel for="password" value="Password" />
      <BreezeInput
        id="password"
        v-model="form.password"
        type="password"
        class="mt-1 block w-full"
        required
        autocomplete="new-password"
      />
    </div>

    <div class="mt-4">
      <BreezeLabel for="password_confirmation" value="Confirm Password" />
      <BreezeInput
        id="password_confirmation"
        v-model="form.password_confirmation"
        type="password"
        class="mt-1 block w-full"
        required
        autocomplete="new-password"
      />
    </div>

    <div class="mt-4 flex items-center justify-end">
      <BreezeButton
        :class="{ 'opacity-25': form.processing }"
        :disabled="form.processing"
      >
        Reset Password
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
    email: String,
    token: String,
  },

  data() {
    return {
      form: this.$inertia.form({
        token: this.token,
        email: this.email,
        password: "",
        password_confirmation: "",
      }),
    }
  },

  methods: {
    submit() {
      this.form.post(this.route("password.update"), {
        onFinish: () => this.form.reset("password", "password_confirmation"),
      })
    },
  },
}
</script>

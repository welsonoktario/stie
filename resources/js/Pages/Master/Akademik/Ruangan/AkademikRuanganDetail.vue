<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs text-slate-500 md:text-sm">
        Akademik / Ruangan /
        <span class="font-semibold text-teal-500 dark:text-teal-600">
          {{ currentRouteName }}
        </span>
      </p>

      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
          >
            <span>{{ currentRouteName }}</span>
            Ruangan
          </strong>
        </span>
      </div>
      <form @submit.prevent="submit(route().current())">
        <div class="mb-4">
          <Label for="nama_ruangan">Nama Ruangan</Label>
          <Input
            v-model="form.nama_ruangan"
            name="nama_ruangan"
            class="mt-1 block w-full"
            type="text"
            placeholder="Nama Ruangan"
            autocomplete="off"
          ></Input>
        </div>
        <div class="flex justify-between">
          <Button class="px-10">Simpan</Button>
          <button
            v-if="currentRouteName != 'Tambah'"
            type="button"
            class="bg-transparent text-red-500 hover:bg-transparent focus:bg-transparent"
            @click="isOpen = !isOpen"
          >
            Hapus Data Ruangan
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :is-open="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus ruangan"
      confirm-text="Hapus"
      @confirm="remove"
      @cancel="isOpen = !isOpen"
    >
      <template #content>
        <p class="text-sm">Apakah anda yakin ingin menghapus ruangan ini?</p>
      </template>
    </Dialog>
  </AppLayout>
</template>

<script>
import { computed, ref } from "vue"
import { Link, useForm } from "@inertiajs/inertia-vue3"
import AppLayout from "@layouts/App"
import Button from "@components/Button"
import Dialog from "@components/Dialog"
import Input from "@components/Input"
import InputError from "@components/InputError"
import Label from "@/Components/Label"

export default {
  components: {
    AppLayout,
    Button,
    Dialog,
    Input,
    InputError,
    Label,
    Link,
  },
  props: {
    ruangan: Object,
  },
  setup(props) {
    const form = useForm({
      nama_ruangan: props.ruangan?.nama_ruangan || null,
    })

    const isOpen = ref(false)

    const currentRouteName = computed(() =>
      route().current("master.ruangan.create") ? "Tambah" : "Edit"
    )

    const submit = () =>
      currentRouteName.value == "Tambah"
        ? form.post(route("master.ruangan.store"))
        : form.put(route("master.ruangan.update", props.ruangan.id))

    const remove = () =>
      form.delete(route("master.ruangan.destroy", props.ruangan.id))

    return {
      currentRouteName,
      form,
      isOpen,
      submit,
      remove,
    }
  },
}
</script>

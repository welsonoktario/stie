<template>
  <AppLayout title="Tambah Jurusan">
    <div class="rounded-lg bg-white p-6 shadow-lg dark:bg-zinc-800">
      <p class="text-xs dark:text-zinc-300 md:text-sm">
        Akademik / Prodi /
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
            Prodi/Departemen
          </strong>
        </span>
      </div>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <Label for="kode">Kode Prodi/Departemen</Label>
          <Input
            v-model="form.kode_jurusan"
            name="kode"
            class="mt-1 block w-full"
            type="text"
            placeholder="Kode Prodi/Departemen"
            autocomplete="off"
          ></Input>
        </div>
        <div class="mb-4">
          <Label for="nama">Nama Prodi/Departemen</Label>
          <Input
            v-model="form.nama"
            name="nama"
            class="mt-1 block w-full"
            type="text"
            placeholder="Nama Prodi/Departemen"
            autocomplete="off"
          ></Input>
        </div>
        <div class="flex w-full items-center justify-between">
          <Button class="px-10" :disabled="form.processing">Simpan</Button>
          <button
            v-if="currentRouteName != 'Tambah'"
            type="button"
            class="text-red-500"
            @click="isOpen = !isOpen"
          >
            Hapus Data Jurusan
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :is-open="isOpen"
      title="Hapus jurusan"
      confirm-text="Hapus"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      @confirm="remove"
      @cancel="isOpen = !isOpen"
    >
      <template #content>
        <p class="text-sm">Apakah anda yakin ingin menghapus data jurusan?</p>
      </template>
    </Dialog>
  </AppLayout>
</template>

<script>
import { computed, ref } from "vue"
import { Link, useForm } from "@inertiajs/inertia-vue3"
import AppLayout from "@layouts/App"
import Button from "@components/Button"
import Dialog from "@/Components/Dialog"
import Input from "@components/Input"
import Label from "@/Components/Label"

export default {
  components: {
    AppLayout,
    Button,
    Dialog,
    Label,
    Link,
    Input,
  },
  props: {
    jurusan: Object,
  },
  setup(props) {
    const form = useForm({
      nama: props.jurusan?.nama || null,
      kode_jurusan: props.jurusan?.kode_jurusan || null,
    })

    const currentRouteName = computed(() =>
      route().current("master.jurusan.create") ? "Tambah" : "Edit"
    )

    const isOpen = ref(false)

    const submit = () =>
      currentRouteName.value == "Tambah"
        ? form.post(route("master.jurusan.store"))
        : form.put(route("master.jurusan.update", props.jurusan.id))

    const remove = () =>
      form.delete(route("master.jurusan.destroy", props.jurusan.id))

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

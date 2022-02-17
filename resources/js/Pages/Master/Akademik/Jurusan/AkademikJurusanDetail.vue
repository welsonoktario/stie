<template>
  <AppLayout title="Tambah Jurusan">
    <div class="bg-white dark:bg-zinc-800 shadow-lg rounded-lg p-6">
      <p class="text-xs md:text-sm dark:text-zinc-300">
        Akademik / Jurusan /
        <span class="font-semibold text-teal-500 dark:text-teal-600">{{
          currentRouteName
        }}</span>
      </p>

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span>{{ currentRouteName }}</span>
            Jurusan
          </strong>
        </span>
      </div>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <Label for="kode">Kode Jurusan</Label>
          <Input
            v-model="form.kode_jurusan"
            name="kode"
            class="mt-1 block w-full"
            type="text"
            placeholder="Kode Jurusan"
            autocomplete="off"
          ></Input>
        </div>
        <div class="mb-4">
          <Label for="nama">Nama Jurusan</Label>
          <Input
            v-model="form.nama"
            name="nama"
            class="mt-1 block w-full"
            type="text"
            placeholder="Nama jurusan"
            autocomplete="off"
          ></Input>
        </div>
        <div class="flex justify-between items-center w-full">
          <Button class="px-10" :disabled="form.processing">Simpan</Button>
          <button
            v-if="currentRouteName != 'Tambah'"
            @click="isOpen = !isOpen"
            type="button"
            class="text-red-500"
            >Hapus Data Jurusan</button
          >
        </div>
      </form>
    </div>

    <Dialog
      :isOpen="isOpen"
      title="Hapus jurusan"
      confirmText="Hapus"
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

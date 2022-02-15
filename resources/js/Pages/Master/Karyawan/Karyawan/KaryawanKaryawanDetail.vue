<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm text-slate-500">
        Karyawan / Karyawan /
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
            Karyawan</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <Label for="id"> ID <em> (Nomor Induk Karyawan)</em> </Label>
          <Input
            v-model="form.id"
            name="id"
            class="mt-1 block w-full"
            type="text"
            placeholder="ID"
            autocomplete="off"
          ></Input>
        </div>
        <div class="mb-4">
          <Label for="nitk">
            NITK <i> (Tenaga Kependidikan - Opsional)</i>
          </Label>
          <Input
            v-model="form.nitk"
            id="nitk"
            class="mt-1 block w-full"
            type="text"
            placeholder="NITK (Opsional)"
            autocomplete="off"
          ></Input>
        </div>
        <div class="mb-4">
          <Label for="nama"> Nama </Label>
          <Input
            v-model="form.name"
            id="nama"
            class="mt-1 block w-full"
            type="text"
            placeholder="Nama"
            autocomplete="off"
          ></Input>
        </div>
        <div class="mb-4">
          <Label for="nik"> NIK </Label>
          <Input
            v-model="form.nik"
            name="nik"
            class="mt-1 block w-full"
            type="text"
            placeholder="NIK"
            autocomplete="off"
          ></Input>
        </div>
        <div class="mb-4">
          <Label for="email"> Email </Label>
          <Input
            v-model="form.email"
            email="email"
            class="mt-1 block w-full"
            type="email"
            placeholder="Email"
            autocomplete="off"
          ></Input>
        </div>
        <div class="flex justify-between">
          <Button class="px-10">Simpan</Button>
          <button
            type="button"
            v-if="currentRouteName != 'Tambah'"
            @click="isOpen = !isOpen"
            class="text-red-500 bg-transparent hover:bg-transparent focus:bg-transparent"
          >
            Hapus Data Karyawan
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :isOpen="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus karyawan"
      confirmText="Hapus"
      @confirm="remove"
      @cancel="isOpen = !isOpen"
    >
      <template #content>
        <p class="text-sm">Apakah anda yakin ingin menghapus karyawan ini?</p>
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
    staff: Object,
  },
  setup(props) {
    const form = useForm({
      // data user
      email: props.staff?.user?.email,
      name: props.staff?.user?.name,
      nik: props.staff?.user?.nik,

      // data staff
      id: props.staff?.id,

      // data tenaga kependidikan
      nitk: props.staff?.tenaga_kependidikan?.id
    })

    const isOpen = ref(false)

    const currentRouteName = computed(() =>
      route().current("master.karyawan.create") ? "Tambah" : "Ubah"
    )

    const submit = () =>
      currentRouteName.value == "Tambah"
        ? form.post(route("master.karyawan.store"))
        : form.put(route("master.karyawan.update", props.staff.id))

    const remove = () =>
      from.delete(route("master.karyawan.destroy", props.staff.id))

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

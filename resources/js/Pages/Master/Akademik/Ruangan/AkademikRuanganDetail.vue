<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Akademik / Ruangan /
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
            Ruangan</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit(route().current())">
        <div class="mb-4">
          <Label for="nama_ruangan"> Nama Ruangan </Label>
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
            type="button"
            v-if="currentRouteName != 'Tambah'"
            @click="isOpen = !isOpen"
            class="text-red-500 bg-transparent hover:bg-transparent focus:bg-transparent"
          >
            Hapus Data Ruangan
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :isOpen="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus ruangan"
      confirmText="Hapus"
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

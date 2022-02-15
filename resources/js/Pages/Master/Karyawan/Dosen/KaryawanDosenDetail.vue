<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Karyawan / Dosen /
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
            Dosen</strong
          >
        </span>
      </div>

      <form @submit.prevent="submit">
        <div class="mb-4">
          <Label for="id_karyawan">
            ID Karyawan <em> (Nomor Induk Karyawan)</em>
            <span class="text-red-500">*</span>
          </Label>
          <Input
            v-model="form.id_karyawan"
            class="mt-1 block w-full"
            name="id_karyawan"
            type="text"
            placeholder="ID"
          ></Input>
        </div>

        <div class="mb-4">
          <Label for="id_dosen">
            ID Dosen <span class="text-red-500">*</span>
          </Label>
          <Input
            v-model="form.id_dosen"
            class="mt-1 block w-full"
            name="ID Dosen"
            type="text"
            placeholder="id_dosen"
          ></Input>
        </div>

        <div class="mb-4">
          <label
            class="block text-gray-500 text-sm font-bold mb-2"
            for="tipe_id"
          >
            Tipe ID Dosen <span class="text-red-500">*</span>
          </label>
          <select
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            name="tipe_id"
            v-model="form.tipe_id"
          >
            <option value="NIDN">NIDN</option>
            <option value="NIDK">NIDK</option>
            <option value="NUPN">NUPN</option>
          </select>
        </div>

        <div class="mb-4">
          <Label for="jabatan_akademik">
            Jabatan Akademik <span class="text-red-500">*</span>
          </Label>
          <select
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            name="jabatan_akademik"
            v-model="form.jabatan_akademik"
          >
            <option value="Lektor">Lektor</option>
            <option value="Asisten Ahli">Asisten Ahli</option>
            <option value="Tenaga Pengajar">Tenaga Pengajar</option>
          </select>
        </div>

        <div class="mb-4">
          <Label for="nik"> NIK </Label>
          <Input
            v-model="form.nik"
            class="mt-1 block w-full"
            name="nik"
            type="text"
            placeholder="NIK"
          ></Input>
        </div>

        <div class="mb-4">
          <Label for="nama"> Nama </Label>
          <Input
            v-model="form.name"
            class="mt-1 block w-full"
            name="nama"
            type="text"
            placeholder="Nama"
          ></Input>
        </div>

        <div class="mb-4">
          <Label for="email"> Email </Label>
          <Input
            v-model="form.email"
            class="mt-1 block w-full"
            name="email"
            type="text"
            placeholder="Email"
          ></Input>
        </div>

        <div class="mb-4">
          <label
            class="block text-gray-500 text-sm font-bold mb-2"
            for="jurusan"
          >
            Jurusan / Homebase
          </label>
          <select
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            name="jurusan"
            v-model="form.jurusan"
          >
            <option value="-">-</option>
            <option
              v-for="jurusan in jurusans"
              :key="jurusan.id"
              :value="jurusan.id.toString()"
            >
              {{ jurusan.nama }} - {{ jurusan.kode_jurusan }}
            </option>
          </select>
        </div>

        <div class="mb-4">
          <Label for="konsentrasi"> Konsentrasi </Label>
          <Input
            v-model="form.konsentrasi"
            class="mt-1 block w-full"
            name="konsentrasi"
            type="text"
            placeholder="Konsentrasi"
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
            Hapus Data Dosen
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :isOpen="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus dosen"
      confirmText="Hapus"
      @confirm="remove"
      @cancel="isOpen = !isOpen"
    >
      <template #content>
        <p class="text-sm">Apakah anda yakin ingin menghapus dosen ini?</p>
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
    dosen: Object,
    jurusans: Object,
  },
  setup(props) {
    const form = useForm({
      // user data
      email: props.dosen?.staff?.user?.email || null,
      name: props.dosen?.staff?.user?.name || null,
      nik: props.dosen?.staff?.user?.nik || null,

      // karyawan data (mandatory)
      id_karyawan: props.dosen?.staff?.id || null,

      // dosen primary data (mandatory)
      id_dosen: props.dosen?.id || null,
      tipe_id: props.dosen?.tipe_id || "NIDN",
      jabatan_akademik: props.dosen?.jabatan_akademik || "Tenaga Pengajar",
      jurusan: props.dosen?.jurusan?.id || "-",
      konsentrasi: props.dosen?.konsentrasi || "-",
    })

    const isOpen = ref(false)

    const currentRouteName = computed(() =>
      route().current("master.karyawan.create") ? "Tambah" : "Ubah"
    )

    const submit = () =>
      currentRouteName == "Tambah"
        ? form.post(route("master.dose.store"))
        : form.put(route("master.dosen.update", props.dosen.id))

    const remove = () =>
      form.delete(route("master.dosen.destroy", props.dosen.id))

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

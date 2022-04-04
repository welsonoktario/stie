<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Jadwal / Mahasiswa / Daftar Mahasiswa</p>

      <div class="mb-3">
        <strong
          class="whitespace-nowrap align-middle text-sm md:text-lg content-middle"
          >Detail Jadwal Mahasiswa</strong
        >

      </div>

      <div class="flex space-x-3 mb-3">
        <div class="w-full">
          <Label for="nama"> Kode Matakuliah </Label>
          <Input
            v-model="jadwal.matakuliah.kode_matakuliah"
            name="nama"
            class="mt-1 block w-full"
            type="text"
            disabled
          ></Input>
        </div>
        <div class="w-full">
          <Label for="nama"> Matakuliah </Label>
          <Input
            v-model="jadwal.matakuliah.nama_matakuliah"
            name="nama"
            class="mt-1 block w-full"
            type="text"
            disabled
          ></Input>
        </div>
      </div>

      <div class="flex space-x-3 mb-3">
        <div class="w-full">
          <Label for="nama"> Lokal </Label>
          <Input
            v-model="jadwal.local"
            name="nama"
            class="mt-1 block w-full"
            type="text"
            disabled
          ></Input>
        </div>
        <div class="w-full">
          <Label for="nama"> Matakuliah </Label>
          <Input class="mt-1 block w-full" type="text" :value="tahunAkademik.tahun_ajaran" readonly />
        </div>
      </div>

      <div class="inline-flex justify-between my-3 w-full items-center">
        <div>
          <strong
            class="whitespace-nowrap align-middle text-sm md:text-lg content-middle"
            >Daftar Mahasiswa</strong
          >
        </div>

        <Button type="button" @click="openDialogTambah">
          Tambah Mahasiswa
        </Button>
      </div>

      <DataTable :data="mahasiswas" :columns="columns">
        <template #row(krs)="row">
          <CheckIcon class="text-teal-500 h-4" v-if="row.data.krs" />
          <XIcon class="text-red-500 h-4" v-else />
        </template>

        <template #actions="row">
          <NavLink
            as="button"
            class="text-red-500"
            @click="openDialogHapus(row.data.npm)"
          >
            <TrashIcon class="h-4" />
          </NavLink>
        </template>
      </DataTable>
    </div>

    <Dialog
      :isOpen="isDialogTambahOpen"
      title="Tambah Mahasiswa"
      confirmText="Tambah"
      classes="text-teal-900 bg-teal-100 hover:bg-teal-200 focus-visible:ring-teal-500"
      @confirm="tambah"
      @cancel="isDialogTambahOpen = !isDialogTambahOpen"
    >
      <template #content>
        <div class="my-4">
          <Select
            class="w-full"
            :placeholder="'Pilih mahasiswa'"
            :options="calonMahasiswas"
            v-model="selectedMahasiswa"
          >
            <template #option="option">
              <option :value="option.data.npm">
                {{ `${option.data.npm} - ${option.data.user.name}` }}
              </option>
            </template>
          </Select>
        </div>
      </template>
    </Dialog>

    <Dialog
      :isOpen="isDialogHapusOpen"
      title="Hapus matakuliah"
      confirmText="Hapus"
      classes="text-red-900 bg-red-100 hover:bg-red-200 focus-visible:ring-red-500"
      @confirm="remove"
      @cancel="isDialogHapusOpen = !isDialogHapusOpen"
    >
      <template #content>
        <p class="text-sm">
          Apakah anda yakin ingin menghapus mahasiswa dari jadwal ini?
        </p>
      </template>
    </Dialog>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"
import Dialog from "@components/Dialog"
import Button from "@components/Button"
import Input from "@components/Input"
import NavLink from "@/Components/NavLink"
import Select from "@components/Select"
import Label from "@/Components/Label.vue"
import { CheckIcon, XIcon, TrashIcon } from "@heroicons/vue/outline"
import { ref } from "vue"
import { Inertia } from "@inertiajs/inertia"

const props = defineProps({
  mahasiswas: Object,
  tahunAkademik: Object,
  jadwal: Object,
})

const columns = [
  {
    key: "npm",
    label: "NPM",
    sortable: true,
  },
  {
    key: "nama",
    label: "Nama",
    sortable: true,
  },
  {
    key: "jurusan",
    label: "Jurusan",
    sortable: true,
  },
  {
    key: "krs",
    label: "Bayar KRS",
  },
]

const isDialogTambahOpen = ref(false)
const isDialogHapusOpen = ref(false)
const calonMahasiswas = ref([])
const selectedMahasiswa = ref(0)
const selectedMahasiswaDelete = ref(0)

const openDialogTambah = () => {
  if (!calonMahasiswas.value.length) {
    fetch(
      route("transaksi.jadwal.mahasiswa.create", { ta: props.tahunAkademik.id })
    )
      .then((res) => res.json())
      .then((res) => {
        isDialogTambahOpen.value = !isDialogTambahOpen.value
        calonMahasiswas.value = res.data
      })
  } else {
    selectedMahasiswa.value = "-"
    isDialogTambahOpen.value = !isDialogTambahOpen.value
  }
}

const tambah = () =>
  Inertia.put(
    route("transaksi.jadwal.mahasiswa.update", props.jadwal.id),
    {
      jadwal_id: props.jadwal.id,
      mahasiswa_npm: selectedMahasiswa.value,
      ta: props.tahunAkademik.id,
    },
    {
      onSuccess: (page) =>
        (isDialogTambahOpen.value = !isDialogTambahOpen.value),
    }
  )

const openDialogHapus = (npm) => {
  selectedMahasiswaDelete.value = npm
  isDialogHapusOpen.value = !isDialogHapusOpen.value
}

const remove = () =>
  Inertia.delete(
    route("transaksi.jadwal.mahasiswa.destroy", selectedMahasiswaDelete.value),
    {
      data: {
        jadwal_id: props.jadwal.id,
        mahasiswa_npm: selectedMahasiswaDelete.value,
        ta: props.tahunAkademik.id,
      },
      preserveState: true,
      onSuccess: (page) => {
        selectedMahasiswaDelete.value = 0
        isDialogHapusOpen.value = !isDialogHapusOpen.value
      },
    }
  )
</script>

<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Jadwal / Mahasiswa / Daftar Mahasiswa</p>

      <div class="inline-flex justify-between my-3 w-full items-center">
        <strong
          class="whitespace-nowrap align-middle text-sm md:text-lg content-middle"
          >Daftar Mahasiswa</strong
        >

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

          <!-- <div class="mt-4" v-if="selectedMahasiswa.npm">
            <p>
              NPM: <span>{{ selectedMahasiswa?.npm }}</span>
            </p>
            <p>
              Nama: <span>{{ selectedMahasiswa?.user?.name }}</span>
            </p>
            <p>
              Jurusan: <span>{{ selectedMahasiswa?.jurusan?.nama }}</span>
            </p>
          </div> -->
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
import NavLink from "@/Components/NavLink"
import Select from "@components/Select"
import { CheckIcon, XIcon, TrashIcon } from "@heroicons/vue/outline"
import { ref } from "vue"
import { Inertia } from "@inertiajs/inertia"

const props = defineProps({
  mahasiswas: Object,
  ta: Number,
  jadwal: Number,
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
    fetch(route("transaksi.jadwal.mahasiswa.create", { ta: props.ta }))
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
    route("transaksi.jadwal.mahasiswa.update", props.jadwal),
    {
      jadwal_id: props.jadwal,
      mahasiswa_npm: selectedMahasiswa.value,
      ta: props.ta,
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
        jadwal_id: props.jadwal,
        mahasiswa_npm: selectedMahasiswaDelete.value,
        ta: props.ta,
      },
      preserveState: true,
      onSuccess: (page) => {
        selectedMahasiswaDelete.value = 0
        isDialogHapusOpen.value = !isDialogHapusOpen.value
      },
    }
  )
</script>

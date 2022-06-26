<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs md:text-sm">Jadwal / Mahasiswa / Daftar Mahasiswa</p>

      <div class="mb-3">
        <strong
          class="content-middle whitespace-nowrap align-middle text-sm md:text-lg"
          >Detail Jadwal Mahasiswa</strong
        >
      </div>

      <div class="mb-3 flex space-x-3">
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

      <div class="mb-3 flex space-x-3">
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
          <Input
            class="mt-1 block w-full"
            type="text"
            :value="tahunAkademik.tahun_ajaran"
            readonly
          />
        </div>
      </div>

      <div class="my-3 inline-flex w-full items-center justify-between">
        <div>
          <strong
            class="content-middle whitespace-nowrap align-middle text-sm md:text-lg"
            >Daftar Mahasiswa</strong
          >
        </div>

        <Button type="button" @click="openDialogTambah">
          Tambah Mahasiswa
        </Button>
      </div>

      <DataTable :data="mahasiswas" :columns="columns">
        <template #row(krs)="row">
          <CheckIcon v-if="row.data.krs" class="h-4 text-teal-500" />
          <XIcon v-else class="h-4 text-red-500" />
        </template>

        <template #actions="row">
          <div class="inline-flex align-middle">
            <IconButton @click.native="openDialogNilai(row.data.npm)">
              <PencilAltIcon class="h-4" />
              <p>Nilai</p>
            </IconButton>

            <IconButton
              class="text-red-500 hover:text-red-400"
              @click.native="openDialogHapus(row.data.npm)"
            >
              <TrashIcon class="h-4" />
            </IconButton>
          </div>
        </template>
      </DataTable>
    </div>

    <Dialog
      :is-open="isDialogOpen.tambah"
      title="Tambah Mahasiswa"
      confirm-text="Tambah"
      classes="text-teal-900 bg-teal-100 hover:bg-teal-200 focus-visible:ring-teal-500"
      @confirm="tambah"
      @cancel="isDialogOpen.tambah = !isDialogOpen.tambah"
    >
      <template #content>
        <div class="my-4">
          <Select
            v-model="selectedMahasiswa"
            class="w-full"
            :placeholder="'Pilih mahasiswa'"
            :options="calonMahasiswas"
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
      :is-open="isDialogOpen.hapus"
      title="Hapus Matakuliah"
      confirm-text="Hapus"
      classes="text-red-900 bg-red-100 hover:bg-red-200 focus-visible:ring-red-500"
      @confirm="remove"
      @cancel="isDialogOpen.hapus = !isDialogOpen.hapus"
    >
      <template #content>
        <p class="text-sm">
          Apakah anda yakin ingin menghapus mahasiswa dari jadwal ini?
        </p>
      </template>
    </Dialog>

    <Dialog
      :is-open="isDialogOpen.nilai"
      title="Edit Nilai"
      confirm-text="Edit"
      classes="text-teal-900 bg-teal-100 hover:bg-teal-200 focus-visible:ring-teal-500"
      @confirm="editNilai"
      @cancel="isDialogOpen.nilai = !isDialogOpen.nilai"
    >
      <template #content>
        <div class="my-4">
          <Label>Nilai Akhir</Label>
          <Input
            v-model="nilai"
            class="w-full"
            type="number"
            min="0"
            max="100"
          />
        </div>
        <div class="my-4 inline-flex justify-between">
          <div class="mr-2">
            <Label>Huruf Mutu</Label>
            <Input
              v-model="nisbi"
              class="w-full cursor-not-allowed"
              type="text"
              readonly
            />
          </div>
          <div class="ml-2">
            <Label>Angka Mutu</Label>
            <Input
              v-model="angkaMutu"
              class="w-full cursor-not-allowed"
              type="text"
              readonly
            />
          </div>
        </div>
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
import Select from "@components/Select"
import Label from "@/Components/Label.vue"
import IconButton from "@/Components/IconButton"
import {
  CheckIcon,
  PencilAltIcon,
  TrashIcon,
  XIcon,
} from "@heroicons/vue/outline"
import { reactive, ref, watch } from "vue"
import { Inertia } from "@inertiajs/inertia"
import { inRange } from "@/util"

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
  {
    key: "nilai_akhir",
    label: "NA",
  },
  {
    key: "nisbi",
    label: "Nisbi",
  },
]

const isDialogOpen = reactive({
  tambah: false,
  hapus: false,
  nilai: false,
})
const calonMahasiswas = ref([])
const selectedMahasiswa = ref(0)
const selectedMahasiswaDelete = ref(0)
const nilai = ref(0)
const nisbi = ref("")
const angkaMutu = ref(0)

watch(
  () => nilai.value,
  async (newNilai, oldNilai) => {
    if (inRange(newNilai, 80, 100)) {
      nisbi.value = "A"
      angkaMutu.value = 4
    } else if (inRange(newNilai, 70, 79)) {
      nisbi.value = "B"
      angkaMutu.value = 3
    } else if (inRange(newNilai, 56, 69)) {
      nisbi.value = "C"
      angkaMutu.value = 2
    } else if (inRange(newNilai, 40, 55)) {
      nisbi.value = "D"
      angkaMutu.value = 1
    } else {
      nisbi.value = "E"
      angkaMutu.value = 0
    }
  }
)

const loadNilai = async (npm) => {
  const res = await fetch(
    route("transaksi.jadwal.mahasiswa.loadNilai", {
      jadwal: props.jadwal,
      mahasiswa: npm,
    })
  )
  const data = await res.json()

  if (data) {
    nilai.value = Number(data.pivot.nilai_akhir)
    nisbi.value = data.pivot.nisbi
    angkaMutu.value = data.pivot.anga_mutu
  } else {
    nilai.value = 0
    nisbi.value = ""
    angkaMutu.value = null
  }
}

const openDialogTambah = () => {
  if (!calonMahasiswas.value.length) {
    fetch(
      route("transaksi.jadwal.mahasiswa.create", { ta: props.tahunAkademik.id })
    )
      .then((res) => res.json())
      .then((res) => {
        isDialogOpen.tambah = !isDialogOpen.tambah
        calonMahasiswas.value = res.data
      })
  } else {
    selectedMahasiswa.value = "-"
    isDialogOpen.tambah = !isDialogOpen.tambah
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
      onSuccess: () => (isDialogOpen.tambah = !isDialogOpen.tambah),
    }
  )

const openDialogHapus = (npm) => {
  selectedMahasiswaDelete.value = npm
  isDialogOpen.hapus = !isDialogOpen.hapus
}

const openDialogNilai = async (npm) => {
  await loadNilai(npm)
  selectedMahasiswa.value = npm
  isDialogOpen.nilai = !isDialogOpen.nilai
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
        isDialogOpen.hapus = !isDialogOpen.hapus
      },
    }
  )

const editNilai = () => {
  Inertia.patch(
    route("transaksi.jadwal.mahasiswa.editNilai", {
      jadwal: props.jadwal,
      mahasiswa: selectedMahasiswa.value,
    }),
    {
      nilaiAkhir: nilai.value,
      nisbi: nisbi.value,
      angkaMutu: angkaMutu.value,
      ta: props.tahunAkademik.id,
    },
    {
      preserveState: true,
      onSuccess: () => {
        selectedMahasiswa.value = 0
        isDialogOpen.nilai = !isDialogOpen.nilai
      },
    }
  )
}
</script>

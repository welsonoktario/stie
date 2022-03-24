<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Nilai / Detail Nilai</p>

      <p class="my-3 text-sm md:text-lg font-bold">Detail Nilai</p>

      <div>
        <p>
          NPM: <span>{{ mahasiswa.npm }}</span>
        </p>

        <p>
          Nama: <span>{{ mahasiswa.user.name }}</span>
        </p>

        <p>
          Jurusan: <span>{{ mahasiswa.jurusan?.nama ?? "-" }}</span>
        </p>
      </div>

      <div class="inline-flex justify-between mb-3 mt-6 w-full items-center">
        <div class="inline-flex">
          <p
            class="whitespace-nowrap align-middle text-sm md:text-lg content-middle font-bold my-auto"
          >
            Detail Nilai
          </p>
          <Select
            class="ml-2 text-sm"
            :placeholder="'Pilih tahun akademik'"
            :options="tahunAkademiks"
            v-model="selectedTA"
          >
            <template #option="option">
              <option :value="option.data.id">
                {{ option.data.tahun_ajaran }}
              </option>
            </template>
          </Select>
          <Select
            class="ml-2 text-sm"
            :options="['UTS', 'UAS']"
            v-model="selectedTipeSemester"
          >
            <template #option="option">
              <option :value="option.data">
                {{ option.data }}
              </option>
            </template>
          </Select>
        </div>

        <Button type="button">
          <Link
            :href="
              route('transaksi.nilai.create', { ta: selectedTahunAkademik })
            "
          >
            Tambah Nilai
          </Link>
        </Button>
      </div>

      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="font-semibold text-left py-2 px-4">Kode MK</th>
            <th class="font-semibold text-left py-2 px-4">Matakuliah</th>
            <th class="font-semibold text-left py-2 px-4">SKS</th>
            <th class="font-semibold text-left py-2 px-4">Nilai</th>
            <th class="font-semibold text-left py-2 px-4">NISBI</th>
            <th class="font-semibold text-left py-2 px-4"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="jadwal in mahasiswa.jadwals"
            class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal"
          >
            <td class="px-4 py-2">{{ jadwal.matakuliah.kode_matakuliah }}</td>
            <td class="px-4 py-2">{{ jadwal.matakuliah.nama_matakuliah }}</td>
            <td class="px-4 py-2">{{ jadwal.matakuliah.sks }}</td>
            <td class="px-4 py-2">{{ nilaiMK(jadwal) }}</td>
            <td class="px-4 py-2">{{ nilaiNisbi(jadwal) }}</td>
            <td class="px-4 py-2">
              <PencilIcon
                @click="openDialogNilai(jadwal)"
                class="h-4 cursor-pointer"
              />
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <Dialog
      :isOpen="isDialogNilaiOpen"
      title="Edit Nilai"
      confirmText="Edit"
      classes="text-teal-900 bg-teal-100 hover:bg-teal-200 focus-visible:ring-teal-500"
      @confirm="edit"
      @cancel="isDialogNilaiOpen = !isDialogNilaiOpen"
    >
      <template #content>
        <div class="my-4">
          <Label>Nilai</Label>
          <Input
            class="w-full"
            type="number"
            min="0"
            max="100"
            v-model="nilai"
          />
        </div>
        <div class="my-4 inline-flex justify-between">
          <div class="mr-2">
            <Label>Huruf Mutu</Label>
            <Input
              class="w-full cursor-not-allowed"
              type="text"
              v-model="nisbi"
              readonly
            />
          </div>
          <div class="ml-2">
            <Label>Angka Mutu</Label>
            <Input
              class="w-full cursor-not-allowed"
              type="text"
              v-model="angkaMutu"
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
import Button from "@/Components/Button"
import Dialog from "@/Components/Dialog"
import Input from "@/Components/Input"
import Label from "@/Components/Label"
import Select from "@/Components/Select"
import { Link } from "@inertiajs/inertia-vue3"
import { PencilIcon } from "@heroicons/vue/outline"
import { ref, toRef, watch } from "vue"
import { inRange } from "@/util"
import { Inertia } from "@inertiajs/inertia"

const props = defineProps({
  tahunAkademiks: Array,
  selectedTahunAkademik: Number | String,
  mahasiswa: Object,
})

const selectedTA = ref(props.selectedTahunAkademik)
const selectedTipeSemester = ref("UTS")
const selectedJadwal = ref(0)
const isDialogNilaiOpen = ref(false)
const nilai = ref(0)
const nisbi = ref("")
const angkaMutu = ref(0)

watch(selectedTA, async (newTA, oldTA) => {
  Inertia.visit(
    route("transaksi.nilai.edit", {
      ta: newTA,
      mahasiswa: props.mahasiswa.npm,
    }),
    {
      preserveScroll: true,
      preserveState: true,
    }
  )
})

watch(nilai, async (newNilai, oldNilai) => {
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
})

const nilaiMK = (jadwal) =>
  selectedTipeSemester.value == "UTS"
    ? jadwal.pivot.nilai_uts ?? "-"
    : jadwal.pivot.nilai_nas ?? "-"

const nilaiNisbi = (jadwal) => {
  let huruf = ""

  if (selectedTipeSemester.value == "UTS") {
    if (!jadwal.pivot.nilai_uts) return "-"

    if (inRange(jadwal.pivot.nilai_uts, 80, 100)) {
      huruf = "A"
    } else if (inRange(jadwal.pivot.nilai_uts, 70, 79)) {
      huruf = "B"
    } else if (inRange(jadwal.pivot.nilai_uts, 56, 69)) {
      huruf = "C"
    } else if (inRange(jadwal.pivot.nilai_uts, 40, 55)) {
      huruf = "D"
    } else {
      huruf = "E"
    }
  } else {
    if (!jadwal.pivot.nilai_nas) return "-"

    if (inRange(jadwal.pivot.nilai_nas, 80, 100)) {
      huruf = "A"
    } else if (inRange(jadwal.pivot.nilai_nas, 70, 79)) {
      huruf = "B"
    } else if (inRange(jadwal.pivot.nilai_nas, 56, 69)) {
      huruf = "C"
    } else if (inRange(jadwal.pivot.nilai_nas, 40, 55)) {
      huruf = "D"
    } else {
      huruf = "E"
    }
  }

  return huruf
}

const edit = () =>
  Inertia.put(
    route("transaksi.nilai.update", props.mahasiswa.npm),
    {
      jadwal_id: selectedJadwal.value,
      nilai: nilai.value,
      tipe: selectedTipeSemester.value,
      ta: props.selectedTahunAkademik,
    },
    {
      onSuccess: (page) => (isDialogNilaiOpen.value = !isDialogNilaiOpen.value),
    }
  )

const openDialogNilai = (jadwal) => {
  selectedJadwal.value = jadwal.id
  nilai.value = 0
  nisbi.value = ""
  angkaMutu.value = 0

  if (selectedTipeSemester.value == "UTS") {
    nilai.value = jadwal.pivot.nilai_uts ?? 0
  } else {
    nilai.value = jadwal.pivot.nilai_nas ?? 0
  }

  isDialogNilaiOpen.value = !isDialogNilaiOpen.value
}
</script>

<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Nilai / Detail Nilai</p>

      <div class="inline-flex my-3 text-sm md:text-lg align-middle">
        <ChevronLeftIcon @click="back" class="w-5 cursor-pointer" />
        <p class="font-bold capitalize nowrap ml-2">Detail Nilai</p>
      </div>

      <table>
        <tr>
          <td>NPM:</td>
          <td class="pl-2">{{ mahasiswa.npm }}</td>
        </tr>
        <tr>
          <td>Nama:</td>
          <td class="pl-2">{{ mahasiswa.user.name }}</td>
        </tr>
        <tr>
          <td>Jurusan:</td>
          <td class="pl-2">{{ mahasiswa.jurusan?.nama ?? "-" }}</td>
        </tr>
        <tr>
          <td>IP:</td>
          <td class="pl-2">{{ ip == "NaN" ? "-" : ip }}</td>
        </tr>
      </table>

      <div class="inline-flex justify-between mb-3 mt-6 w-full items-center">
        <div class="inline-flex">
          <p
            class="whitespace-nowrap align-middle text-sm md:text-lg content-middle font-bold my-auto"
          >
            Detail Nilai
          </p>
          <select
            class="ml-2 text-sm pl-3 py-2 pr-8 bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            v-model="selectedTA"
          >
            <option v-for="ta in tahunAkademiks" :value="ta.id">
              {{ ta.tahun_ajaran }}
            </option>
          </select>
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
            <th
              v-if="selectedTA == 'semua'"
              class="font-semibold text-left py-2 px-4"
            >
              Tahun Akademik
            </th>
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
            :key="jadwal.id"
            class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal"
          >
            <td v-if="selectedTA == 'semua'" class="px-4 py-2">
              {{ namaTA(jadwal) }}
            </td>
            <td class="px-4 py-2">{{ jadwal.matakuliah.kode_matakuliah }}</td>
            <td class="px-4 py-2">{{ jadwal.matakuliah.nama_matakuliah }}</td>
            <td class="px-4 py-2">{{ jadwal.matakuliah.sks }}</td>
            <td class="px-4 py-2">{{ jadwal.pivot.nilai_akhir | 0 ?? "-" }}</td>
            <td class="px-4 py-2">{{ nilaiHuruf(jadwal) }}</td>
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
          <Label>Nilai Akhir</Label>
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
import { ChevronLeftIcon, PencilIcon } from "@heroicons/vue/outline"
import { onMounted, ref, watch } from "vue"
import { inRange } from "@/util"
import { Inertia } from "@inertiajs/inertia"

const props = defineProps({
  tahunAkademiks: Array,
  selectedTahunAkademik: {
    type: Number,
    default: 0,
  },
  mahasiswa: Object,
})

const selectedTA = ref(props.selectedTahunAkademik)
const selectedJadwal = ref(0)
const isDialogNilaiOpen = ref(false)
const nilai = ref(0)
const nisbi = ref("")
const angkaMutu = ref(0)
const ip = ref(0)

watch([selectedTA, () => nilai.value], async ([newTA, newNilai]) => {
  if (newTA == "-") return

  if (!isDialogNilaiOpen.value) {
    Inertia.visit(
      route("transaksi.nilai.edit", {
        ta: newTA,
        mahasiswa: props.mahasiswa.npm,
      }),
      {
        preserveScroll: true,
      }
    )
  }

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

  calcIp()
})

onMounted(() => calcIp())

const back = () => window.history.back()

const calcIp = () => {
  const jadwals = props.mahasiswa.jadwals
  const nilaiAm = jadwals.map(
    (jadwal) =>
      cekAngkaMutu(Number(jadwal.pivot.nilai_akhir)) * jadwal.matakuliah.sks
  )

  const totalSks = jadwals.reduce((prev, curr) => {
    return prev + curr.matakuliah.sks
  }, 0)

  const totalNilai = nilaiAm.reduce((prev, curr) => {
    return prev + curr
  }, 0)

  // ip.value = Math.round((totalNilai / totalSks) * 100) / 100
  ip.value = (totalNilai / totalSks).toFixed(2)
}

const cekAngkaMutu = (num) => {
  let am = 0

  if (inRange(num, 80, 100)) {
    am = 4
  } else if (inRange(num, 70, 79)) {
    am = 3
  } else if (inRange(num, 56, 69)) {
    am = 2
  } else if (inRange(num, 40, 55)) {
    am = 1
  } else {
    am = 0
  }

  return am
}

const cekHurufMutu = (num) => {
  let hm = ""

  if (inRange(num, 80, 100)) {
    hm = "A"
  } else if (inRange(num, 70, 79)) {
    hm = "B"
  } else if (inRange(num, 56, 69)) {
    hm = "C"
  } else if (inRange(num, 40, 55)) {
    hm = "D"
  } else {
    hm = "E"
  }

  return hm
}

const nilaiHuruf = (jadwal) => {
  if (!jadwal.pivot.nilai_akhir) return "-"

  return cekHurufMutu(jadwal.pivot.nilai_akhir)
}

const edit = () =>
  Inertia.put(
    route("transaksi.nilai.update", props.mahasiswa.npm),
    {
      jadwal_id: selectedJadwal.value,
      nilai: nilai.value,
      ta: props.selectedTahunAkademik,
    },
    {
      onSuccess: (page) => (isDialogNilaiOpen.value = !isDialogNilaiOpen.value),
    }
  )

const namaTA = (jadwal) =>
  props.tahunAkademiks.find((ta) => ta.id == jadwal.tahun_ajaran_id)
    .tahun_ajaran

const openDialogNilai = (jadwal) => {
  selectedJadwal.value = jadwal.id
  nilai.value = jadwal.pivot.nilai_akhir | 0
  nisbi.value = ""
  angkaMutu.value = 0

  isDialogNilaiOpen.value = !isDialogNilaiOpen.value
}
</script>

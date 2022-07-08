<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs md:text-sm">Nilai / Detail Nilai</p>

      <p class="my-3 text-sm font-bold md:text-lg">Detail Nilai</p>

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
        <tr v-if="ips != ''">
          <td>IPS:</td>
          <!-- <td class="pl-2">{{ ip == "NaN" ? "-" : ip }}</td> -->
          <td class="pl-2">{{ ips }}</td>
        </tr>
        <tr>
          <td>IPK:</td>
          <!-- <td class="pl-2">{{ ip == "NaN" ? "-" : ip }}</td> -->
          <td class="pl-2">{{ ipk }}</td>
        </tr>
      </table>

      <div class="flex space-x-2 mt-3">
        <Button
          class=""
          @click="cetakTranskrip"
          >
          Cetak Transkrip
        </Button>
      </div>

      <div class="mb-3 mt-3 inline-flex w-full items-center justify-between">
        <div class="inline-flex">
          <p
            class="content-middle my-auto whitespace-nowrap align-middle text-sm font-bold md:text-lg"
          >
            Detail Nilai
          </p>
          <select
            v-model="selectedTA"
            class="ml-2 rounded-md border-none bg-zinc-100 py-2 pl-3 pr-8 text-sm focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
          >
            <option v-for="ta in tahunAkademiks" :value="ta.id">
              {{ ta.tahun_ajaran }}
            </option>
          </select>
        </div>
      </div>

      <table class="w-full table-auto">
        <thead>
          <tr>
            <th
              v-if="selectedTA == 'semua'"
              class="py-2 px-4 text-left font-semibold"
            >
              Tahun Akademik
            </th>
            <th class="py-2 px-4 text-left font-semibold">Kode MK</th>
            <th class="py-2 px-4 text-left font-semibold">Matakuliah</th>
            <th v-if="selectedTA == 0" class="py-2 px-4 text-left font-semibold">Semester</th>
            <th class="py-2 px-4 text-left font-semibold">SKS</th>
            <th class="py-2 px-4 text-left font-semibold">Nilai</th>
            <th class="py-2 px-4 text-left font-semibold">NISBI</th>
            <th class="py-2 px-4 text-left font-semibold"></th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="jadwal in mahasiswa.jadwals"
            :key="jadwal.id"
            class="border-y text-sm font-normal dark:border-zinc-600 dark:text-zinc-200"
          >
            <td v-if="selectedTA == 'semua'" class="px-4 py-2">
              {{ namaTA(jadwal) }}
            </td>
            <td class="px-4 py-2">{{ jadwal.matakuliah.kode_matakuliah }}</td>
            <td class="px-4 py-2">{{ jadwal.matakuliah.nama_matakuliah }}</td>
            <td v-if="selectedTA == 0" class="px-4 py-2">{{ jadwal.tahun_ajaran.tahun_ajaran }}</td>
            <td class="px-4 py-2">{{ jadwal.matakuliah.sks }}</td>
            <td class="px-4 py-2">{{ jadwal.pivot.nilai_akhir | 0 ?? "-" }}</td>
            <td class="px-4 py-2">{{ nilaiHuruf(jadwal) }}</td>
            <td class="px-4 py-2">
              <PencilIcon
                class="h-4 cursor-pointer"
                @click="openDialogNilai(jadwal)"
              />
            </td>
          </tr>
        </tbody>
      </table>


      <div v-if="(mahasiswa.mahasiswa_konversi != null) && (selectedTA == 0)">
        <p  class="my-3 text-sm font-bold md:text-lg">Detail Nilai Konversi</p>


        <table class="w-full table-auto">
          <thead>
            <tr>
              <th
                v-if="selectedTA == 'semua'"
                class="py-2 px-4 text-left font-semibold"
              >
                Tahun Akademik
              </th>
              <th class="py-2 px-4 text-left font-semibold">Kode MK</th>
              <th class="py-2 px-4 text-left font-semibold">Matakuliah</th>
              <th v-if="selectedTA == 0" class="py-2 px-4 text-left font-semibold">Semester</th>
              <th class="py-2 px-4 text-left font-semibold">SKS (S)</th>
              <th class="py-2 px-4 text-left font-semibold">Bobot (B)</th>
              <th class="py-2 px-4 text-left font-semibold">(B) x (S)</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="mkk in mahasiswa.mahasiswa_konversi.matakuliah_konversis"
              :key="mkk.id"
              class="border-y text-sm font-normal dark:border-zinc-600 dark:text-zinc-200"
            >
              <!-- <td>wow</td> -->
              <td class="px-4 py-2">{{ mkk.matakuliah.kode_matakuliah }}</td>
              <td class="px-4 py-2">{{ mkk.matakuliah.nama_matakuliah }}</td>

              <td>-</td>
              <td class="px-4 py-2">{{ mkk.matakuliah.sks }}</td>
              <td class="px-4 py-2">{{ mkk.nilai_matakuliah | 0 ?? "-" }}</td>
              <td class="px-4 py-2">{{ mkk.nilai_matakuliah * mkk.matakuliah.sks }}</td>
            </tr>
          </tbody>
        </table>

      </div>

    </div>

    <Dialog
      :is-open="isDialogNilaiOpen"
      title="Edit Nilai"
      confirm-text="Edit"
      classes="text-teal-900 bg-teal-100 hover:bg-teal-200 focus-visible:ring-teal-500"
      @confirm="edit"
      @cancel="isDialogNilaiOpen = !isDialogNilaiOpen"
    >
      <template #content>
        <div class="my-4">
          <Label>Nilai Akhir</Label>
          <Input
            v-model="nilai"

            @focus="isDialogNilaiOpen"
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
import Button from "@/Components/Button"
import Dialog from "@/Components/Dialog"
import Input from "@/Components/Input"
import Label from "@/Components/Label"
import Select from "@/Components/Select"
import { Link } from "@inertiajs/inertia-vue3"
import LinkButton from "@components/LinkButton"
import { PencilIcon } from "@heroicons/vue/outline"
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
  ips: String,
  ipk: String,
  isKonversi: Boolean,
})

const selectedTA = ref(props.selectedTahunAkademik)
const selectedJadwal = ref(0)
const isDialogNilaiOpen = ref(false)
const nilai = ref()
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

const calcIp = () => {
  const jadwals = props.mahasiswa.jadwals

  // setiap angka mutu jadwal * sks mk
  const nilaiAm = jadwals.map(
    (jadwal) =>
      cekAngkaMutu(Number(jadwal.pivot.nilai_akhir)) * jadwal.matakuliah.sks
  )

  // itung total sks yang diambil
  const totalSks = jadwals.reduce((prev, curr) => prev + curr.matakuliah.sks, 0)

  // total nilai
  const totalNilai = nilaiAm.reduce((prev, curr) => prev + curr, 0)

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
      nisbi: nisbi.value,
      angka_mutu: angkaMutu.value,
      ta: props.selectedTahunAkademik,
    },
    {
      onSuccess: (page) => {
        isDialogNilaiOpen.value = !isDialogNilaiOpen.value
        calcIp()
      },
    }
  )

const namaTA = (jadwal) =>
  props.tahunAkademiks.find((ta) => ta.id == jadwal.tahun_ajaran_id)
    .tahun_ajaran

const cetakTranskrip = () => {
  const r = route("transaksi.transkrip", {mahasiswa: props.mahasiswa.npm})
  console.log(r);
  Inertia.visit(r);
}

const openDialogNilai = (jadwal) => {
  selectedJadwal.value = jadwal.id
  nilai.value = jadwal.pivot.nilai_akhir | 0
  nisbi.value = ""
  angkaMutu.value = 0

  isDialogNilaiOpen.value = !isDialogNilaiOpen.value
}
</script>

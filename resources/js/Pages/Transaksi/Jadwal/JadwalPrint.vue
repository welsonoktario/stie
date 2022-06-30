<template>
  <div class="page grid grid-cols-2 justify-items-end font-serif">
    <h1 class="w-full font-bold italic underline underline-offset-4">
      STIE BULUNGAN <br />
      TARAKAN
    </h1>

    <div class="rounded-md border border-black p-4 text-xs">
      <table>
        <tbody>
          <tr>
            <td>Thn.Akademik</td>
            <td class="pl-1 pr-2">:</td>
            <td>{{ jadwal.tahun_ajaran.tahun_ajaran }}</td>
          </tr>
          <tr>
            <td>Semester</td>
            <td class="pl-1 pr-2">:</td>
            <td>{{ periode }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <h1 class="col-span-2 mt-12 w-full text-center text-xl font-bold uppercase">
      {{ header }}
    </h1>

    <table class="col-span-2 mx-auto mt-8 font-mono text-xs">
      <tbody>
        <tr>
          <td class="text-right">Mata Kuliah / SKS/Kode/Kelas</td>
          <td class="pl-2 pr-4">:</td>
          <td>{{ mk }}</td>
        </tr>
        <tr>
          <td class="text-right">Dosen</td>
          <td class="pl-2 pr-4">:</td>
          <td class="uppercase">{{ dosen }}</td>
        </tr>
        <tr>
          <td class="text-right">Program Studi / Jenjang</td>
          <td class="pl-2 pr-4">:</td>
          <td class="uppercase">
            {{ prodi }}
          </td>
        </tr>
        <tr>
          <td class="text-right">Tanggal/Hari/Jam/Ruangan</td>
          <td class="pl-2 pr-4">:</td>
          <td>{{ tanggal }}</td>
        </tr>
        <tr>
          <td class="text-right">Jumlah Peserta</td>
          <td class="pl-2 pr-4">:</td>
          <td>{{ jadwal.mahasiswas.length }} Orang</td>
        </tr>
      </tbody>
    </table>

    <table
      class="col-span-2 mx-auto mt-8 w-full table-auto border-collapse border border-black font-mono text-xs"
    >
      <thead>
        <tr>
          <th class="border border-black" rowspan="2">No.</th>
          <th class="border border-black" rowspan="2">N I M</th>
          <th class="border border-black" rowspan="2">N A M A</th>
          <th
            v-if="!tipe.includes('N')"
            class="whitespace-pre-line border border-black"
            rowspan="2"
          >
            Tanda Tangan
          </th>
          <th colspan="3" class="border border-black">Nilai Akhir</th>
        </tr>
        <tr>
          <th class="border border-black">ANGKA</th>
          <th class="border border-black">BOBOT</th>
          <th class="border border-black">HURUF</th>
        </tr>
      </thead>
      <tbody>
        <template v-if="!tipe.includes('N')">
          <tr v-for="(mhs, index) in jadwal.mahasiswas" :key="index">
            <td class="border border-black pr-1 text-right">{{ index + 1 }}</td>
            <td class="border border-black pl-1">
              {{ nim(mhs.npm) }}
            </td>
            <td class="border border-black pl-1 uppercase">
              {{ mhs.user.name }}
            </td>
            <td class="border border-black text-center"></td>
            <td class="border border-black text-center"></td>
            <td class="border border-black text-center"></td>
            <td class="border border-black text-center"></td>
          </tr>
        </template>
        <template v-else>
          <tr v-for="(mhs, index) in jadwal.mahasiswas" :key="index">
            <td class="border border-black pr-1 text-right">{{ index + 1 }}</td>
            <td class="border border-black pl-1">
              {{ nim(mhs.npm) }}
            </td>
            <td class="border border-black pl-1 uppercase">
              {{ mhs.user.name }}
            </td>
            <td class="border border-black text-center">
              {{ Number(mhs.jadwals[0].pivot.nilai_akhir) }}
            </td>
            <td class="border border-black text-center">
              {{ Number(mhs.jadwals[0].pivot.angka_mutu).toFixed(2) }}
            </td>
            <td class="border border-black text-center">
              {{ mhs.jadwals[0].pivot.nisbi }}
            </td>
          </tr>
        </template>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { computed } from "vue"
import { onMounted } from "vue"

const props = defineProps({
  jadwal: Object,
  tipe: String,
})

onMounted(() => {
  document.title = pdfName.value
  // window.print()
})

const periode = computed(() =>
  props.jadwal.tahun_ajaran.periode == 1 ? "Ganjil" : "Genap"
)

const header = computed(() => {
  if (props.tipe === "A-UTS") {
    return `Daftar Hadir Ujian Tengah Semester`
  } else if (props.tipe === "A-UAS") {
    return `Daftar Hadir Ujian Akhir Semester`
  } else if (props.tipe === "N-UTS") {
    return `Daftar Nilai Ujian Tengah Semester`
  } else {
    return `Daftar Nilai Ujian Akhir Semester`
  }
})

const pdfName = computed(
  () => `${header.value}_${props.jadwal.matakuliah.nama}`
)

const mk = computed(() => {
  const matakuliah = props.jadwal.matakuliah
  if (props.tipe.includes("UTS")) {
    return `${matakuliah.nama_matakuliah} / ${matakuliah.sks}/${matakuliah.kode_matakuliah}/${props.jadwal.local}`
  } else {
    return `${matakuliah.nama_matakuliah} / ${matakuliah.sks}/${matakuliah.kode_matakuliah}/${props.jadwal.local}`
  }
})

const dosen = computed(() =>
  props.jadwal.dosens
    .reduce((prev, next) => (prev += `${next.staff.user.name}, `), "")
    .slice(0, -2)
)

const prodi = computed(
  () => `${props.jadwal.matakuliah.matakuliah_jurusan.jurusan.nama} / S-1`
)

const tanggal = computed(() => {
  const jadwal = props.jadwal
  const dateUts = new Date(jadwal.uts_tanggal)
  const hariUts = dateUts.toLocaleDateString("id-ID", { weekday: "long" })
  const dateUas = new Date(jadwal.uas_tanggal)
  const hariUas = dateUas.toLocaleDateString("id-ID", { weekday: "long" })

  if (props.tipe.includes("UTS")) {
    return `${jadwal.uts_tanggal}/${hariUts}/${jadwal.uts_pukul_mulai} - ${jadwal.uts_pukul_selesai}/${props.jadwal.ruangan_uts.nama_ruangan}`
  } else {
    return `${jadwal.uas_tanggal}/${hariUas}/${jadwal.uas_pukul_mulai} - ${jadwal.uas_pukul_selesai}/${props.jadwal.ruangan_uas.nama_ruangan}`
  }
})

const nim = (npm) => {
  const splitted = npm.split(".")

  return `${splitted[0]}${splitted[2]}${splitted[3]}`
}
</script>

<style>
@import "../../../../css/sheets-of-paper.css";

.page {
  /* Styles for better appearance on screens only -- are reset to defaults in print styles later */

  /* Reflect the paper width in the screen rendering (must match size from @page rule) */
  width: 21cm;
  /* Reflect the paper height in the screen rendering (must match size from @page rule) */
  min-height: 29.7cm;

  /* Reflect the actual page margin/padding on paper in the screen rendering (must match margin from @page rule) */
  padding-left: 1cm;
  padding-top: 1cm;
  padding-right: 1cm;
  padding-bottom: 1cm;
}
/* Use CSS Paged Media to switch from continuous documents to sheet-like documents with separate pages */
@page {
  /* You can only change the size, margins, orphans, widows and page breaks here */

  /* Paper size and page orientation */
  size: A4 portrait;

  /* Margin per single side of the page */
  margin-left: 1cm;
  margin-top: 1cm;
  margin-right: 1cm;
  margin-bottom: 1cm;
}
</style>

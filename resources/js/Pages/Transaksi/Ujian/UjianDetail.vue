<template>
  <div class="grid grid-cols-2 justify-items-end font-serif">
    <h1 class="underline italic underline-offset-4 font-bold w-full">
      STIE BULUNGAN <br />
      TARAKAN
    </h1>

    <div class="border border-black rounded-md p-4 text-xs">
      <table class="table-auto">
        <tbody>
          <tr>
            <td>Thn.Akademik</td>
            <td class="pl-1 pr-2">:</td>
            <td>{{ ta.tahun_ajaran }}</td>
          </tr>
          <tr>
            <td>Semester</td>
            <td class="pl-1 pr-2">:</td>
            <td>{{ periode }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <h1
      class="mt-12 w-full text-center underline underline-offset-4 font-bold text-xl uppercase col-span-2"
    >
      {{ header }}
    </h1>

    <table class="table-auto mx-auto mt-8 col-span-2 font-mono">
      <tbody>
        <tr>
          <td>NPM</td>
          <td class="pl-2 pr-4">:</td>
          <td>{{ mahasiswa.npm }}</td>
        </tr>
        <tr>
          <td>Nama Mahasiswa</td>
          <td class="pl-2 pr-4">:</td>
          <td class="uppercase">{{ mahasiswa.user.name }}</td>
        </tr>
        <tr>
          <td>Tempat/Tgl.Lahir</td>
          <td class="pl-2 pr-4">:</td>
          <td class="uppercase">{{ ttl }}</td>
        </tr>
        <tr>
          <td>Program Studi/Jenjang</td>
          <td class="pl-2 pr-4">:</td>
          <td>{{ jenjang }}</td>
        </tr>
      </tbody>
    </table>

    <table
      class="table-auto border-collapse border border-black w-full mx-auto mt-8 col-span-2 font-mono"
    >
      <thead>
        <tr>
          <th class="border border-black">No.</th>
          <th class="border border-black">Kode</th>
          <th class="border border-black">Mata Kuliah</th>
          <th class="border border-black">SKS</th>
          <th class="border border-black">KLS</th>
          <th class="border border-black">Hari</th>
          <th class="border border-black">Tanggal</th>
          <th class="border border-black">Jam</th>
          <th class="border border-black">Ruang<br />/Kelas</th>
          <th class="border border-black">Paraf<br />Pengawas</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(jadwal, index) in mahasiswa.jadwals" :key="index">
          <td class="border border-black text-right pr-1">{{ index + 1 }}</td>
          <td class="border border-black pl-1">
            {{ jadwal.matakuliah.kode_matakuliah }}
          </td>
          <td class="border border-black uppercase pl-1">
            {{ jadwal.matakuliah.nama_matakuliah }}
          </td>
          <td class="border border-black text-center">
            {{ jadwal.matakuliah.sks }}
          </td>
          <td class="border border-black text-center">&#45;</td>
          <td class="border border-black text-center">{{ jadwal.hari }}</td>
          <td class="border border-black text-center">
            {{ jadwal.created_at.split("T")[0] }}
          </td>
          <td class="border border-black text-center">{{ jadwal.jam }}</td>
          <td class="border border-black text-center">
            {{ jadwal.ruangan.nama_ruangan }}
          </td>
          <td class="border border-black"><br /></td>
        </tr>
      </tbody>
    </table>

    <div class="col-start-2 mt-4 mr-8">
      <p>Tarakan, {{ tanggal }}</p>
      <p>Wakil Ketua I,</p>
      <br />
      <br />
      <br />
      <p class="uppercase">Welson</p>
    </div>
  </div>
</template>

<script setup>
import { computed } from "@vue/reactivity"
import { onMounted } from "vue"

const props = defineProps({
  ta: Object,
  tipe: String,
  mahasiswa: Object,
})

onMounted(() => {
  document.title = pdfName.value
  window.print()
})

const pdfName = computed(
  () =>
    `${props.tipe}-${props.mahasiswa.user.nama_panggilan}_${props.mahasiswa.npm}`
)

const header = computed(() =>
  props.tipe == "UTS"
    ? "Kartu Ujian Tengah Semester"
    : "Kartu Ujian Akhir Semester"
)

const periode = computed(() => (props.ta.periode == 1 ? "Ganjil" : "Genap"))

const ttl = computed(
  () =>
    `${props.mahasiswa.user.tempat_lahir}, ${props.mahasiswa.user.tanggal_lahir}`
)

const jenjang = computed(() => {
  const smt = props.mahasiswa.status_mahasiswa.length

  return `${props.mahasiswa.jurusan?.nama ?? "-"} / ${smt}-${props.ta.periode}`
})

const tanggal = computed(() => {
  const now = new Date()
  const options = { year: "numeric", month: "long", day: "numeric" }

  return now.toLocaleDateString("id-ID", options)
})
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
  padding-left: 2cm;
  padding-top: 2cm;
  padding-right: 2cm;
  padding-bottom: 2cm;
}
/* Use CSS Paged Media to switch from continuous documents to sheet-like documents with separate pages */
@page {
  /* You can only change the size, margins, orphans, widows and page breaks here */

  /* Paper size and page orientation */
  size: A4 portrait;

  /* Margin per single side of the page */
  margin-left: 2cm;
  margin-top: 2cm;
  margin-right: 2cm;
  margin-bottom: 2cm;
}
</style>

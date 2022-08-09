<template>
  <div class="A4 grid grid-cols-2 justify-items-end font-serif">
    <h1 class="w-full font-bold italic underline underline-offset-4">
      STIE BULUNGAN <br />
      TARAKAN
    </h1>

    <div class="rounded-md border border-black p-4 text-xs">
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
      class="col-span-2 mt-12 w-full text-center text-xl font-bold uppercase underline underline-offset-4"
    >
      {{ header }}
    </h1>

    <!-- <table class="table-auto mx-auto mt-8 col-span-2 font-mono">
      <tbody>
        <tr>
          <td class="text-right">NPM</td>
          <td class="pl-2 pr-4">:</td>
          <td>{{ mahasiswa.npm }}</td>
        </tr>
        <tr>
          <td class="text-right">Nama Mahasiswa</td>
          <td class="pl-2 pr-4">:</td>
          <td class="uppercase">{{ mahasiswa.user.name }}</td>
        </tr>
        <tr>
          <td class="text-right">Tempat/Tgl.Lahir</td>
          <td class="pl-2 pr-4">:</td>
          <td class="uppercase">{{ ttl }}</td>
        </tr>
        <tr>
          <td class="text-right">Program Studi/Jenjang</td>
          <td class="pl-2 pr-4">:</td>
          <td>{{ jenjang }}</td>
        </tr>
      </tbody>
    </table> -->

    <div
      class="col-span-2 mx-auto mt-8 grid grid-flow-row grid-cols-12 gap-0 text-sm"
    >
      <div class="col-span-6 mt-auto text-right">NPM</div>
      <div class="pl-2 pr-4">:</div>
      <div class="col-span-5">{{ mahasiswa.npm }}</div>

      <div class="col-span-6 text-right">Nama Mahasiswa</div>
      <div class="pl-2 pr-4">:</div>
      <div class="col-span-5 uppercase">{{ mahasiswa.user.name }}</div>

      <div class="col-span-6 text-right">Tempat/Tgl.Lahir</div>
      <div class="pl-2 pr-4">:</div>
      <div class="col-span-5 uppercase">{{ ttl }}</div>

      <div class="col-span-6 text-right">Program Studi/Jenjang</div>
      <div class="pl-2 pr-4">:</div>
      <div class="col-span-5">{{ jenjang }}</div>
    </div>

    <table
      class="col-span-2 mx-auto mt-8 w-full table-auto border-collapse border border-black font-mono text-xs"
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
          <td class="border border-black pr-1 text-right">{{ index + 1 }}</td>
          <td class="border border-black pl-1">
            {{ jadwal.matakuliah.kode_matakuliah }}
          </td>
          <td class="border border-black pl-1 uppercase">
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

    <div class="col-start-2 mt-4 mr-8 text-sm">
      <div>Tarakan, {{ tanggal }}</div>
      <div>Wakil Ketua I,</div>
      <br />
      <br />
      <br />
      <br />
      <p class="uppercase">
        {{ wakil_ketua_1.staff.gelar_depan }}
        {{ wakil_ketua_1.staff.user.name }}
        {{ wakil_ketua_1.staff.gelar_belakang }}
      </p>
    </div>
  </div>
</template>

<script setup>
import { computed } from "vue"
import { onMounted } from "vue"

const props = defineProps({
  ta: Object,
  tipe: String,
  mahasiswa: Object,
  wakil_ketua_1: Object,
})

onMounted(() => {
  document.title = pdfName.value
  // window.print()
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
@import "../../../../css/paper.css";
</style>

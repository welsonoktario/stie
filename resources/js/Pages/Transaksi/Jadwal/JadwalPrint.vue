<template>
  <div
    :class="tipe === 'H' ? 'landscape' : null"
    class="A4 sheet padding-10mm justify-items-end font-serif"
  >
    <div class="grid grid-cols-2">
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

    <template v-if="tipe === 'H'">
      <component :is="TableAbsensiHarian" :jadwal="jadwal" />
    </template>

    <!-- <table
      class="relative col-span-2 mx-auto mt-8 w-full table-auto border-collapse border border-black font-mono text-xs"
    >
      <thead>
        <tr>
          <th class="border border-black" :rowspan="tipe === 'H' ? 3 : 2">
            No.
          </th>
          <th class="border border-black" :rowspan="tipe === 'H' ? 3 : 2">
            N I M
          </th>
          <th class="border border-black" :rowspan="tipe === 'H' ? 3 : 2">
            N A M A
          </th>
          <th
            v-if="tipe.includes('A')"
            class="whitespace-pre-line border border-black"
            rowspan="2"
          >
            Tanda Tangan
          </th>
          <th v-if="tipe.includes('N')" colspan="3" class="border border-black">
            Nilai Akhir
          </th>
          <th v-if="tipe === 'H'" colspan="14">Pertemuan ke-</th>
        </tr>
        <tr v-if="tipe !== 'H'">
          <th class="border border-black">ANGKA</th>
          <th class="border border-black">BOBOT</th>
          <th class="border border-black">HURUF</th>
        </tr>
        <tr v-if="tipe === 'H'">
          <th
            v-for="pertemuan in 14"
            :key="pertemuan"
            class="border border-black"
          >
            {{ pertemuan }}
          </th>
        </tr>
        <tr v-if="tipe === 'H'">
          <th
            v-for="pertemuan in 14"
            :key="pertemuan"
            class="h-8 border border-black"
          ></th>
        </tr>
      </thead>
      <tbody>
        <template v-if="tipe.includes('A')">
          <tr class="tbl" v-for="(mhs, index) in jadwal.mahasiswas" :key="index">
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
        <template v-else-if="tipe.includes('N')">
          <tr class="tbl" v-for="(mhs, index) in jadwal.mahasiswas" :key="index">
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
        <template v-else>
          <tr class="tbl" v-for="(mhs, index) in jadwal.mahasiswas" :key="index">
            <td class="border border-black pr-1 text-right">{{ index + 1 }}</td>
            <td class="border border-black pl-1">
              {{ nim(mhs.npm) }}
            </td>
            <td class="border border-black pl-1 uppercase">
              {{ mhs.user.name }}
            </td>
            <td
              v-for="pertemuan in 14"
              :key="`pertemuan-${pertemuan}`"
              class="w-10 border border-black"
            ></td>
          </tr>
        </template>
      </tbody>
    </table> -->
  </div>
</template>

<script setup>
import TableAbsensiHarian from "@/Components/Jadwal/TableAbsensiHarian"
import { computed, onMounted } from "vue"

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
  } else if (props.tipe === "N-UAS") {
    return `Daftar Nilai Ujian Akhir Semester`
  } else {
    return "Daftar Hadir Harian"
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
</script>

<style scoped>
@import "../../../../css/paper.css";

@media print {
  @page {
    padding-bottom: 16px !important;
  }
}
</style>

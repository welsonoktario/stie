<template>
  <div
    :class="{ landscape: tipe === 'H' }"
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
          <td>{{ tanggal() }}</td>
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
    <template v-if="tipe.includes('A-')">
      <component :is="TableAbsensiUjian" :jadwal="jadwal" />
    </template>
    <template v-if="tipe.includes('N-')">
      <component :is="TableNilaiUjian" :jadwal="jadwal" />
    </template>
  </div>
</template>

<script setup>
import TableAbsensiHarian from "@/Components/Jadwal/TableAbsensiHarian"
import TableAbsensiUjian from "@/Components/Jadwal/TableAbsensiUjian"
import TableNilaiUjian from "@/Components/Jadwal/TableNilaiUjian"
import { computed, onMounted } from "vue"

const props = defineProps({
  jadwal: Object,
  tipe: String,
})

onMounted(() => {
  document.title = pdfName.value
  // window.print()
  console.log(props.tipe.includes("N"))
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

const tanggal = () => {
  const jadwal = props.jadwal
  const dateUts = new Date(jadwal.uts_tanggal)
  const hariUts = dateUts.toLocaleDateString("id-ID", { weekday: "long" })
  const dateUas = new Date(jadwal.uas_tanggal)
  const hariUas = dateUas.toLocaleDateString("id-ID", { weekday: "long" })

  if (props.tipe.includes("UTS")) {
    if (!props.jadwal.ruangan_uts) return "-"
    return `${jadwal.uts_tanggal}/${hariUts}/${jadwal.uts_pukul_mulai} - ${jadwal.uts_pukul_selesai}/${props.jadwal.ruangan_uts.nama_ruangan}`
  } else if (props.tipe.includes("UAS")) {
    if (!props.jadwal.ruangan_uas) return "-"
    return `${jadwal.uas_tanggal}/${hariUas}/${jadwal.uas_pukul_mulai} - ${jadwal.uas_pukul_selesai}/${props.jadwal.ruangan_uas.nama_ruangan}`
  } else if (props.tipe == "H") {
    return `${props.jadwal.hari}/${props.jadwal.jam}/${props.jadwal.ruangan.nama_ruangan}`
  }
}
</script>

<style scoped>
@import "../../../../css/paper.css";
</style>

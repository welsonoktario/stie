<template>
  <div
    :class="{ landscape: tipe === 'H' }"
    class="font-serif A4 sheet padding-10mm justify-items-end"
  >
    <div class="grid grid-cols-2">
      <h1 class="w-full italic font-bold underline underline-offset-4">
        STIE BULUNGAN <br />
        TARAKAN
      </h1>

      <div class="p-4 text-xs border border-black rounded-md">
        <table>
          <tbody>
            <tr>
              <td>Thn.Akademik</td>
              <td class="pl-1 pr-2">:</td>
              <td>{{ jadwal.tahun_ajaran.tahun_ajaran.split(" ")[0] }}</td>
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

    <h1 class="w-full col-span-2 mt-12 text-xl font-bold text-center uppercase">
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
        <tr>

        </tr>
      </tbody>
    </table>

    <!-- TABEL NAMA MAHASISWA -->
    <template v-if="tipe === 'H'">
      <component class="" :is="TableAbsensiHarian" :jadwal="jadwal" />
    </template>
    <template v-if="tipe.includes('A-')">
      <component :is="TableAbsensiUjian" :jadwal="jadwal" />
    </template>
    <template v-if="tipe.includes('N-')">
      <component :is="TableNilaiUjian" :jadwal="jadwal" />
    </template>


    <!-- TANDA TANGAN SESUAI DENGAN JENIS DOKUMEN-->
    <div class="w-full mt-10 break-inside-avoid">
      <div class="text-xs font-mono grid gap-x-9 grid-cols-3 text-mono">
        <div v-if="tipe === 'H'" class="">
          <br/>
          <p class="mb-24">Ketua Departemen {{departemen}},</p>
          <p class="h-4 border-b-2 border-black">{{namaKepalaDepartemen}}</p>
          <p>NIDN: {{idKepalaDepartemen}}</p>
        </div>
        <div v-if="tipe === 'H'" class="">
          <br/>
          <p class="mb-24">Ketua Kelas,</p>
          <p class="h-4 border-b-2 border-black"></p>
          <p>NPM: </p>
        </div>
        <div class="col-end-4">
          <p>Tarakan,.............................</p>
          <p class="mb-24">Dosen Penanggung Jawab/Tim,</p>
          <p class="h-4 border-b-2 border-black"></p>
        </div>
      </div>
    </div>
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
  kepalaDepartemen: String,
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
    .reduce((prev, next) => (prev += `${next.staff.gelar_depan?? ""} ${next.staff.user.name} ${next.staff.gelar_belakang?? ""}; `), "")
    .slice(0, -2)
)

const namaKepalaDepartemen = computed(() => {

  const gelarDepan = props.kepalaDepartemen?.gelar_depan ?? ""
  const gelarBelakang = props.kepalaDepartemen?.gelar_belakang ?? ""
  const namaLengkap = props.kepalaDepartemen?.user.name ?? "";

  return [gelarDepan, namaLengkap, gelarBelakang].join(" ")
})

const idKepalaDepartemen = computed (
  () => props.kepalaDepartemen?.dosen?.id ?? props.kepalaDepartemen?.id
)

const prodi = computed(
  () => `${props.jadwal.matakuliah.matakuliah_jurusan.jurusan.nama} / S-1`
)

const departemen = computed(
  () => props.jadwal.matakuliah.matakuliah_jurusan.jurusan.nama
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

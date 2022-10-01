<template>
<div class="font-mono ml-3 mr-3 text-xs">


  <div class="flex items-center p-3 border-double border-slate-800 border-b-4 mb-3">
    <div class="p-2">
      <img
        src="https://stiebulungantarakan.ac.id/wp-content/uploads/2022/03/Logo-STIE-Bulungan-Tarakan_New.png"
        class="w-20"
      />
    </div>
    <div class="p-2 w-full">
      <span class="h-full w-full inline-block align-middle text-center">
        <p class="font-semibold text-xl">SEKOLAH TINGGI ILMU EKONOMI BULUNGAN TARAKAN</p>
        <p class="" >Jl. Gunung Amal No. 01 Tarakan, Kalimantan Timur 77123</p>
        <p class="" >Telp. +6255125996, +6255125997 Fax. +6255124004</p>
        <p class="" >Website: www.stiebulungantarakan.ac.id Email: info@stiebulungantarakan.ac.id</p>
      </span>
    </div>
  </div>
  <!-- <div id='logo' class="grid grid-cols-2">

    <div class="flex items-center p-3">
      <div class="p-2">
        <img
          src="https://stiebulungantarakan.ac.id/wp-content/uploads/2022/03/Logo-STIE-Bulungan-Tarakan_New.png"
          class="w-20"
        />
      </div>
      <div class="p-2">
        <span class="h-full inline-block align-middle text-left">
          <span class="font-semibold">STIE BULUNGAN TARAKAN</span> <br/>
          <span class="" >Jl. Gunung Amal RT. 14, Kampung Enam, Tarakan, Kalimantan Timur 77123</span>
        </span>
      </div>
    </div>
  </div> -->
  <div class="grid grid-cols-4 mb-5">
    <div class="col-span-4 text-center w-full font-bold text-lg underline underline-offset-2">
      TRANSKRIP
    </div>

    <!-- NPM -->
    <div class="col-start-2">
      NPM
    </div>
    <div class="class col-span-2">
      : {{mahasiswa.npm}}
    </div>

    <!-- Nama -->
    <div class="col-start-2">
      Nama
    </div>
    <div class="class col-span-2">
      : {{mahasiswa.user.name}}
    </div>


    <!-- Program Studi -->
    <div class="col-start-2">
      Tempat, Tanggal Lahir
    </div>
    <div class="class col-span-2">
      : {{mahasiswa.user.tempat_lahir}}, {{tanggal_lahir}}
    </div>

    <!-- Program Studi -->
    <div class="col-start-2">
      Program Studi/Jenjang
    </div>
    <div class="class col-span-2">
      : {{mahasiswa.jurusan.nama}}/S1
    </div>
  </div>

<!--
  <div class="header grid grid-cols-4 mb-5">
    <div class="col-span-4 w-full font-bold text-s">
      Lanjutan keterangan transkrip untuk mahasiswa.
    </div>

    <div class="col-start-2">
      NPM
    </div>
    <div class="class col-span-2">
      : {{mahasiswa.npm}}
    </div>

    <div class="col-start-2">
      Nama
    </div>
    <div class="class col-span-2">
      : {{mahasiswa.user.name}}
    </div>
  </div> -->

  <table class="w-full border-slate-900">
    <thead>
      <tr class="border border-dashed border-slate-900">
        <th class="px-2">Kode</th>
        <th class="px-2">Nama Matakuliah</th>
        <th class="px-2">Semester</th>
        <th class="px-2">SKS</th>
        <th class="px-2">NH</th>
        <th class="px-2">Bobot</th>
        <th class="px-2">SKS x Bobot</th>
      </tr>
    </thead>

    <tbody class="w-full">
      <tr v-if="matakuliah_konversis.length > 0">
        <td class="px-2 border border-dashed border-slate-900 text-zinc-500" colspan="7">
        Matakuliah Konversi
        </td>
      </tr>
      <tr class="w-full border-x border-slate-900 border-dashed" v-if="matakuliah_konversis.length > 0" v-for="(matakuliah_konversi, index) in matakuliah_konversis[0].matakuliah_konversis" :key="index">
        <td class="px-2 text-center">
          {{matakuliah_konversi.matakuliah.kode_matakuliah}}
        </td>
        <td class="px-2">
          {{matakuliah_konversi.matakuliah.nama_matakuliah}}
        </td>
        <td class="px-2">
          <!-- {{matakuliah_konversi.matakuliah}} --> -
        </td>
        <td class="px-2 ">
          {{matakuliah_konversi.matakuliah.sks}}
        </td>
        <td class="px-2">
          <!-- {{matakuliah_konversi.nilai}} - --> NH
        </td>
        <td class="px-2 ">
          {{matakuliah_konversi.nilai_matakuliah}}
        </td>
        <td class="px-2 ">
          {{matakuliah_konversi.matakuliah.sks * matakuliah_konversi.nilai_matakuliah}}
        </td>
      </tr>

      <tr class="w-full border border-slate-900 border-dashed" v-if="matakuliah_konversis.length > 0">
        <td colspan="3" class="px-2 text-end">Total :</td>
        <td colspan="" class="px-2 text-start">{{total_sks_konversi}}</td>
        <td></td>
        <td></td>
        <td colspan="" class="px-2 text-start">{{total_nilai_kali_sks_konversi}}</td>
      </tr>

      <tr>
        <td class="px-2 border border-dashed border-slate-900 text-zinc-500" colspan="7">
        Matakuliah Reguler
        </td>
      </tr>
      <tr class="w-full border-x border-slate-900 border-dashed" v-for="(jadwal, index) in jadwals" :key="index">
        <td class="px-2 text-center">{{index}}</td>
        <td class="px-2">
          <!-- <tr v-for="(mk) in jadwal"> -->
          {{jadwal[0].matakuliah.nama_matakuliah}}
        </td>
        <td class="px-2">
          <tr v-for="(mk) in jadwal">
          <td>{{mk.tahun_ajaran.tahun_ajaran}}</td></tr>
        </td>
        <td class="px-2 text-center">
          <tr v-for="(mk) in jadwal">
          <td class="text-center">{{mk.matakuliah.sks}}</td></tr>
        </td>
        <td class="px-2">
          <tr v-for="(mk) in jadwal">
          <td class="text-center">{{mk.pivot.nisbi ? mk.pivot.nisbi : "-"}}</td></tr>
        </td>
        <td class="px-2">
          <tr v-for="(mk) in jadwal">
          <td class="text-center">{{mk.pivot.angka_mutu ? mk.pivot.angka_mutu : "-"}}</td></tr>
        </td>
        <td class="px-2">
          <tr v-for="(mk) in jadwal">
          <td class="text-center">{{mk.matakuliah.sks * mk.pivot.angka_mutu}}</td></tr>
        </td>
      </tr>

      <tr class="w-full border border-slate-900 border-dashed">
        <td colspan="3" class="px-2 text-end">Total :</td>
        <td colspan="" class="px-2 text-start">{{total_sks}}</td>
        <td></td>
        <td></td>
        <td colspan="" class="px-2 text-start">{{total_nilai_kali_sks}}</td>
      </tr>

      <tr class="w-full">
        <td colspan="2" class="px-2 text-start">SKS Nilai E : {{total_sks_tidak_lulus}}</td>
        <td colspan="2" class="px-2 text-end">Indeks Prestasi Kumulatif :</td>
        <td colspan="" class="px-2 text-start">{{+(Math.round(ipk + "e+3") + "e-3") }}</td>
      </tr>
    </tbody>
  </table> <br><br>
  <div class="w-full px-2 flex">
    <div class="w-full">
      Ekivalen Nilai <br>
      A: Sangat Baik <br>
      B: Baik <br>
      C: Cukup <br>
      D: Kurang <br>
      E: Sangat Kurang <br>
    </div>
    <div class="w-full">
      Tarakan, {{tanggal}} <br>
      Wakil Ketua I
      <br><br>
      <br><br>
      <p class="uppercase">
        {{ wakil_ketua_1.staff.gelar_depan }}
        {{ wakil_ketua_1.staff.user.name }}
        {{ wakil_ketua_1.staff.gelar_belakang }}
      </p>
      <p class="uppercase">
        {{ wakil_ketua_1.staff.dosen.tipe_id }}:
        {{ wakil_ketua_1.staff.dosen.id }}
      </p>
    </div>
  </div>

</div>


</template>

<style>
</style>

<script setup>
import { computed } from "vue"

const props= defineProps({
  mahasiswa: Object,
  matakuliah_konversis: Object,
  jadwals: Object,
  total_nilai_kali_sks_konversi: Number,
  total_sks_konversi: Number,
  ipk_konversi: Number,
  total_nilai_kali_sks: Number,
  total_sks: Number,
  total_sks_tidak_lulus: Number,
  ipk: Number,
  wakil_ketua_1: String,
});

const tanggal_lahir = computed(() => {
  try {
    const tgl = new Date(props.mahasiswa.user.tanggal_lahir)
    const tgl_formated = `${tgl.getDate()}-${tgl.getMonth()}-${tgl.getFullYear()}`

    return tgl_formated
  }
  catch (e) {
    return ""
  }
})

const tanggal = computed(() => {
  const now = new Date()
  const options = { year: "numeric", month: "long", day: "numeric" }

  return now.toLocaleDateString("id-ID", options)
})



</script>

<style>
#logo {
  /* display: none; */
}

@media print {
    /* td {font-family:georgia, times, serif;} */
    /* h1 {page-break-after: always;} */
    #logo {
      /* display:inline-block; */
    }

    .header {

    position: absolute;
    top: 0;
      /* display: table-header-group; */
    }
}

@page {
  margin: 20px 20px;
}

</style>

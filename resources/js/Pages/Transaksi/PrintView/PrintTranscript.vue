<template>
<div class="font-mono ml-3 mr-3 text-xs">

  <div class="mt-5 grid grid-cols-4 mb-5">
    <div class="col-span-4 text-center w-full font-bold text-s">
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


    <!-- Nama -->
    <div class="col-start-2">
      Program Studi/Jenjang
    </div>
    <div class="class col-span-2">
      : {{mahasiswa.jurusan.nama}}/S1
    </div>
  </div>
  <!-- <div v-if="matakuliah_konversis">
    <table class="w-full">
      <thead>
        <tr>
          <th>Kode</th>
          <th>Nama Matakuliah</th>
          <th>Semester</th>
          <th>SKS</th>
          <th>NH</th>
          <th>Bobot</th>
          <th>SKS x Bobot</th>
        </tr>
      </thead>
      <tbody>

      </tbody>
    </table>
  </div> -->
  <!-- <h1>Wow</h1> -->
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
        <td class="px-2">
          {{matakuliah_konversi.matakuliah.kode_matakuliah}}
        </td>
        <td class="px-2">
          {{matakuliah_konversi.matakuliah.nama_matakuliah}}
        </td>
        <td class="px-2">
          <!-- {{matakuliah_konversi.matakuliah}} --> -
        </td>
        <td class="px-2">
          {{matakuliah_konversi.matakuliah.sks}}
        </td>
        <td class="px-2">
          <!-- {{matakuliah_konversi.nilai}} - --> NH
        </td>
        <td class="px-2">
          {{matakuliah_konversi.nilai_matakuliah}}
        </td>
        <td class="px-2">
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
        <td class="px-2">{{index}}</td>
        <td class="px-2">
          <!-- <tr v-for="(mk) in jadwal"> -->
          {{jadwal[0].matakuliah.nama_matakuliah}}
        </td>
        <td class="px-2">
          <tr v-for="(mk) in jadwal">
          <td>{{mk.tahun_ajaran.tahun_ajaran}}</td></tr>
        </td>
        <td class="px-2">
          <tr v-for="(mk) in jadwal">
          <td>{{mk.matakuliah.sks}}</td></tr>
        </td>
        <td class="px-2">
          <tr v-for="(mk) in jadwal">
          <td>{{mk.pivot.nisbi ? mk.pivot.nisbi : "-"}}</td></tr>
        </td>
        <td class="px-2">
          <tr v-for="(mk) in jadwal">
          <td>{{mk.pivot.angka_mutu ? mk.pivot.angka_mutu : "-"}}</td></tr>
        </td>
        <td class="px-2">
          <tr v-for="(mk) in jadwal">
          <td>{{mk.matakuliah.sks * mk.pivot.angka_mutu}}</td></tr>
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
        <td colspan="3" class="px-2 text-end">Indeks Prestasi Kumulatif :</td>
        <td colspan="" class="px-2 text-start">{{ipk}}</td>
      </tr>
    </tbody>
  </table>


</div>


</template>

<style>
</style>

<script setup>

const props= defineProps({
  mahasiswa: Object,
  matakuliah_konversis: Object,
  jadwals: Object,
  total_nilai_kali_sks_konversi: Number,
  total_sks_konversi: Number,
  ipk_konversi: Number,
  total_nilai_kali_sks: Number,
  total_sks: Number,
  ipk: Number,
});



</script>

<style>

@media print {
    /* td {font-family:georgia, times, serif;} */
    /* h1 {page-break-after: always;} */
}

@page {
  margin: 20px 20px;
}

</style>

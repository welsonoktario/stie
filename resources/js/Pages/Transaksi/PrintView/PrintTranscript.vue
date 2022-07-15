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
      Jenjang = Departemen
    </div>
    <div class="class col-span-2">
      : S1 - {{mahasiswa.jurusan.nama}}
    </div>
  </div>

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

    <tbody class="w-full">
      <tr class="w-full" v-for="(jadwal, index) in jadwals" :key="index">
        <td>{{index}}</td>
        <td>
          <!-- <tr v-for="(mk) in jadwal"> -->
          {{jadwal[0].matakuliah.nama_matakuliah}}
        </td>
        <td>
          <tr v-for="(mk) in jadwal">
          <td>{{mk.tahun_ajaran.tahun_ajaran}}</td></tr>
        </td>
        <td>
          <tr v-for="(mk) in jadwal">
          <td>{{mk.matakuliah.sks}}</td></tr>
        </td>
        <td>
          <tr v-for="(mk) in jadwal">
          <td>{{mk.pivot.nisbi ? mk.pivot.nisbi : "-"}}</td></tr>
        </td>
        <td>
          <tr v-for="(mk) in jadwal">
          <td>{{mk.pivot.angka_mutu ? mk.pivot.angka_mutu : "-"}}</td></tr>
        </td>
        <td>
          <tr v-for="(mk) in jadwal">
          <td>{{mk.matakuliah.sks * mk.pivot.angka_mutu}}</td></tr>
        </td>
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

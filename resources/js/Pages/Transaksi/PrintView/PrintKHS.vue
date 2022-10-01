<template>
<div class="font-mono ml-3 mr-3 text-xs">

  <!-- <div id='logo' class="grid grid-cols-2">

    <div class="flex items-center p-3">
      <div class="p-2">
        <img
          src="https://stiebulungantarakan.ac.id/wp-content/uploads/2022/03/Logo-STIE-Bulungan-Tarakan_New.png"
          class="w-20"
        />
      </div>
    </div>

    <div class="flex items-center p-3">
      <div class="p-2">
        <span class="h-full inline-block align-middle text-left">
          <span class="font-semibold">STIE BULUNGAN TARAKAN</span> <br/>
          <span class="" >Jl. Gunung Amal RT. 1s4, Kampung Enam, Tarakan, Kalimantan Timur 77123</span>
        </span>
      </div>
    </div>
  </div> -->


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
  <div class="grid grid-cols-4 mb-5">
    <div class="col-span-4 text-center w-full font-bold text-lg underline underline-offset-2">
      KARTU HASIL STUDI
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

    <!-- Program Studi -->
    <div class="col-start-2">
      Tahun Akademik
    </div>
    <div class="class col-span-2">
      : {{ta.tahun_ajaran}}
    </div>
  </div>


  <table class="w-full border-slate-900 table-auto">
    <thead>
      <tr class="border border-dashed border-slate-900">
        <th class="px-2 w-2">No.</th>
        <th class="px-2">Kode</th>
        <th class="px-2">Nama Matakuliah</th>
        <th class="px-2">SKS</th>
        <th class="px-2">NH</th>
        <th class="px-2">Bobot</th>
        <th class="px-2">SKS x Bobot</th>
      </tr>
    </thead>

    <tbody class="w-full">
      <tr class="w-full border-x border-slate-900 border-dashed" v-for="(jadwal, index) in mahasiswa.jadwals" :key="index">
        <td class="px-2 lg:w-1">{{index+1}}</td>
        <td class="px-2 text-center">
          {{jadwal.matakuliah.kode_matakuliah}}
        </td>
        <td class="px-2">
          {{jadwal.matakuliah.nama_matakuliah}}
        </td>
        <td class="px-2 text-center">
          {{jadwal.matakuliah.sks}}
        </td>
        <td class="px-2 text-center">
          {{jadwal.pivot.nisbi ? jadwal.pivot.nisbi : "-"}}
        </td>
        <td class="px-2 text-center">
          {{jadwal.pivot.angka_mutu ? jadwal.pivot.angka_mutu : "-"}}
        </td>
        <td class="px-2 text-center">
          {{jadwal.matakuliah.sks * jadwal.pivot.angka_mutu}}
        </td>
      </tr>

      <tr class="w-full border border-slate-900 border-dashed">
        <td colspan="3" class="px-2 text-end">Total :</td>
        <td colspan="" class="px-2 text-center">{{totalSks}}</td>
        <td></td>
        <td></td>
        <td colspan="" class="px-2 text-center">{{totalSksKaliBobot}}</td>
      </tr>

      <tr class="w-full">
        <td colspan="2" class="px-2 text-start">SKS Nilai E : {{totalSksNilaiE}}</td>
        <td colspan="2" class="px-2 text-end">IPS :</td>
        <td colspan="" class="px-2 text-start">{{ips}}</td>
      </tr>
      <tr class="w-full">
        <td colspan="2" class="px-2 text-start">Maks. SKS y.a.d : {{sks_yad}}</td>
        <td colspan="2" class="px-2 text-end">IPK :</td>
        <td colspan="" class="px-2 text-start">{{ipk}}</td>
      </tr>
      <tr class="w-full">
        <td colspan="2" class="px-2 text-start">Jlh. SKS Lulus : {{totalSks - totalSksNilaiE}}</td>
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
  ips: Number,
  ipk: Number,
  ips_sebelumnya: Number,
  sks_yad: Number,
  wakil_ketua_1: Object,
  ta: Object
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

const totalSks = computed (()=> {
  let i = 0;
  props.mahasiswa.jadwals.forEach(jadwal => {
    i += jadwal.matakuliah.sks
  });
  return i
})


const totalSksKaliBobot = computed (()=> {
  let i = 0;
  props.mahasiswa.jadwals.forEach(jadwal => {
    i += jadwal.pivot.angka_mutu * jadwal.matakuliah.sks
  });
  return i
})



const totalSksNilaiE = computed (()=> {
  let i = 0;
  props.mahasiswa.jadwals.forEach(jadwal => {
    i += jadwal.pivot.angka_mutu == 0 ? jadwal.matakuliah.sks : 0
  });
  return i
})

const totalSksYAD = computed (() => {
  let sks = 24
  // const mahasiswa = props.mahasiswa;
  const tahun_ajarans = props.mahasiswa.tahun_ajaran;
  if (tahun_ajarans > 2) {
    if (props.ips > 0) {
      sks = 0
    }
  }

  return sks
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
}

@page {
  margin: 20px 20px;
}

</style>

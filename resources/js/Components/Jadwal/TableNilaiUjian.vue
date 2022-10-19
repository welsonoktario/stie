<template>
  <table
    class="mt-8 w-full table-auto border-collapse border border-zinc-900 font-mono text-xs"
  >
    <thead>
      <tr>
        <th rowspan="2" class="border border-zinc-900 p-2">NO</th>
        <th rowspan="2" class="border border-zinc-900 p-2">NPM</th>
        <th rowspan="2" class="border border-zinc-900 p-2">N A M A</th>
        <th colspan="3" class="border border-zinc-900 p-2">NILAI AKHIR</th>
      </tr>
      <tr>
        <th class="border border-zinc-900 p-2">ANGKA</th>
        <th class="border border-zinc-900 p-2">BOBOT</th>
        <th class="border border-zinc-900 p-2">HURUF</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(mhs, index) in jadwal.mahasiswas" :key="`absen-${index}`">
        <td class="border border-zinc-900 p-2 text-center">{{ index + 1 }}</td>
        <td class="border border-zinc-900 p-2 text-center">
          {{ nim(mhs.npm) }}
        </td>
        <td class="border border-zinc-900 p-2">
          {{ mhs.user.name }}
        </td>
        <td class="border border-zinc-900 p-2">
          {{ angka(mhs.jadwals[0].pivot.nilai_akhir) }}
        </td>
        <td class="border border-zinc-900 p-2">
          {{ bobot(mhs.jadwals[0].pivot.angka_mutu) }}
        </td>
        <td class="border border-zinc-900 p-2">
          {{ mhs.jadwals[0].pivot.nisbi }}
        </td>
      </tr>
    </tbody>
  </table>
</template>

<script setup>
defineProps({
  jadwal: Object,
})

const nim = (npm) => {
  const splitted = npm.split(".")

  return `${splitted[0]}${splitted[2]}${splitted[3]}`
}

const angka = (na) => Number(na) || ""
const bobot = (am) =>
  Number(am).toFixed(2) != "0.00" ? Number(am).toFixed(2) : ""
</script>

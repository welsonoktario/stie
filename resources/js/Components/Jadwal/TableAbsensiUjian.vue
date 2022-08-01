<template>
  <table
    class="mt-8 w-full table-auto border-collapse border border-zinc-900 font-mono text-xs"
  >
    <thead>
      <tr>
        <th rowspan="2" class="border border-zinc-900 p-2">NO</th>
        <th rowspan="2" class="border border-zinc-900 p-2">NIM</th>
        <th rowspan="2" class="border border-zinc-900 p-2">N A M A</th>
        <th rowspan="2" class="border border-zinc-900 p-2">TANDA TANGAN</th>
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
        <td class="border border-zinc-900 p-2"></td>
        <td class="border border-zinc-900 p-2"></td>
        <td class="border border-zinc-900 p-2"></td>
        <td class="border border-zinc-900 p-2"></td>
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
</script>

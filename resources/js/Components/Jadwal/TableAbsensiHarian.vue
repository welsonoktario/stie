<template>
  <table
    class="mt-8 w-full table-auto border-collapse border border-zinc-900 font-mono text-xs"
  >
    <thead>
      <tr>
        <th rowspan="3" class="border border-zinc-900 p-2">NO</th>
        <th rowspan="3" class="border border-zinc-900 p-2">NIM</th>
        <th rowspan="3" class="border border-zinc-900 p-2">N A M A</th>
        <th colspan="16" class="border border-zinc-900 p-2">Pertemuan ke-</th>
      </tr>
      <tr>
        <th
          v-for="pertemuan in 16"
          :key="`pertemuan-${pertemuan}`"
          class="border border-zinc-900 p-2"
        >
          {{ pertemuan }}
        </th>
      </tr>
      <tr>
        <th
          v-for="pertemuan in 16"
          :key="`pertemuan-tanggal-${pertemuan}`"
          class="h-10 border border-zinc-900 p-2"
        ></th>
      </tr>
    </thead>

    <tbody>
      <tr v-for="(mhs, index) in jadwal.mahasiswas" :key="`mhs-${index}`">
        <td class="border border-zinc-900 p-2 text-center">
          {{ index + 1 }}
        </td>
        <td class="border border-zinc-900 p-2 text-center">
          {{ nim(mhs.npm) }}
        </td>
        <td class="border border-zinc-900 p-2">
          {{ mhs.user.name }}
        </td>
        <td
          v-for="pertemuan in 16"
          :key="`pertemuan-mhs-${pertemuan}`"
          class="border border-zinc-900 p-2"
        ></td>
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

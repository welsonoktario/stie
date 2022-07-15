<template>
  <div class="grid-cols-24 mt-8 grid w-full font-mono text-xs">
    <div
      class="flex items-center justify-center border-x border-y border-black font-bold"
    >
      No.
    </div>
    <div
      class="col-span-2 flex items-center justify-center border-y border-r border-black font-bold"
    >
      NIM
    </div>
    <div
      class="col-span-7 flex items-center justify-center border-y border-r border-black font-bold"
    >
      N A M A
    </div>
    <div
      class="col-span-14 flex w-full flex-col border-t border-r border-black font-bold"
    >
      <p class="text-center">Pertemuan ke-</p>
      <div class="inline-flex justify-between">
        <div
          v-for="pertemuan in 14"
          :key="`pertemuan-${pertemuan}`"
          class="w-full border-t border-black text-center"
          :class="pertemuan != 14 ? ' border-r' : null"
        >
          {{ pertemuan }}
        </div>
      </div>
      <div class="inline-flex justify-between">
        <div
          v-for="pertemuan in 14"
          :key="`pertemuan-tanggal-${pertemuan}`"
          class="h-6 w-full border-y border-black"
          :class="pertemuan != 14 ? ' border-r' : null"
        ></div>
      </div>
    </div>

    <template v-for="(mhs, index) in jadwal.mahasiswas" :key="`mhs-${index}`">
      <div class="td flex items-center border-x border-b border-black p-1">
        {{ index + 1 }}
      </div>
      <div
        class="td col-span-2 flex items-center border-r border-b border-black p-1"
      >
        {{ nim(mhs.npm) }}
      </div>
      <div
        class="td col-span-7 flex items-center border-r border-b border-black p-1"
      >
        {{ mhs.user.name }}
      </div>
      <div class="td col-span-14 inline-flex">
        <div
          v-for="pertemuan in 14"
          :key="`pertemuan-mhs-${pertemuan}`"
          class="w-full border-r border-b border-black p-1"
        ></div>
      </div>
    </template>
  </div>
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

<style scoped>
.grid-cols-24 {
  grid-template-columns: repeat(24, minmax(0, 1fr));
}

.col-span-14 {
  grid-column: span 14 / span 14;
}

@media print {
  .td {
    break-inside: avoid;
  }
}
</style>

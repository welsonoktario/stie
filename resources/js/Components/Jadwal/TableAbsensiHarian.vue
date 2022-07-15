<template>
  <div class="grid-cols-24 mt-8 grid w-full font-mono text-xs">
    <div class="flex items-center justify-center border">No.</div>
    <div class="col-span-2 flex items-center justify-center border">NIM</div>
    <div class="col-span-7 flex items-center justify-center border">
      N A M A
    </div>
    <div class="col-span-14 flex w-full flex-col">
      <p class="border text-center">Pertemuan ke-</p>
      <div class="inline-flex justify-between border">
        <div
          v-for="pertemuan in 14"
          :key="`pertemuan-${pertemuan}`"
          class="w-full border"
        >
          {{ pertemuan }}
        </div>
      </div>
      <div class="inline-flex justify-between border">
        <div
          v-for="pertemuan in 14"
          :key="`pertemuan-tanggal-${pertemuan}`"
          class="h-6 w-full border"
        ></div>
      </div>
    </div>

    <template v-for="(mhs, index) in jadwal.mahasiswas" :key="`mhs-${index}`">
      <div class="td flex items-center border py-1">{{ index + 1 }}</div>
      <div class="td col-span-2 flex items-center border">
        {{ nim(mhs.npm) }}
      </div>
      <div class="td col-span-7 flex items-center border">
        {{ mhs.user.name }}
      </div>
      <div class="td col-span-14 inline-flex border">
        <div
          v-for="pertemuan in 14"
          :key="`pertemuan-mhs-${pertemuan}`"
          class="w-full border"
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

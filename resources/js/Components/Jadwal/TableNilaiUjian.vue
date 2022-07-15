<template>
  <div class="grid-cols-24 mt-8 grid w-full font-mono text-xs">
    <div
      class="flex items-center justify-center border-x border-y border-black font-bold"
    >
      No.
    </div>
    <div
      class="col-span-3 flex items-center justify-center border-y border-r border-black font-bold"
    >
      NIM
    </div>
    <div
      class="col-span-8 flex items-center justify-center border-y border-r border-black font-bold"
    >
      N A M A
    </div>
    <div
      class="col-span-12 flex flex-col items-center justify-center border-t border-r border-black font-bold"
    >
      <p class="text-center">Nilai Akhir</p>
      <div class="inline-flex w-full justify-between">
        <div class="w-full border-y border-r border-black text-center">
          ANGKA
        </div>
        <div class="w-full border-y border-r border-black text-center">
          BOBOT
        </div>
        <div class="w-full border-y border-black text-center">HURUF</div>
      </div>
    </div>

    <template v-for="(mhs, index) in jadwal.mahasiswas" :key="`absen-${index}`">
      <div class="td border-x border-b border-black p-1">{{ index + 1 }}</div>
      <div
        class="td col-span-3 flex items-center border-r border-b border-black p-1"
      >
        {{ nim(mhs.npm) }}
      </div>
      <div
        class="td col-span-8 flex items-center border-r border-b border-black p-1"
      >
        {{ mhs.user.name }}
      </div>
      <div class="col-span-12">
        <div class="inline-flex h-full w-full justify-between">
          <div class="w-full border-r border-b border-black">
            {{ angka(mhs.jadwals[0].pivot.nilai_akhir) }}
          </div>
          <div class="w-full border-r border-b border-black">
            {{ bobot(mhs.jadwals[0].pivot.angka_mutu) }}
          </div>
          <div class="w-full border-r border-b border-black">
            {{ mhs.jadwals[0].pivot.nisbi }}
          </div>
        </div>
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

const angka = (na) => Number(na) || ""
const bobot = (am) =>
  Number(am).toFixed(2) != "0.00" ? Number(am).toFixed(2) : ""
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

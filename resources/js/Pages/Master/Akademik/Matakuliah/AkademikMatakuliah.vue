<template>
  <AppLayout>
    <div class="container mx-auto px-4 py-6 rounded-md bg-white">
      <DataTable :columns="columns" :data="matakuliahs" />
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"

defineProps({
  matakuliahs: Object,
})

const columns = [
  {
    key: "id",
    label: "ID",
  },
  {
    key: "kode_matakuliah",
    label: "Kode",
  },
  {
    key: "nama_matakuliah",
    label: "Nama",
  },
  {
    key: "sks",
    label: "SKS",
  },
  {
    key: "tipe",
    label: "Tipe",
  },
]
</script>

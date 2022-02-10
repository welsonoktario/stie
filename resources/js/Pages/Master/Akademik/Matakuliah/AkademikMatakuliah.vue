<template>
  <AppLayout>
    <div
      class="container mx-auto p-6 rounded-md bg-white dark:bg-zinc-800 overflow-auto"
    >
      <p class="text-xs md:text-sm">Akademik / Matakuliah</p>
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
            >Daftar Matakuliah</strong
          >
        </span>

        <Button
          type="button"
          class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
        >
          <Link :href="route('master.matakuliah.create')" preserve-state
            >Tambah Matakuliah</Link
          >
        </Button>
      </div>

      <DataTable :columns="columns" :data="matakuliahs">
        <template #row(tipe)="row">
          <span class="capitalize">{{ row.data.tipe }}</span>
        </template>

        <template #row(jurusan_nama)="row">
          <span class="capitalize">{{ row.data.jurusan_nama ?? '-' }}</span>
        </template>

        <template #actions="row">
          <NavLink
            as="button"
            :href="route('master.matakuliah.edit', row.data.id)"
            >Edit</NavLink
          >
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App";
import Button from "@components/Button";
import DataTable from "@components/DataTable";
import NavLink from "@components/NavLink";
import { Link } from "@inertiajs/inertia-vue3";

export default {
  components: {
    AppLayout,
    Button,
    DataTable,
    NavLink,
    Link,
  },
  props: {
    matakuliahs: Object,
  },
  setup() {
    const columns = [
      {
        key: "id",
        label: "ID",
      },
      {
        key: "kode_matakuliah",
        label: "Kode",
        sortable: true,
      },
      {
        key: "nama_matakuliah",
        label: "Nama",
        sortable: true,
      },
      {
        key: "kurikulum_nama",
        label: "Kurikulum",
        sortable: true,
      },
      {
        key: 'jurusan_nama',
        label: 'Jurusan',
        sortable: true
      },
      {
        key: "sks",
        label: "SKS",
        sortable: true,
      },
      {
        key: "tipe",
        label: "Tipe",
        sortable: true,
      },
    ];

    return { columns };
  },
};
</script>

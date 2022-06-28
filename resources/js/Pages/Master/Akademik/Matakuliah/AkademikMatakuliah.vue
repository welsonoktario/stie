<template>
  <AppLayout title="Matakuliah">
    <div
      class="container mx-auto overflow-auto rounded-md bg-white p-6 dark:bg-zinc-800"
    >
      <p class="text-xs md:text-sm">Akademik / Matakuliah</p>
      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
            >Daftar Matakuliah</strong
          >
        </span>

        <LinkButton :href="route('master.matakuliah.create')"
          >Tambah Matakuliah</LinkButton
        >
      </div>

      <DataTable :columns="columns" :data="matakuliahs">
        <template #row(tipe)="row">
          <span class="capitalize">{{ row.data.tipe }}</span>
        </template>

        <template #row(jurusan_nama)="row">
          <span class="capitalize">{{ row.data.jurusan_nama ?? "-" }}</span>
        </template>

        <template #actions="row">
          <NavLink :href="route('master.matakuliah.edit', row.data.id)"
            >Edit</NavLink
          >
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"
import NavLink from "@components/NavLink"
import LinkButton from "@/Components/LinkButton"

export default {
  components: {
    AppLayout,
    DataTable,
    NavLink,
    LinkButton,
  },
  props: {
    matakuliahs: Object,
  },
  setup() {
    const columns = [
      {
        key: "id",
        label: "ID",
        sortable: true,
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
        key: "jurusan_nama",
        label: "Jurusan",
        sortable: true,
      },
      {
        key: "semester",
        label: "SMT",
        sortable: true,
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
    ]

    return { columns }
  },
}
</script>

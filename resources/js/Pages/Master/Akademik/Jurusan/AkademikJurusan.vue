<template>
  <AppLayout title="Jurusan">
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs md:text-sm">Akademik / Prodi / Departemen</p>
      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
            >Daftar Prodi / Departemen</strong
          >
        </span>

        <LinkButton :href="route('master.jurusan.create')"
          >Tambah Prodi / Departemen</LinkButton
        >
      </div>

      <DataTable :columns="columns" :data="jurusans">
        <template #actions="row">
          <NavLink :href="route('master.jurusan.edit', row.data.id)"
            >Edit</NavLink
          >
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App"
import DataTable from "@/Components/DataTable"
import NavLink from "@/Components/NavLink"
import LinkButton from "@/Components/LinkButton"

export default {
  components: {
    AppLayout,
    DataTable,
    NavLink,
    LinkButton,
  },
  props: {
    jurusans: Object,
  },
  setup(props) {
    const columns = [
      {
        key: "kode_jurusan",
        label: "Kode Prodi / Departemen",
        sortable: true,
      },
      {
        key: "nama",
        label: "Nama",
        sortable: true,
      },
    ]

    return {
      columns,
    }
  },
}
</script>

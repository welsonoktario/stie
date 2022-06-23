<template>
  <AppLayout title="Jurusan">
    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
      <p class="text-xs md:text-sm">Akademik / Prodi / Departemen</p>
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >Daftar Prodi / Departemen</strong>
        </span>

        <LinkButton :href="route('master.jurusan.create')">Tambah Prodi / Departemen</LinkButton>
      </div>

      <DataTable :columns="columns" :data="jurusans">
        <template #actions="row">
          <NavLink :href="route('master.jurusan.edit', row.data.id)">Edit</NavLink>
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

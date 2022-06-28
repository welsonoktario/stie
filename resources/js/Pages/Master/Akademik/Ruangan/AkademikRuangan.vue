<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs md:text-sm">Akademik / Ruangan</p>
      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
            >Daftar Ruangan</strong
          >
        </span>

        <LinkButton :href="route('master.ruangan.create')"
          >Tambah Ruangan</LinkButton
        >
      </div>

      <DataTable :columns="columns" :data="ruangans">
        <template #actions="row">
          <NavLink :href="route('master.ruangan.edit', row.data.id)"
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
    ruangans: Object,
  },
  setup(props) {
    const columns = [
      {
        key: "id",
        label: "ID",
        sortable: true,
      },
      {
        key: "nama_ruangan",
        label: "Nama Ruangan",
        sortable: true,
      },
    ]

    return {
      columns,
    }
  },
}
</script>

<template>
  <AppLayout>
    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
      <p class="text-xs md:text-sm">Akademik / Ruangan</p>
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >Daftar Ruangan</strong>
        </span>

        <LinkButton :href="route('master.ruangan.create')">Tambah Ruangan</LinkButton>
      </div>

      <DataTable :columns="columns" :data="ruangans">
        <template #actions="row">
          <NavLink :href="route('master.ruangan.edit', row.data.id)">Edit</NavLink>
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
    LinkButton
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

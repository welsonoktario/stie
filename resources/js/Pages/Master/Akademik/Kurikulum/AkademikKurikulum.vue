<template>
  <AppLayout title="Kurikulum">
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs md:text-sm">Akademik / Kurikulum</p>
      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
            >Daftar Kurikulum</strong
          >
        </span>

        <LinkButton :href="route('master.kurikulum.create')"
          >Tambah Kurikulum</LinkButton
        >
      </div>

      <DataTable :columns="columns" :data="kurikulums">
        <template #row(aktif)="row">{{
          row.data.aktif ? "Aktif" : "Non-Aktif"
        }}</template>

        <template #actions="row">
          <NavLink :href="route('master.kurikulum.edit', row.data.id)"
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
    kurikulums: Object,
  },
  setup(props) {
    const columns = [
      {
        key: "id",
        label: "ID",
      },
      {
        key: "nama",
        label: "Nama",
        sortable: true,
      },
      {
        key: "aktif",
        label: "Aktif",
        sortable: true,
      },
    ]

    return {
      columns,
    }
  },
}
</script>

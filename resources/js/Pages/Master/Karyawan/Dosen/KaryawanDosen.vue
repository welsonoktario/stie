<template>
  <AppLayout title="Dosen">
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs md:text-sm">Karyawan / Dosen</p>

      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
            >Daftar Dosen</strong
          >
        </span>

        <LinkButton :href="route('master.dosen.create')"
          >Tambah Dosen</LinkButton
        >
      </div>

      <DataTable :columns="columns" :data="dosens">
        <template #actions="row">
          <NavLink :href="route('master.dosen.edit', row.data.id)"
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
    dosens: Object,
  },
  setup(props) {
    const columns = [
      {
        key: "id",
        label: "ID",
        sortable: true,
      },
      {
        key: "user_name",
        label: "Nama",
        sortable: true,
      },
      {
        key: "konsentrasi",
        label: "Konsentrasi",
        sortable: true,
      },
      {
        key: "tipe_id",
        label: "Tipe ID",
        sortable: true,
      },
      {
        key: "jurusan_nama",
        label: "Jurusan",
        sortable: true,
      },
      {
        key: "staff_status",
        label: "Status",
        sortable: true,
      },
    ]
    return {
      columns,
    }
  },
}
</script>

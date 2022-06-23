<template>
  <AppLayout title="Karyawan">
    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
      <p class="text-xs md:text-sm">Karyawan / Karyawan</p>

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >DAFTAR KARYAWAN</strong>
        </span>

        <LinkButton :href="route('master.karyawan.create')">Tambah Karyawan</LinkButton>
      </div>

      <DataTable :columns="columns" :data="karyawans">
        <template #actions="row">
          <NavLink :href="route('master.karyawan.edit', row.data.id)">Edit</NavLink>
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
    karyawans: Object,
  },
  setup(props) {
    const columns = [
      {
        key: "user_name",
        label: "Nama",
        sortable: true,
      },
      {
        key: "divisi",
        label: "Divisi",
        sortable: true,
      },
      {
        key: "status_karyawan",
        label: "Status Karyawan",
        sortable: true,
      },
      {
        key: "level_pengguna",
        label: "Level Pengguna",
        sortable: true,
      },
    ]

    return {
      columns,
    }
  },
}
</script>

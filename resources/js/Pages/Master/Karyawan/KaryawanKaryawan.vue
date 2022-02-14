<template>
  <AppLayout title="Karyawan">
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm">Karyawan / Karyawan</p>

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
            >DAFTAR KARYAWAN</strong
          >
        </span>
        <NavLink :href="route('master.karyawan.create')">
          Tambah Karyawan
        </NavLink>
      </div>
    </div>

    <DataTable :columns="columns" :data="karyawans">

    </DataTable>
  </AppLayout>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import AppLayout from "@layouts/App.vue"
import DataTable from "@/Components/DataTable"
import NavLink from "@/Components/NavLink"

export default {
  components: {
    AppLayout,
    DataTable,
    Link,
    NavLink,
  },
  props: {
    karyawans: Object,
  },
  setup(props) {
    const columns = [
      {
        key: "user.nama",
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

    const karyawans = [
      {
        name: "Jane Cooper",
        title: "Regional Paradigm Technician",
        department: "Optimization",
        role: "Admin",
        email: "jane.cooper@example.com",
        image:
          "https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60",
      },
    ]
    return {
      columns,
    }
  },
}
</script>

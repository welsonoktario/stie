<template>
  <AppLayout title="Dosen">
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Karyawan / Dosen</p>

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
            >Daftar Dosen</strong
          >
        </span>
        <Button type="button">
          <Link :href="route('master.dosen.create')" class="h-full w-full">
            Tambah Dosen
          </Link>
        </Button>
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
import { Link } from "@inertiajs/inertia-vue3"
import AppLayout from "@layouts/App"
import Button from "@components/Button"
import DataTable from "@/Components/DataTable"
import NavLink from "@/Components/NavLink"

export default {
  components: {
    AppLayout,
    Button,
    DataTable,
    Link,
    NavLink,
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

<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Akademik / Tahun Ajaran</p>
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
            >Daftar Tahun Ajaran</strong
          >
        </span>

        <Button type="button">
          <Link :href="route('master.tahun_ajaran.create')">
            Tambah Tahun Ajaran
          </Link>
        </Button>
      </div>

      <DataTable :columns="columns" :data="tahunAjarans">
        <template #actions="row">
          <NavLink :href="route('master.tahun_ajaran.edit', row.data.id)"
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
    DataTable,
    Button,
    NavLink,
    Link,
  },
  props: {
    tahunAjarans: Object,
  },
  setup(props) {
    const columns = [
      {
        key: "tahun_ajaran",
        label: "Tahun Ajaran",
        sortable: true,
      },
      {
        key: "tahun_mulai",
        label: "Tahun Mulai",
        sortable: true,
      },
      {
        key: "tahun_selesai",
        label: "Tahun Selesai",
        sortable: true,
      },
      {
        key: "periode",
        label: "Periode",
        sortable: true,
      },
    ]

    return {
      columns,
    }
  },
}
</script>

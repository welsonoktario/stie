<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Akademik / Jabatan Struktural</p>
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
            >Daftar Jabatan Struktural</strong
          >
        </span>

        <!-- <Button type="button">
          <Link :href="route('master.tahun-ajaran.create')">
            Tambah Tahun Akademik
          </Link>
        </Button> -->
      </div>

      <DataTable :columns="columns" :data="jabatans">
        <template #actions="row">
          <NavLink
            >Edit</NavLink
          >
        </template>
        <template #row(name)="row">
          <p v-if="!row.data.name">-</p>
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
    jabatans: Object,
  },
  setup(props) {
    const columns = [
      {
        key: "nama_jabatan",
        label: "Jabatan",
      },
      {
        key: "name",
        label: "Pemangku Jabatan",
      },
    ]

    return {
      columns,
    }
  },
}
</script>

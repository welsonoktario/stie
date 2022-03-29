<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Mahasiswa / Mahasiswa Reguler</div> -->
      <p class="text-xs md:text-sm">Mahasiswa / Mahasiswa Reguler</p>

      <!-- Belum bisa ubah id dosen dan staff -->

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
            >Daftar Mahasiswa Reguler</strong
          >
        </span>
        <Button type="button">
          <Link :href="route('master.mahasiswa-reguler.create')" type="link">
            Tambah Mahasiswa
          </Link>
        </Button>
      </div>

      <DataTable :data="mahasiswas" :columns="columns">
        <template #row(jurusan)="row">
          <span class="capitalize">{{ row.data.jurusan ?? "-" }}</span>
        </template>

        <template #actions="row">
          <Link
            as="button"
            :href="route('master.mahasiswa-reguler.edit', row.data.npm)"
            >Edit</Link
          >
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"
import Button from "@components/Button"

import { Link } from "@inertiajs/inertia-vue3"

export default {
  components: {
    AppLayout,
    Link,
    DataTable,
    Button,
  },
  props: {
    mahasiswas: {
      type: Object,
      default: null,
    },
  },
  setup(props) {
    const columns = [
      {
        key: "npm",
        label: "NPM",
      },
      {
        key: "nama",
        label: "Nama",
        sortable: true,
      },
      {
        key: "status_mahasiswa",
        label: "Status Mahasiswa",
        sortable: true,
      },
      {
        key: "jurusan",
        label: "Jurusan",
        sortable: true,
      },
    ]
    return {
      columns,
    }
  },
}
</script>

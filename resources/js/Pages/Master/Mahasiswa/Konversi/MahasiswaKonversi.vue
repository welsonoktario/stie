<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Mahasiswa / Mahasiswa Reguler</div> -->
      <p class="text-xs md:text-sm">Mahasiswa / Mahasiswa Konversi</p>

      <!-- Belum bisa ubah id dosen dan staff -->

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
            >Daftar Mahasiswa Konversi</strong
          >
        </span>
        <NavLink
          :href="route('master.mahasiswa-konversi.create')"
          method="get"
          type="link"
          class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
        >
          Tambah Mahasiswa
        </NavLink>
      </div>

      <DataTable :data="mahasiswas" :columns="columns">

        <template #row(jurusan)="row">
          <span class="capitalize">{{ row.data.jurusan ?? '-' }}</span>
        </template>

        <template #actions="row">
          <NavLink
            :href="route('master.mahasiswa-konversi.edit', row.data.npm)"
            >Edit</NavLink>
        </template>
      </DataTable>

    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App.vue"
import DataTable from "@components/DataTable.vue"

import NavLink from "@components/NavLink.vue"

export default {
  components: {
    AppLayout,
    NavLink,
    DataTable,
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

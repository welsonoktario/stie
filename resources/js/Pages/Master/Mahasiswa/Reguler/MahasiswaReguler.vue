<template>
  <AppLayout>
    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
      <!-- <div class="p-6">Mahasiswa / Mahasiswa Reguler</div> -->
      <p class="text-xs md:text-sm">Mahasiswa / Mahasiswa Reguler</p>

      <!-- Belum bisa ubah id dosen dan staff -->

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >Daftar Mahasiswa Reguler</strong>
        </span>

        <LinkButton :href="route('master.mahasiswa-reguler.create')" type="link">Tambah Mahasiswa</LinkButton>
      </div>

      <DataTable :data="mahasiswas" :columns="columns">
        <template #row(jurusan)="row">
          <span class="capitalize">{{ row.data.jurusan ?? "-" }}</span>
        </template>

        <template #row(tanggal_masuk)="row">
          <span class="capitalize">{{ (row.data.tanggal_masuk).split('-')[0] ?? "-" }}</span>
        </template>

        <template #actions="row">
          <NavLink :href="route('master.mahasiswa-reguler.edit', row.data.npm)">Edit</NavLink>
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"
import NavLink from "@components/NavLink"
import LinkButton from "@/Components/LinkButton.vue"

export default {
  components: {
    AppLayout,
    NavLink,
    DataTable,
    LinkButton
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
      {
        key: "tanggal_masuk",
        label: "Angkatan",
        sortable: true
      }
    ]
    return {
      columns,
    }
  },
}
</script>

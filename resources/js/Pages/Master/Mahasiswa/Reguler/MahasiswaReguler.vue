<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <!-- <div class="p-6">Mahasiswa / Mahasiswa Reguler</div> -->
      <p class="text-xs md:text-sm">Mahasiswa / Mahasiswa Reguler</p>

      <!-- Belum bisa ubah id dosen dan staff -->

      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
            >Daftar Mahasiswa Reguler</strong
          >
        </span>

        <LinkButton :href="route('master.mahasiswa-reguler.create')" type="link"
          >Tambah Mahasiswa</LinkButton
        >
      </div>

      <!-- Ini baru, belum diimplementasiin
      <div class="item-center my-3 flex justify-start gap-x-3">
        <div class="flex flex-col gap-y-2">
          <Label for="angkatan">Angkatan</Label>
          <select
            id="angkatan"
            name="angkatan"
            class="rounded-md border-none bg-zinc-100 pl-2 pr-8 text-sm focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            @change="console.log('tes')"
          >
            <option :value="2017" selected>2017</option>
            <option :value="2018">2018</option>
            <option :value="0">Semua</option>
          </select>

        </div>

        <div class="flex flex-col gap-y-2">
          <Label for="jurusan">Jurusan</Label>
          <select
            id="jurusan"
            name="jurusan"
            class="rounded-md border-none bg-zinc-100 pl-2 pr-8 text-sm focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            @change="console.log('tes')"
          >
            <option :value="0" selected>Semua</option>
            <option :value="1">Manajemen</option>
            <option :value="2">Ekonomi Pembangunan</option>
          </select>

        </div>

        <div class="flex flex-col gap-y-2">
          <Label for="status">Status</Label>
          <select
            id="status"
            name="status"
            class="rounded-md border-none bg-zinc-100 pl-2 pr-8 text-sm focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            @change="console.log('tes')"
          >
            <option :value="0" selected>Semua</option>
            <option :value="1">Aktif</option>
            <option :value="2">Tidak aktif</option>
            <option :value="3">Lulus</option>
          </select>

        </div>
      </div> -->

      <DataTable :data="mahasiswas" :columns="columns">
        <template #row(jurusan)="row">
          <span class="capitalize">{{ row.data.jurusan ?? "-" }}</span>
        </template>

        <template #row(tanggal_masuk)="row">
          <span class="capitalize">{{
            row.data.tanggal_masuk.split("-")[0] ?? "-"
          }}</span>
        </template>

        <template #actions="row">
          <NavLink :href="route('master.mahasiswa-reguler.edit', row.data.npm)"
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
import LinkButton from "@/Components/LinkButton.vue"
import Label from "@/Components/Label.vue"

export default {
  components: {
    AppLayout,
    NavLink,
    DataTable,
    LinkButton,
    Label,
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
        sortable: true,
      },
    ]
    return {
      columns,
    }
  },
}
</script>

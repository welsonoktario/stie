<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs md:text-sm">Akademik / Tahun Akademik</p>
      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
            >Daftar Tahun Akademik</strong
          >
        </span>

        <LinkButton :href="route('master.tahun-ajaran.create')"
          >Tambah Tahun Akademik</LinkButton
        >
      </div>

      <DataTable :columns="columns" :data="tahunAjarans">
        <template #actions="row">
          <NavLink :href="route('master.tahun-ajaran.edit', row.data.id)"
            >Edit</NavLink
          >
        </template>
        <template #row(aktif)="row">
          <span
            :class="[
              row.data.aktif
                ? 'bg-green-600 text-green-100 '
                : 'bg-red-600 text-red-100 ',
            ]"
            class="mr-2 inline-flex items-center justify-center rounded-full px-2 py-1 text-xs font-bold leading-none"
            >{{ row.data.aktif ? "Aktif" : "Nonaktif" }}</span
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
        key: "tanggal_mulai",
        label: "Tanggal Mulai",
        sortable: true,
      },
      {
        key: "tanggal_selesai",
        label: "Tanggal Selesai",
        sortable: true,
      },
      {
        key: "periode",
        label: "Periode",
        sortable: true,
      },
      {
        key: "aktif",
        label: "Aktif",
        sortable: true,
      },
    ]

    return {
      columns,
    }
  },
}
</script>

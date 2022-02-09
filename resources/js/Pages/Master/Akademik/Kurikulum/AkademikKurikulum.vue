<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Akademik / Kurikulum</p>
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
            >Daftar Kurikulum</strong
          >
        </span>

        <Link
          :href="route('master.kurikulum.create')"
          method="get"
          as="button"
          type="link"
          class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
        >
          Tambah Kurikulum
        </Link>
      </div>

      <DataTable :columns="columns" :data="kurikulums">
        <template #row(aktif)="row">
          {{ row.data.aktif ? "Aktif" : "Non-Aktif" }}
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"
import { Link } from "@inertiajs/inertia-vue3"

export default {
  components: {
    AppLayout,
    DataTable,
    Link,
  },
  props: {
    kurikulums: {
      type: Object,
      default: null,
    },
  },
  setup(props) {
    const columns = [
      {
        key: "id",
        label: "ID",
      },
      {
        key: "nama",
        label: "Nama",
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

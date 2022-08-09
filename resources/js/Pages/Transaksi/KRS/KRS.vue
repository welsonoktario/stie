<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <!-- <div class="p-6">Mahasiswa / Mahasiswa Reguler</div> -->
      <p class="text-xs md:text-sm">Transaksi / KRS</p>

      <!-- Belum bisa ubah id dosen dan staff -->

      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
            >Rencana Studi Mahasiswa</strong
          >
        </span>
      </div>

      <div class="mb-1 inline-flex items-center text-sm">
        <label for="tahun_ajarans">Tahun Akademik</label>
        <select
          id="tahun_ajaran"
          v-model="selectedTahunAjaran"
          name="tahun_ajarans"
          class="ml-2 rounded-md border-none bg-zinc-100 pl-2 pr-6 text-sm focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
          @change="loadTahunAjaran(selectedTahunAjaran)"
        >
          <option
            v-for="ta in tahun_ajarans"
            :key="ta.id"
            :value="ta.id"
            :selected="ta.aktif"
          >
            {{ ta.tahun_ajaran }}
          </option>
        </select>
      </div>

      <DataTable :data="mahasiswas" :columns="columns">
        <template #row(jurusan)="row">
          <span class="capitalize">{{ row.data.jurusan ?? "-" }}</span>
        </template>

        <template #actions="row">
          <Link
            :href="
              route('transaksi.krs.edit', {
                kr: row.data.npm,
                ta: selectedTahunAjaran,
              })
            "
            target="_blank"
            >Edit</Link
          >
        </template>
        <template #row(cicilan_1)="row">
          <div v-if="row.data.cicilan_1 == null" class="text-red-500">
            <p class="text-xl font-extrabold">-</p>
          </div>
          <div v-else class="text-green-600">L</div>
        </template>
        <template #row(cicilan_2)="row">
          <div v-if="row.data.cicilan_2 == null" class="text-red-500">
            <p class="text-xl font-extrabold">-</p>
          </div>
          <div v-else class="text-green-600">L</div>
        </template>
        <template #row(cicilan_3)="row">
          <div v-if="row.data.cicilan_3 == null" class="text-red-500">
            <p class="text-xl font-extrabold">-</p>
          </div>
          <div v-else class="text-green-600">L</div>
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"
import Button from "@components/Button"
import Link from "@/Components/Link"

import { Inertia } from "@inertiajs/inertia"
import { ref } from "vue"

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
    tahun_ajarans: {
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
        key: "status",
        label: "Status",
        sortable: true,
      },
      {
        key: "cicilan_1",
        label: "Cicilan 1",
        sortable: true,
      },
      {
        key: "jurusan",
        label: "Jurusan",
        sortable: true,
      },
    ]

    const selectedTahunAjaran = ref(
      props.tahun_ajarans.find((o) => o.aktif === true).id
    )

    const loadTahunAjaran = (id) => {
      const current = route().current()
      const params = route().params
      params.ta = id

      Inertia.get(route(current), params, {
        preserveScroll: true,
        preserveState: true,
      })
    }

    return {
      columns,
      selectedTahunAjaran,
      loadTahunAjaran,
    }
  },
}
</script>

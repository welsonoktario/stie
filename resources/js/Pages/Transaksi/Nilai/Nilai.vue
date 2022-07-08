<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs md:text-sm">Nilai / Daftar Nilai</p>

      <div class="my-3 inline-flex w-full items-center justify-between">
        <div>
          <strong
            class="content-middle whitespace-nowrap align-middle text-sm md:text-lg"
            >Daftar Nilai</strong
          >
          <select
            id="tahun_ajaran"
            v-model="selectedTA"
            name="tahun_ajarans"
            class="ml-2 rounded-md border-none bg-zinc-100 pl-2 pr-8 text-sm focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            @change="onTahunAjaranChange(selectedTA)"
          >
            <option value="-" selected>Pilih tahun akademik</option>
            <option
              v-for="ta in tahunAkademiks"
              :key="ta.id"
              :value="ta.id"
              :selected="ta.aktif"
            >
              {{ ta.tahun_ajaran }}
            </option>
          </select>
        </div>
      </div>

      <DataTable :data="mahasiswas" :columns="columns">
        <template #row(jurusan)="row">
          <span class="capitalize">{{ row.data.jurusan ?? "-" }}</span>
        </template>

        <template #actions="row">
          <Link
            :href="
              route('transaksi.nilai.edit', {
                mahasiswa: row.data.npm,
                ta: selectedTA,
              })
            "
            target="_blank"
          >
            <PencilIcon class="h-4" />
          </Link>
        </template>
      </DataTable>
      <div>
        <Link
          as="link"
          :href= "
              route('print.aktivitas', {
                ta: selectedTA
              })
          "
          class="mt-3">
          <PrinterIcon class="h-4"/> Cetak Laporan Aktivitas Mahasiswa
        </Link>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
import { PencilIcon, PrinterIcon } from "@heroicons/vue/outline"
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"
import Link from "@/Components/Link"

const props = defineProps({
  mahasiswas: Object,
  tahunAkademiks: Array,
  selectedTahunAkademik: {
    type: Number,
    default: "-",
  },
})

const columns = [
  {
    key: "npm",
    label: "NPM",
  },
  {
    key: "nama",
    label: "Nama",
  },
  {
    key: "jurusan",
    label: "Jurusan",
  },
  {
    key: "status",
    label: "Status Mahasiswa",
  },
]

const selectedTA = ref(props.selectedTahunAkademik)

const onTahunAjaranChange = (ta) => {
  const filter = { ta: selectedTA.value, ...route().params }
  filter.ta = selectedTA.value

  ta &&
    Inertia.visit(route("transaksi.nilai.index", filter), {
      only: ["mahasiswas", "selectedTahunAkademik"],
      preserveScroll: true,
      preserveState: true,
    })
}
</script>

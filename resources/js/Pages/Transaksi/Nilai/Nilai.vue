<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Nilai / Daftar Nilai</p>

      <div class="inline-flex justify-between my-3 w-full items-center">
        <div>
          <strong
            class="whitespace-nowrap align-middle text-sm md:text-lg content-middle"
            >Daftar Nilai</strong
          >
          <select
            id="tahun_ajaran"
            v-model="selectedTA"
            name="tahun_ajarans"
            class="ml-2 pl-2 pr-8 text-sm bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
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
    </div>
  </AppLayout>
</template>

<script setup>
import { ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
import { PencilIcon } from "@heroicons/vue/outline"
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
    key: "status_mahasiswa",
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

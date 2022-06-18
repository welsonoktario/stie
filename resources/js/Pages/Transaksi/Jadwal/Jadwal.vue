<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Jadwal / Daftar Jadwal</p>

      <div class="inline-flex justify-between my-3 w-full items-center">
        <div>
          <strong
            class="whitespace-nowrap align-middle text-sm md:text-lg content-middle"
            >Daftar Jadwal</strong
          >

          <select
            name="tahun_ajarans"
            id="tahun_ajaran"
            class="ml-2 pl-2 pr-8 text-sm bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            v-model="selectedTA"
            @change="onTahunAjaranChange(selectedTA)"
          >
            <option :value="null" selected>Pilih tahun akademik</option>
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

        <Button type="button">
          <Link :href="route('transaksi.jadwal.create', { ta: selectedTA })">
            Tambah Jadwal
          </Link>
        </Button>
      </div>

      <DataTable :data="jadwals" :columns="columns">
        <template #row(hari)="row">
          <span>{{ `${row.data.hari}, ${row.data.jam}` }}</span>
        </template>

        <template #actions="row">
          <Link
            as="button"
            :href="route('transaksi.jadwal.edit', { jadwal: row.data.id })"
          >
            <PencilIcon class="h-4" />
          </Link>

          <Link
            as="button"
            :href="
              route('transaksi.jadwal.mahasiswa.index', {
                jadwal: row.data.id,
                ta: selectedTA,
              })
            "
          >
            <UserAddIcon class="ml-2 h-4" />
          </Link>
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"
import Button from "@components/Button"
import { Link } from "@inertiajs/inertia-vue3"
import { Inertia } from "@inertiajs/inertia"
import { ref } from "vue"
import { PencilIcon, UserAddIcon } from "@heroicons/vue/outline"

const props = defineProps({
  jadwals: Object,
  tahunAkademiks: Array,
  selectedTahunAkademik: {
    type: Number,
    default: null,
  },
})

const columns = [
  {
    key: "matakuliah_kode",
    label: "Kode MK",
  },
  {
    key: "matakuliah_nama",
    label: "Nama MK",
    sortable: true,
  },
  {
    key: "ruangan_nama",
    label: "Ruangan",
    sortable: true,
  },
  {
    key: "local",
    label: "Local",
    sortable: true,
  },
  {
    key: "hari",
    label: "Hari, Jam",
    sortable: true,
  },
  {
    key: "kurikulum_nama",
    label: "Kurikulum",
    sortable: true,
  },
]

const selectedTA = ref(props.selectedTahunAkademik)

const onTahunAjaranChange = (ta) => {
  const filter = { ta: selectedTA.value, ...route().params }
  filter.ta = selectedTA.value

  ta &&
    Inertia.visit(route("transaksi.jadwal.index", filter), {
      only: ["jadwals", "selectedTahunAkademik"],
      preserveScroll: true,
      preserveState: true,
    })
}
</script>

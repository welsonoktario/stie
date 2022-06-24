<template>
  <AppLayout>
    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
      <p class="text-xs md:text-sm">Jadwal / Daftar Jadwal</p>

      <div class="inline-flex justify-between my-3 w-full items-center">
        <div>
          <strong
            class="whitespace-nowrap align-middle text-sm md:text-lg content-middle"
          >Daftar Jadwal</strong>

          <select
            id="tahun_ajaran"
            v-model="selectedTA"
            name="tahun_ajarans"
            class="ml-2 pl-2 pr-8 text-sm bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            @change="onTahunAjaranChange(selectedTA)"
          >
            <option :value="null" selected>Pilih tahun akademik</option>
            <option
              v-for="ta in tahunAkademiks"
              :key="ta.id"
              :value="ta.id"
              :selected="ta.aktif"
            >{{ ta.tahun_ajaran }}</option>
          </select>


          <select
            id="tahun_ajaran"
            v-model="selectedKur"
            name="tahun_ajarans"
            class="ml-2 pl-2 pr-8 text-sm bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            @change="onKurikulumChange(selectedKur)"
          >
            <option :value="null" :key="null" disabled selected>Pilih Kurikulum Aktif</option>
            <option :key="0" :value="0">Semua</option>
            <option
              v-for="k in kurikulums"
              :key="k.id"
              :value="k.id"
              :selected="selectedKur"
            >{{ k.nama }}</option>

          </select>

        </div>

        <LinkButton :href="route('transaksi.jadwal.create', { ta: selectedTA })">Tambah Jadwal</LinkButton>
      </div>

      <DataTable :data="jadwals" :columns="columns">
        <template #row(hari)="row">
          <span>{{ `${row.data.hari}, ${row.data.jam}` }}</span>
        </template>

        <template #actions="row">
          <NavLink :href="route('transaksi.jadwal.edit', { jadwal: row.data.id })">
            <PencilIcon class="h-4" />
          </NavLink>

          <NavLink
            :href="
              route('transaksi.jadwal.mahasiswa.index', {
                jadwal: row.data.id,
                ta: selectedTA,
              })
            "
          >
            <UserAddIcon class="ml-2 h-4" />
          </NavLink>
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"
import NavLink from "@components/NavLink"
import LinkButton from "@components/LinkButton"
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
  selectedKurikulum: {
    type: Number,
    default: null,
  },
  kurikulums: Object,
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
    key: "semester",
    label: "SMT",
    sortable: true,
  },
  {
    key: "kurikulum_nama",
    label: "Kurikulum",
    sortable: true,
  },
]

const selectedTA = ref(props.selectedTahunAkademik)
const selectedKur = ref(props.selectedKurikulum)

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


const onKurikulumChange = (kurikulum) => {
  console.log(selectedKur.value)
  const filter = { kur: selectedKur.value, ...route().params }
  filter.kur = selectedKur.value


    Inertia.visit(route("transaksi.jadwal.index", filter), {
      only: ["jadwals", "selectedKur"],
      preserveScroll: true,
      preserveState: true,
    })
  // console.log(selectedKur.value)
}
</script>

<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs md:text-sm">Jadwal / Daftar Jadwal</p>

      <div class="my-3 inline-flex w-full items-center justify-between">
        <div>
          <strong
            class="content-middle whitespace-nowrap align-middle text-sm md:text-lg"
            >Daftar Jadwal</strong
          >

          <select
            id="tahun_ajaran"
            v-model="selectedTA"
            name="tahun_ajarans"
            class="ml-2 rounded-md border-none bg-zinc-100 pl-2 pr-8 text-sm focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
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

          <select
            id="tahun_ajaran"
            v-model="selectedKur"
            name="tahun_ajarans"
            class="ml-2 rounded-md border-none bg-zinc-100 pl-2 pr-8 text-sm focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            @change="onKurikulumChange(selectedKur)"
          >
            <option :key="null" :value="null" disabled selected>
              Pilih Kurikulum Aktif
            </option>
            <option :key="0" :value="0">Semua</option>
            <option
              v-for="k in kurikulums"
              :key="k.id"
              :value="k.id"
              :selected="selectedKur"
            >
              {{ k.nama }}
            </option>
          </select>
        </div>

        <LinkButton :href="route('transaksi.jadwal.create', { ta: selectedTA })"
          >Tambah Jadwal</LinkButton
        >
      </div>

      <DataTable :data="jadwals" :columns="columns">
        <template #row(hari)="row">
          <span>{{ `${row.data.hari}, ${row.data.jam}` }}</span>
        </template>

        <template #actions="row">
          <div class="inline-flex items-center gap-4">
            <NavLink
              :href="route('transaksi.jadwal.edit', { jadwal: row.data.id })"
            >
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
              <UserAddIcon class="h-4" />
            </NavLink>

            <Popover class="relative">
              <PopoverButton>
                <PrinterIcon class="h-4" aria-hidden="true" />
              </PopoverButton>

              <PopoverPanel
                class="absolute"
                :class="{
                  '-right-2 top-6 z-10': row.index <= 6,
                  '-right-2 bottom-6 z-10': row.index > 6,
                }"
              >
                <div
                  class="grid justify-center gap-2 rounded-md bg-zinc-50 p-2 dark:bg-zinc-600"
                >
                  <NavLink
                    class="w-full whitespace-nowrap"
                    :href="
                      route('transaksi.jadwal.print', {
                        jadwal: row.data.id,
                        tipe: 'H',
                      })
                    "
                  >
                    Absensi Harian
                  </NavLink>
                  <NavLink
                    class="w-full whitespace-nowrap"
                    :href="
                      route('transaksi.jadwal.print', {
                        jadwal: row.data.id,
                        tipe: 'A-UTS',
                      })
                    "
                  >
                    Absensi UTS
                  </NavLink>
                  <NavLink
                    class="w-full whitespace-nowrap"
                    :href="
                      route('transaksi.jadwal.print', {
                        jadwal: row.data.id,
                        tipe: 'A-UAS',
                      })
                    "
                  >
                    Absensi UAS
                  </NavLink>
                  <NavLink
                    class="w-full whitespace-nowrap"
                    :href="
                      route('transaksi.jadwal.print', {
                        jadwal: row.data.id,
                        tipe: 'N-UTS',
                      })
                    "
                  >
                    Nilai UTS
                  </NavLink>
                  <NavLink
                    class="w-full whitespace-nowrap"
                    :href="
                      route('transaksi.jadwal.print', {
                        jadwal: row.data.id,
                        tipe: 'N-UAS',
                      })
                    "
                  >
                    Nilai UAS
                  </NavLink>
                </div>
              </PopoverPanel>
            </Popover>
          </div>
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
import { PencilIcon, UserAddIcon, PrinterIcon } from "@heroicons/vue/outline"
import { Popover, PopoverPanel, PopoverButton } from "@headlessui/vue"

const props = defineProps({
  jadwals: {
    type: Object,
    default: null,
  },
  tahunAkademiks: {
    type: Array,
    default: null,
  },
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

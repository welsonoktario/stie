<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Ujian / {{ tipe }}</p>

      <div class="inline-flex justify-between my-3 w-full items-center">
        <div>
          <strong
            class="whitespace-nowrap align-middle text-sm md:text-lg content-middle"
            >Daftar Nahasiswa</strong
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

        <template v-show="tipe == 'UTS'" #row(cicilan)="row">
          <CheckIcon v-if="row.data.cicilan" class="text-teal-500 h-4" />
          <XIcon v-else class="text-red-500 h-4" />
        </template>

        <template #actions="row">
          <a
            target="_blank"
            :href="
              route('transaksi.ujian.print', {
                mahasiswa: row.data.npm,
                ta: selectedTA,
                tipe,
              })
            "
          >
            <PrinterIcon class="h-4" />
          </a>
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"
import { Inertia } from "@inertiajs/inertia"
import { ref, watch } from "vue"
import { CheckIcon, PrinterIcon, XIcon } from "@heroicons/vue/outline"
import { computed } from "vue"

const props = defineProps({
  tipe: String,
  mahasiswas: Object,
  tahunAkademiks: Array,
  selectedTahunAkademik: {
    type: Object,
    default: "-",
  },
})

const selectedTA = ref(props.selectedTahunAkademik.id)
const selectedTipe = computed(() => props.tipe)
const columns = ref([
  {
    key: "nama",
    label: "Nama",
  },
  {
    key: "npm",
    label: "NPM",
  },
  {
    key: "jurusan",
    label: "Jurusan",
  },
  {
    key: "cicilan",
    label: `Bayar ${selectedTipe.value}`,
  },
])

watch(
  selectedTipe,
  async (newTipe) => (columns.value.at(-1).label = `Bayar ${newTipe}`)
)

const onTahunAjaranChange = (ta) => {
  const filter = { ta: selectedTA.value, ...route().params }
  filter.ta = selectedTA.value

  ta != "-" &&
    Inertia.visit(route("transaksi.ujian.index", filter), {
      preserveScroll: true,
      preserveState: true,
    })
}
</script>

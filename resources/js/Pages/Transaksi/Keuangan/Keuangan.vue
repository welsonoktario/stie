<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Mahasiswa / Mahasiswa Reguler</div> -->
      <p class="text-xs md:text-sm">Keuangan / Daftar Mahasiswa</p>

      <!-- Belum bisa ubah id dosen dan staff -->

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
            >Daftar Mahasiswa</strong
          >
        </span>
      </div>

      
      <div class="inline-flex items-center text-sm mb-1">
        <label for="tahun_ajarans">Tahun Akademik</label>
        <select
          name="tahun_ajarans"
          id="tahun_ajaran"
          class="ml-2 pl-2 pr-6 text-sm bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
          v-model="selectedTahunAjaran"
          @change="loadTahunAjaran(selectedTahunAjaran)"
        >
          <option 
            v-for="ta in tahun_ajarans"
            :key="ta.id" 
            :value="ta.id"
            :selected="ta.aktif">{{ta.tahun_ajaran}}</option>
        </select>
      </div>

      <DataTable :data="mahasiswas" :columns="columns">
        <template #row(jurusan)="row">
          <span class="capitalize">{{ row.data.jurusan ?? "-" }}</span>
        </template>

        <template #actions="row">
          <Link
            as="button"
            :href="route('master.mahasiswa-reguler.edit', row.data.npm)"
            >Edit</Link
          >
        </template>
        <template #row(cicilan_1)="row">
          <div class="text-red-500" v-if="row.data.cicilan_2 == null"><p class="text-xl font-extrabold">-</p></div>
          <div v-else>v</div>
        </template>
        <template #row(cicilan_2)="row">
          <div class="text-red-500" v-if="row.data.cicilan_2 == null"><p class="text-xl font-extrabold">-</p></div>
          <div v-else>v</div>
        </template>
        <template #row(cicilan_3)="row">
          <div class="text-red-500" v-if="row.data.cicilan_2 == null"><p class="text-xl font-extrabold">-</p></div>
          <div v-else>v</div>
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App"
import DataTable from "@components/DataTable"
import Button from "@components/Button"

import { Link } from "@inertiajs/inertia-vue3"
import { Inertia } from '@inertiajs/inertia'
import { ref } from 'vue'

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
    }
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
        label: "C1",
        sortable: true,
      },
      {
        key: "cicilan_2",
        label: "C2",
        sortable: true,
      },
      {
        key: "cicilan_3",
        label: "C2",
        sortable: true,
      },
      {
        key: "jurusan",
        label: "Jurusan",
        sortable: true,
      },
    ]

    const selectedTahunAjaran = ref(
      props.tahun_ajarans.find(o => o.aktif === true).id
    );

    const loadTahunAjaran = (id) => {
      // alert(id)
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

<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm">Nilai / Detail Nilai</p>

      <p class="my-3 text-sm md:text-lg font-bold">Detail Nilai</p>

      <div>
        <p>
          NPM: <span>{{ mahasiswa.npm }}</span>
        </p>

        <p>
          Nama: <span>{{ mahasiswa.user.name }}</span>
        </p>

        <p>
          Jurusan: <span>{{ mahasiswa.jurusan?.nama ?? "-" }}</span>
        </p>
      </div>

      <div class="inline-flex justify-between mb-3 mt-6 w-full items-center">
        <div class="inline-flex">
          <p
            class="whitespace-nowrap align-middle text-sm md:text-lg content-middle font-bold my-auto"
          >
            Detail Nilai
          </p>
          <Select
            class="ml-2 text-sm"
            :placeholder="'Pilih tahun akademik'"
            :options="tahunAkademiks"
            v-model="selectedTahunAkademik"
          >
            <template #option="option">
              <option :value="option.data.id">
                {{ option.data.tahun_ajaran }}
              </option>
            </template>
          </Select>
        </div>

        <Button type="button">
          <Link
            :href="
              route('transaksi.nilai.create', { ta: selectedTahunAkademik })
            "
          >
            Tambah Nilai
          </Link>
        </Button>
      </div>

      <table class="table-auto w-full">
        <thead>
          <tr>
            <th class="font-semibold text-left py-2 px-4">Kode MK</th>
            <th class="font-semibold text-left py-2 px-4">Matakuliah</th>
            <th class="font-semibold text-left py-2 px-4">SKS</th>
            <th class="font-semibold text-left py-2 px-4">Nilai</th>
            <th class="font-semibold text-left py-2 px-4">NISBI</th>
            <th class="font-semibold text-left py-2 px-4"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="jadwal in mahasiswa.jadwals" class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal">
            <td class="px-4 py-2">{{ jadwal.matakuliah.kode_matakuliah }}</td>
            <td class="px-4 py-2">{{ jadwal.matakuliah.nama_matakuliah }}</td>
            <td class="px-4 py-2">{{ jadwal.matakuliah.sks }}</td>
            <td class="px-4 py-2">&#45</td>
            <td class="px-4 py-2">&#45</td>
            <td class="px-4 py-2"><PencilIcon class="h-4" /></td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@layouts/App"
import Button from "@/Components/Button"
import Select from "@/Components/Select"
import { Link } from "@inertiajs/inertia-vue3"
import { PencilIcon } from '@heroicons/vue/outline'

const props = defineProps({
  tahunAkademiks: Array,
  selectedTahunAkademik: Number | String,
  mahasiswa: Object,
})
</script>

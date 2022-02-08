<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Mahasiswa / Mahasiswa Reguler</div> -->
      <p class="text-xs md:text-sm">Mahasiswa / Mahasiswa Konversi</p>

      <!-- Belum bisa ubah id dosen dan staff -->
      
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong class="whitespace-nowrap capitalize text-sm md:text-lg content-middle">Daftar Mahasiswa Konversi</strong>
        </span>
        <Link 
          :href="route('master.mahasiswa-konversi.create')" 
          method="get" 
          as="button" 
          type="link"
          class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
          >
          Tambah Mahasiswa
        </Link>

      </div>

      <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      NPM
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Nama
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Jurusan
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Status Mahasiswa
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                      <!-- <span class="sr-only">Edit</span>
                      --+ -->
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="mahasiswa in mahasiswas" :key="mahasiswa.npm">

                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">
                        {{mahasiswa.npm}}
                      </div>
                    </td>
                      
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{mahasiswa.user.name}}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap  text-sm text-gray-500">
                      {{mahasiswa.jurusan != null ? mahasiswa.jurusan.nama : '-'}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        {{mahasiswa.status_mahasiswa}}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <Link :href="route('master.mahasiswa-konversi.show', mahasiswa.npm)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>




    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App.vue"

import { Link } from "@inertiajs/inertia-vue3"

export default {
  components: {
    AppLayout,
    Link
  },
  props: {
    mahasiswas: {
      type: Object,
      default: null,
    },
  },
  setup(props){
    
    return {
    }
  }

}
</script>

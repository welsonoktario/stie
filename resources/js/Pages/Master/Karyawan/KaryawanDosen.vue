<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Dosen</div> -->
      <p class="text-xs md:text-sm">Karyawan / Dosen</p>

      <!-- Belum bisa ubah id dosen dan staff -->
      
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong class="whitespace-nowrap capitalize text-sm md:text-lg content-middle">Daftar Dosen</strong>
        </span>
        <Link 
          :href="route('dosen.create')" 
          method="get" 
          as="button" 
          type="link"
          class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
          >
          Tambah Dosen
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
                      ID Dosen
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Nama
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Konsentrasi
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Tipe ID
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Jurusan
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Status
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                      <!-- <span class="sr-only">Edit</span>
                      --+ -->
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="dosen in dosens" :key="dosen.id">

                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">{{ dosen.id }}</div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">{{ dosen.staff.user.name }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap  text-sm text-gray-500">
                      {{ dosen.konsentrasi }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap  text-sm text-gray-500">
                      {{ dosen.tipe_id }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                      {{ dosen.jurusan != null ? dosen.jurusan.nama : '-'   }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                        {{dosen.staff.status_karyawan}}
                      </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <Link :href="route('dosen.show', dosen.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
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
    karyawanss: {
      type: Object
    },
    dosens: {
      type: Object,
      default: null
    }
  },
  setup(props){

    const karyawans = [
      {
        name: 'Jane Cooper',
        title: 'Regional Paradigm Technician',
        department: 'Optimization',
        role: 'Admin',
        email: 'jane.cooper@example.com',
        image:
          'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=4&w=256&h=256&q=60',
      },
    ]
    return {
      karyawans
    }
  }

}
</script>

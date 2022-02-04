<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >

      <p class="text-xs md:text-sm">Akademik / Ruangan</p>
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong class="whitespace-nowrap capitalize text-sm md:text-lg content-middle">Daftar Ruangan</strong>
        </span>


        <Link
          :href="route('ruangan.create')"
          method="get"
          as="button"
          type="link"
          class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
          >
          Tambah Ruangan
        </Link>

      </div>

      <!-- table seadanya -->


      <div class="flex flex-col">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      No
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Ruangan
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                      <!-- <span class="sr-only">Edit</span>
                      --+ -->
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(ruangan, index) in ruangans" :key="ruangan.id">

                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center">
                        <div class="ml-0">
                          <div class="text-sm font-medium text-gray-900">
                            <!-- EKNM -->
                            {{index+1}}
                          </div>
                        </div>
                      </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">{{ruangan.nama_ruangan}}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <Link :href="route('ruangan.show', ruangan.id)" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
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
import { Link } from '@inertiajs/inertia-vue3'

export default {
  components: {
    AppLayout,
    Link,
  },
  props: {
    jurusans: {
      type: Object,
      default: null,
    },
    ruangans: {
      type: Object,
      default: null,
    }
  },
  setup(props){

    return {

    }
  }
}
</script>

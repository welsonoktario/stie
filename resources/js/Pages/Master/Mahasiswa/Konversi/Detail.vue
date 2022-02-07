<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Mahasiswa / Mahasiswa Konversi /
        <span v-if="route().current('master.mahasiswa-konversi.create')">Tambah</span>
        <span v-else>Ubah</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span v-if="route().current('master.mahasiswa-konversi.create')">Tambah</span>
            <span v-else>Ubah</span>
            Mahasiswa Konversi</strong
          >
        </span>
      </div>


      <form @submit.prevent="submit(route().current())">
        <div class="flex sm:space-x-3 sm:flex-row flex-col">

          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="npm">
              NPM / NIM <span class="text-red-500">*</span>
            </label>
            <Input
              v-model="form.npm"
              class="w-full"
              id="npm"
              type="text"
              placeholder="NIM / NPM"
              required
            ></Input>
          </div>

          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nik">
              NIK
            </label>
            <Input
              v-model="form.nik"
              class="w-full"
              id="nik"
              type="text"
              placeholder="NIK"
            ></Input>
          </div>
        </div>

        <div class="flex sm:space-x-3 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nama">
              Nama <span class="text-red-500">*</span>
            </label>
            <Input
              v-model="form.name"
              class="w-full"
              id="nama"
              type="text"
              placeholder="Nama"
              required
            ></Input>
          </div>

          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="email">
              Email
            </label>
            <Input
              v-model="form.email"
              class="w-full"
              id="email"
              type="text"
              placeholder="Email"
            ></Input>
          </div>
        </div>

        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="jurusan">
            Jurusan
          </label>
          <select 
            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
            id="jurusan"
            v-model="form.jurusan">
            <option value="-">-</option>
            <option v-for="jurusan in jurusans" :key="jurusan.id" :value="jurusan.id.toString()">{{jurusan.nama}} - {{jurusan.kode_jurusan}}</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="dosen">
            Dosen Wali
          </label>
          <select 
            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
            id="dosen"
            v-model="form.dosen">
            <option value="-">-</option>
            <option v-for="dosen in dosens" :key="dosen.id" :value="dosen.id.toString()">{{dosen.staff.user.name}}</option>
          </select>
        </div>

        <div class="flex justify-between">
          <Button class="px-10">Simpan</Button>
          <Link
            v-if="!route().current('master.mahasiswa-konversi.create')"
            @click="remove()"
            class="text-red-500"
            >Hapus Data Mahasiswa Konversi</Link
          >
        </div>
      </form>

      <!-- list matakuliah konversi -->
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong class="whitespace-nowrap capitalize text-sm md:text-lg content-middle">Matakuliah Konversi</strong>
        </span>
        <Link 
          href="#" 
          method="get" 
          as="button" 
          type="link"
          class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
          >
          Tambah Matakuliah Konversi
        </Link>

      </div>
      <div class="flex flex-col mt-6">
        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
          <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Kode MK Lama
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Nama MK Lama
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      SKS
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Kode MK Baru
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Nama MK Baru
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      SKS
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                      Nilai
                    </th>
                    <th scope="col" class="relative px-6 py-3">
                      <!-- <span class="sr-only">Edit</span>
                      --+ -->
                    </th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="matakuliah in matakuliahs" :key="matakuliah.id">

                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-500">
                        {{matakuliah.kode_matakuliah}}
                      </div>
                    </td>
                      
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="text-sm text-gray-900">
                        {{matakuliah.nama_matakuliah}}
                      </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap  text-sm text-gray-500">
                      {{matakuliah.sks_matakuliah}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap  text-sm text-gray-500">
                      {{matakuliah.matakuliah.kode_matakuliah}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap  text-sm text-gray-500">
                      {{matakuliah.matakuliah.nama_matakuliah}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap  text-sm text-gray-500">
                      {{matakuliah.matakuliah.sks}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap  text-sm text-gray-500">
                      {{matakuliah.nilai_matakuliah}}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                      <Link href="#" class="text-indigo-600 hover:text-indigo-900">Edit</Link>
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

import Input from "@components/Input.vue"
import Button from "@components/Button.vue"

import { Link } from "@inertiajs/inertia-vue3"

import util from "@/util"

import { reactive, ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
export default {
  components: {
    AppLayout,
    Link,
    Input,
    Button,
  },
  props: {
    dosens: {
      type: Object,
      default: null,
    },
    jurusans: {
      type: Object,
      default: null,
    },
    mahasiswa: {
      type: Object,
      default: null,
    },
    matakuliahs: {
      type: Object,
      default: null,
    }

  },
  setup(props) {
    const form = reactive({
      // user data
      email: props.mahasiswa == null ? null : props.mahasiswa.user.email,
      name: props.mahasiswa == null ? null : props.mahasiswa.user.name,
      nik: props.mahasiswa == null ? null : props.mahasiswa.user.nik,

      // mahasiswa data
      npm: props.mahasiswa == null ? null : props.mahasiswa.npm,
      dosen: props.mahasiswa == null ? '-' : (props.mahasiswa.dosen == null ? '-' : props.mahasiswa.dosen.id),
      jurusan: props.mahasiswa == null ? '-' : (props.mahasiswa.jurusan == null ? '-' : props.mahasiswa .jurusan.id),
      
    })

    function submit(curRoute) {
      if (curRoute === "master.mahasiswa-konversi.create") {
        // alert(util.isEmptyObject(props.staff))
        // alert(props.staff == null ? 'null bro' : 'ada bro')
        Inertia.post(route("master.mahasiswa-konversi.store"), form)
      } else {
        Inertia.put(route("master.mahasiswa-konversi.update", props.mahasiswa.npm), form)
      }
    }

    function remove() {
      // alert(props.staff.nip);
      Inertia.delete(route("master.mahasiswa-konversi.destroy", props.mahasiswa.npm))
    }
    return {
      form,
      submit,
      remove,
    }
  },
}
</script>

<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Mahasiswa / Mahasiswa Reguler /
        <span v-if="route().current('mahasiswa-reguler.create')">Tambah</span>
        <span v-else>Ubah</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span v-if="route().current('mahasiswa-reguler.create')">Tambah</span>
            <span v-else>Ubah</span>
            Mahasiswa Reguler</strong
          >
        </span>
      </div>


      <form @submit.prevent="submit(route().current())">
        <div class="mb-3">
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

        <div class="mb-3">
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

        <div class="mb-3">
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

        <div class="mb-3">
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
            v-if="!route().current('mahasiswa-reguler.create')"
            @click="remove()"
            class="text-red-500"
            >Hapus Data Mahasiswa Reguler</Link
          >
        </div>


      </form>


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
      if (curRoute === "mahasiswa-reguler.create") {
        // alert(util.isEmptyObject(props.staff))
        // alert(props.staff == null ? 'null bro' : 'ada bro')
        Inertia.post("/master/mahasiswa-reguler", form)
      } else {
        Inertia.put(route("mahasiswa-reguler.update", props.mahasiswa.npm), form)
      }
    }

    function remove() {
      // alert(props.staff.nip);
      Inertia.delete(route("mahasiswa-reguler.destroy", props.mahasiswa.npm))
    }
    return {
      form,
      submit,
      remove,
    }
  },
}
</script>

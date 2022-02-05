<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Karyawan / Dosen /
        <span v-if="route().current('dosen.create')">Tambah</span>
        <span v-else>Ubah</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span v-if="route().current('dosen.create')">Tambah</span>
            <span v-else>Ubah</span>
            Dosen</strong
          >
        </span>
      </div>


      <form @submit.prevent="submit(route().current())">
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="id_karyawan">
            ID Karyawan <i> (Nomor Induk Karyawan)</i> <span class="text-red-500">*</span>
          </label>
          <Input
            v-model="form.id_karyawan"
            class="w-full"
            id="id_karyawan"
            type="text"
            placeholder="ID"
          ></Input>
        </div>

        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="id_dosen"> 
            ID Dosen <span class="text-red-500">*</span>
          </label>
          <Input
            v-model="form.id_dosen"
            class="w-full"
            id="ID Dosen"
            type="text"
            placeholder="id_dosen"
          ></Input>
        </div>

        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="tipe_id">
            Tipe ID Dosen <span class="text-red-500">*</span>
          </label>
          <select 
            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
            id="tipe_id"
            v-model="form.tipe_id">
            <option value="NIDN">NIDN</option>
            <option value="NIDK">NIDK</option>
            <option value="NUPN">NUPN</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="jabatan_akademik">
            Jabatan Akademik <span class="text-red-500">*</span>
          </label>
          <select 
            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
            id="jabatan_akademik"
            v-model="form.jabatan_akademik">
            <option value="Lektor">Lektor</option>
            <option value="Asisten Ahli">Asisten Ahli</option>
            <option value="Tenaga Pengajar">Tenaga Pengajar</option>
          </select>
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
            Nama
          </label>
          <Input
            v-model="form.name"
            class="w-full"
            id="nama"
            type="text"
            placeholder="Nama"
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
            Jurusan / Homebase
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
          <label class="block text-gray-500 text-sm font-bold mb-2" for="konsentrasi">
            Konsentrasi
          </label>
          <Input
            v-model="form.konsentrasi"
            class="w-full"
            id="konsentrasi"
            type="text"
            placeholder="Konsentrasi"
          ></Input>
        </div>

        <div class="flex justify-between">
          <Button class="px-10">Simpan</Button>
          <Link
            v-if="!route().current('dosen.create')"
            @click="remove()"
            class="text-red-500"
            >Hapus Data Dosen</Link
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
    staff: {
      type: Object,
      default: null,
    },
    dosen: {
      type: Object,
      default: null,
    },
    jurusans: {
      type: Object,
      default: null,
    },
  },
  setup(props) {
    const form = reactive({
      // user data
      email: props.dosen == null ? null : props.dosen.staff.user.email,
      name: props.dosen == null ? null : props.dosen.staff.user.name,
      nik: props.dosen == null ? null : props.dosen.staff.user.nik,

      // karyawan data (mandatory)
      id_karyawan: props.dosen == null ? null : props.dosen.staff.id,

      // dosen primary data (mandatory)
      id_dosen: props.dosen == null ? null : props.dosen.id,
      tipe_id: props.dosen == null ? 'NIDN' : props.dosen.tipe_id,
      jabatan_akademik: props.dosen == null ? 'Tenaga Pengajar' : props.dosen.jabatan_akademik,
      jurusan: props.dosen == null ? '-' : (props.dosen.jurusan == null ? '-' : props.dosen.jurusan.id),
      konsentrasi: props.dosen == null ? '-' : props.dosen.konsentrasi,
      
    })

    function submit(curRoute) {
      if (curRoute === "dosen.create") {
        // alert(util.isEmptyObject(props.staff))
        // alert(props.staff == null ? 'null bro' : 'ada bro')
        Inertia.post("/master/dosen", form)
      } else {
        Inertia.put(route("dosen.update", props.dosen.id), form)
      }
    }

    function remove() {
      // alert(props.staff.nip);
      Inertia.delete(route("dosen.destroy", props.dosen.id))
    }
    return {
      form,
      submit,
      remove,
    }
  },
}
</script>

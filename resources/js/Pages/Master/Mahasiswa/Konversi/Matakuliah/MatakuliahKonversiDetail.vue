<template>
  <AppLayout>
    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
      <p class="text-xs md:text-sm text-slate-500">
        Mahasiswa / Mahasiswa Konversi / Matakuliah Konversi
        <span
          v-if="route().current('master.mahasiswa-konversi.matakuliah.create')"
        >Tambah</span>
        <span v-else>Ubah</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="flex justify-between my-3 sm:gap-2 md:gap-0 items-center">
        <span>
          <strong class="whitespace-nowrap capitalize text-sm md:text-lg content-middle">
            <span v-if="route().current('master.mahasiswa-konversi.matakuliah.create')">Tambah</span>
            <span v-else>Ubah</span>
            Matakuliah Konversi
          </strong>
        </span>
      </div>

      <form @submit.prevent="submit(route().current())">
        <div class="flex sm:space-x-3 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="kode_matakuliah"
            >Kode Matakuliah</label>
            <Input
              id="kode_matakuliah"
              v-model="form.kode_matakuliah"
              class="w-full"
              type="text"
              placeholder="Kode Matakuliah"
            ></Input>
          </div>

          <div class="mb-3 w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="nama_matakuliah"
            >Nama Matakuliah</label>
            <Input
              id="nama_matakuliah"
              v-model="form.nama_matakuliah"
              class="w-full"
              type="text"
              placeholder="Nama Matakuliah"
            ></Input>
          </div>
        </div>

        <div class="flex sm:space-x-3 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="sks">SKS</label>
            <Input id="sks" v-model="form.sks" class="w-full" type="text" placeholder="SKS"></Input>
          </div>

          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nilai">Nilai</label>
            <Input id="nilai" v-model="form.nilai" class="w-full" type="text" placeholder="Nilai"></Input>
          </div>
        </div>

        <div class="mb-3">
          <label
            class="block text-gray-500 text-sm font-bold mb-2"
            for="matakuliah"
          >Matakuliah yang Setara</label>
          <select
            id="matakuliah"
            v-model="form.matakuliah_baru_id"
            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          >
            <option
              v-for="matakuliah in matakuliahs"
              :key="matakuliah.id"
              :value="matakuliah.id.toString()"
            >{{ matakuliah.nama_matakuliah }} - {{ matakuliah.kode_matakuliah }} - {{ matakuliah.kurikulum.nama }}</option>
          </select>
        </div>
      </form>

      <div class="flex justify-between">
        <div>
          <Button class="px-10" @click="submit(route().current())">Simpan</Button>
        </div>
        <Link
          v-if="!route().current('master.mahasiswa-konversi.matakuliah.create')"
          class="text-red-500"
          @click="remove()"
        >Hapus Data Matakuliah Konversi</Link>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App.vue"

import Input from "@components/Input.vue"
import Button from "@components/Button.vue"

import { Link } from "@inertiajs/inertia-vue3"

import { reactive, ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
import ModalInput from "@/Components/ModalInput.vue"

import {
  ChevronDoubleDownIcon,
  ChevronDoubleUpIcon
} from "@heroicons/vue/outline"

export default {
  components: {
    AppLayout,
    Link,
    Input,
    Button,
    ModalInput,
    ChevronDoubleDownIcon,
    ChevronDoubleUpIcon,
  },
  props: {
    mahasiswa: {
      type: Object,
      default: null,
    },
    matakuliahs: {
      type: Object,
      default: null,
    },
    matakuliah_konversi: {
      type: Object,
      default: null,
    }

  },
  setup(props) {

    const showModalMatakuliah = ref(true)

    const form = reactive({
      // mk lama data
      kode_matakuliah: props.matakuliah_konversi == null ? null : props.matakuliah_konversi.kode_matakuliah,
      nama_matakuliah: props.matakuliah_konversi == null ? null : props.matakuliah_konversi.nama_matakuliah,
      nilai: props.matakuliah_konversi == null ? null : props.matakuliah_konversi.nilai_matakuliah,
      sks: props.matakuliah_konversi == null ? null : props.matakuliah_konversi.sks_matakuliah,

      // mk baru
      matakuliah_baru_id: props.matakuliah_konversi == null ? null : props.matakuliah_konversi.matakuliah_id,
    })

    const showMatakuliah = ref(false)

    function submit(curRoute) {
      if (curRoute === "master.mahasiswa-konversi.matakuliah.create") {
        // alert(util.isEmptyObject(props.staff))
        // alert(props.staff == null ? 'null bro' : 'ada bro')
        Inertia.post(route("master.mahasiswa-konversi.matakuliah.store", { mahasiswa_konversi_id: props.mahasiswa.npm }), form)
      } else {
        Inertia.put(route("master.mahasiswa-konversi.matakuliah.update", {
          mahasiswa_konversi_id: props.mahasiswa.npm,
          matakuliah_konversi_id: props.matakuliah_konversi.id
        }, props.mahasiswa.npm), form)
      }
    }

    function remove() {
      // alert(props.staff.nip);
      Inertia.delete(route("master.mahasiswa-konversi.matakuliah.destroy", {
        mahasiswa_konversi_id: props.mahasiswa.npm,
        matakuliah_konversi_id: props.matakuliah_konversi.id
      }, props.mahasiswa.npm))
    }

    return {
      showModalMatakuliah,
      form,
      submit,
      remove,
      showMatakuliah
    }
  },
}
</script>

<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs text-slate-500 md:text-sm">
        Mahasiswa / Mahasiswa Konversi / Matakuliah Konversi
        <span
          v-if="route().current('master.mahasiswa-konversi.matakuliah.create')"
          >Tambah</span
        >
        <span v-else>Ubah</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="my-3 flex items-center justify-between sm:gap-2 md:gap-0">
        <span>
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
          >
            <span
              v-if="
                route().current('master.mahasiswa-konversi.matakuliah.create')
              "
              >Tambah</span
            >
            <span v-else>Ubah</span>
            Matakuliah Konversi
          </strong>
        </span>
      </div>

      <form @submit.prevent="submit(route().current())">
        <div class="flex flex-col sm:flex-row sm:space-x-3">
          <div class="mb-3 w-full">
            <label
              class="mb-2 block text-sm font-bold text-gray-500"
              for="kode_matakuliah"
              >Kode Matakuliah Asal <span class="text-sm text-red-500 font-medium">*</span></label
            >
            <Input
              id="kode_matakuliah"
              v-model="form.kode_matakuliah"
              class="w-full"
              type="text"
              placeholder="Kode Matakuliah"
            ></Input>
            <p class="mt-1 text-sm text-red-500 font-medium" v-if="errors.kode_matakuliah"> {{errors.kode_matakuliah}}</p>
          </div>

          <div class="mb-3 w-full">
            <label
              class="mb-2 block text-sm font-bold text-gray-500"
              for="nama_matakuliah"
              >Nama Matakuliah Asal <span class="text-sm text-red-500 font-medium">*</span></label
            >
            <Input
              id="nama_matakuliah"
              v-model="form.nama_matakuliah"
              class="w-full"
              type="text"
              placeholder="Nama Matakuliah"
            ></Input>
            <p class="mt-1 text-sm text-red-500 font-medium" v-if="errors.nama_matakuliah"> {{errors.nama_matakuliah}}</p>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:space-x-3">
          <div class="mb-3 w-full">
            <label class="mb-2 block text-sm font-bold text-gray-500" for="sks"
              >SKS MK Asal <span class="text-sm text-red-500 font-medium">*</span></label
            >
            <Input
              id="sks"
              v-model="form.sks"
              class="w-full"
              type="number"
              placeholder="SKS"
            ></Input>
            <p class="mt-1 text-sm text-red-500 font-medium" v-if="errors.sks"> {{errors.sks}}</p>

          </div>


          <div class="mb-3 w-full">
            <label
              class="mb-2 block text-sm font-bold text-gray-500"
              for="nilai"
              >Nilai Huruf Diakui <span class="text-sm text-red-500 font-medium">*</span></label
            >

            <select
              id="nilai"
              v-model="form.nilai"
              name="nilai"
              class="w-full rounded-md border-none bg-zinc-100 pl-2 pr-8 text-sm focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            >
              <option value="4" selected>A</option>
              <option value="3">B</option>
              <option value="2">C</option>
              <option value="1">D</option>
              <option value="0">E</option>
            </select>
            <p class="mt-1 text-sm text-red-500 font-medium" v-if="errors.nilai"> {{errors.nilai}}</p>

          </div>

          <div class="mb-3 w-full">
            <label
              class="mb-2 block text-sm font-bold text-gray-500"
              for="nilai"
              >Nilai Indeks Diakui</label
            >
            <Input
              id="nilai"
              v-model="form.nilai"
              class="w-full"
              type="text"
              placeholder="Nilai"
              disabled
            ></Input>
          </div>


        </div>



        <div class="mb-3">
          <label
            class="mb-2 block text-sm font-bold text-gray-500"
            for="matakuliah"
            >Matakuliah yang Setara <span class="text-sm text-red-500 font-medium">*</span></label
          >
          <select
            id="matakuliah"
            v-model="form.matakuliah_baru_id"
            class="w-full rounded-md border-none bg-zinc-100 pl-2 pr-8 text-sm focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
          >
            <option
              v-for="matakuliah in matakuliahs"
              :key="matakuliah.id"
              :value="matakuliah.id.toString()"
            >
              {{ matakuliah.kurikulum.nama }} -
              {{ matakuliah.kode_matakuliah }} -
              {{ matakuliah.nama_matakuliah }}
            </option>
          </select>
          <p class="mt-1 text-sm text-red-500 font-medium" v-if="errors.matakuliah_baru_id"> {{errors.matakuliah_baru_id}}</p>

        </div>


      <div class="flex justify-between">
        <div>
          <Button class="px-10" @click="submit(route().current())"
            >Simpan</Button
          >
        </div>
        <Link
          v-if="!route().current('master.mahasiswa-konversi.matakuliah.create')"
          class="text-red-500"
          @click="remove()"
          >Hapus Data Matakuliah Konversi</Link
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
// import Select from "@components/Select.vue"

import { Link } from "@inertiajs/inertia-vue3"

import { reactive, ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
import ModalInput from "@/Components/ModalInput.vue"

import {
  ChevronDoubleDownIcon,
  ChevronDoubleUpIcon,
} from "@heroicons/vue/outline"
import Select from "@/Components/Select.vue"

export default {
  components: {
    AppLayout,
    Link,
    Input,
    Button,
    ModalInput,
    ChevronDoubleDownIcon,
    ChevronDoubleUpIcon,
    Select
},
  props: {
    errors: Object,
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
    },
  },
  setup(props) {
    const showModalMatakuliah = ref(true)

    const form = reactive({
      // mk lama data
      kode_matakuliah:
        props.matakuliah_konversi == null
          ? null
          : props.matakuliah_konversi.kode_matakuliah,
      nama_matakuliah:
        props.matakuliah_konversi == null
          ? null
          : props.matakuliah_konversi.nama_matakuliah,
      nilai:
        props.matakuliah_konversi == null
          ? null
          : props.matakuliah_konversi.nilai_matakuliah,
      sks:
        props.matakuliah_konversi == null
          ? null
          : props.matakuliah_konversi.sks_matakuliah,

      // mk baru
      matakuliah_baru_id:
        props.matakuliah_konversi == null
          ? null
          : props.matakuliah_konversi.matakuliah_id,
    })

    const showMatakuliah = ref(false)

    function submit(curRoute) {
      if (curRoute === "master.mahasiswa-konversi.matakuliah.create") {
        // alert(util.isEmptyObject(props.staff))
        // alert(props.staff == null ? 'null bro' : 'ada bro')
        Inertia.post(
          route("master.mahasiswa-konversi.matakuliah.store", {
            mahasiswa_konversi_id: props.mahasiswa.npm,
          }),
          form
        )
      } else {
        Inertia.put(
          route(
            "master.mahasiswa-konversi.matakuliah.update",
            {
              mahasiswa_konversi_id: props.mahasiswa.npm,
              matakuliah_konversi_id: props.matakuliah_konversi.id,
            },
            props.mahasiswa.npm
          ),
          form
        )
      }
    }

    function remove() {
      // alert(props.staff.nip);
      Inertia.delete(
        route(
          "master.mahasiswa-konversi.matakuliah.destroy",
          {
            mahasiswa_konversi_id: props.mahasiswa.npm,
            matakuliah_konversi_id: props.matakuliah_konversi.id,
          },
          props.mahasiswa.npm
        )
      )
    }

    return {
      showModalMatakuliah,
      form,
      submit,
      remove,
      showMatakuliah,
    }
  },
}
</script>

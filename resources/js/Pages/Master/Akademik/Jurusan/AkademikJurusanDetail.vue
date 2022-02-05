<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Akademik / Jurusan /
        <span v-if="route().current('jurusan.create')">Tambah</span>
        <span v-else>Ubah</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span v-if="route().current('jurusan.create')">Tambah</span>
            <span v-else>Ubah</span>
            Jurusan</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit(route().current())">
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="kode">
            Kode Jurusan
          </label>
          <Input
            v-model="form.kode_jurusan"
            class="w-full"
            id="kode"
            type="text"
            placeholder="Kode Jurusan"
          ></Input>
        </div>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="nama">
            Nama Jurusan
          </label>
          <Input
            v-model="form.nama"
            class="w-full"
            id="nama"
            type="text"
            placeholder="Nama Jurusan"
          ></Input>
        </div>
        <div class="flex justify-between">
          <Button class="px-10">Simpan</Button>
          <Link v-if="!route().current('jurusan.create')" @click="remove()" class="text-red-500"
            >Hapus Data Jurusan</Link
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
    jurusan: {
      type: Object,
      default: null,
    },
  },
  setup(props) {
    const form = reactive({
      nama: props.jurusan == null ? null : props.jurusan.nama,
      kode_jurusan: props.jurusan == null ? null : props.jurusan.kode_jurusan,
    })

    function submit(curRoute) {
      // alert(curRoute)
      if (curRoute === "jurusan.create") {
        // alert('store')
        Inertia.post(route('jurusan.store', form))
      } else {
        // alert('update')
        Inertia.put(route("jurusan.update", props.jurusan.id), form)
      }
    }
    function remove() {
      // alert(props.staff.nip);
      Inertia.delete(route("jurusan.destroy", props.jurusan.id))
    }
    return {
      form,
      submit,
      remove,
    }
  },
}
</script>

<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Akademik / Kurikulum /
        <span v-if="route().current('master.kurikulum.create')">Tambah</span>
        <span v-else>Ubah</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span v-if="route().current('master.kurikulum.create')">Tambah</span>
            <span v-else>Ubah</span>
            Kurikulum</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit(route().current())">
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="nama">
            Nama Kurikulum
          </label>
          <Input
            v-model="form.nama"
            class="w-full"
            id="nama"
            type="text"
            placeholder="Nama Kurikulum"
          ></Input>
        </div>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="status">
            Status
          </label>
          <select
            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            id="status"
            v-model="form.status">
            <option value="1">Aktif</option>
            <option value="0">Tidak Aktif</option>
          </select>
        </div>
        <div class="flex justify-between">
          <Button class="px-10">Simpan</Button>
          <Link v-if="!route().current('master.kurikulum.create')" @click="remove()" class="text-red-500"
            >Hapus Kurikulum</Link
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
    kurikulum: {
      type: Object,
      default: null,
    },
  },
  setup(props) {
    const form = reactive({
      nama: props.kurikulum == null ? null : props.kurikulum.nama,
      status: props.kurikulum == null ? "1" : props.kurikulum.aktif,
    })

    function submit(curRoute) {
      // alert(curRoute)
      if (curRoute === "master.kurikulum.create") {
        // alert('store')
        Inertia.post(route('master.kurikulum.store', form))
      } else {
        // alert('update')
        Inertia.put(route("master.kurikulum.update", props.kurikulum.id), form)
      }
    }
    function remove() {
      // alert(props.staff.nip);kurikulum
      Inertia.delete(route("master.kurikulum.destroy", props.kurikulum.id))
    }
    return {
      form,
      submit,
      remove,
    }
  },
}
</script>
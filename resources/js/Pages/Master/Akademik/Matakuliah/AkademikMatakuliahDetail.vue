<template>
  <AppLayout>
    <div
      class="bg-zinc-50 dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm text-slate-500">
        Akademik / Matakuliah /
        <span v-if="route().current('master.matakuliah.create')">Tambah</span>
        <span v-else>Ubah</span>
      </p>

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span v-if="route().current('master.matakuliah.create')"
              >Tambah</span
            >
            <span v-else>Ubah</span>
            Matakuliah</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit(route().current())">
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="kode">
            Kode Matakuliah
          </label>
          <Input
            v-model="form.kode_matakuliah"
            class="w-full"
            id="kode"
            type="text"
            placeholder="Kode Matakuliah"
            autocomplete="off"
            maxlength="10"
          ></Input>
          <div v-if="form.errors.kode_matakuliah" class="text-red-500">
            {{ form.errors.kode_matakuliah }}
          </div>
        </div>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="nama">
            Nama Matakuliah
          </label>
          <Input
            v-model="form.nama_matakuliah"
            class="w-full"
            id="nama"
            type="text"
            placeholder="Nama Matakuliah"
            autocomplete="off"
          ></Input>
          <div v-if="form.errors.nama_matakuliah" class="text-red-500">
            {{ form.errors.nama_matakuliah }}
          </div>
        </div>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="sks">
            Jumlah SKS
          </label>
          <Input
            v-model="form.sks"
            class="w-full"
            id="sks"
            type="number"
            placeholder="Jumlah SKS"
            autocomplete="off"
          ></Input>
          <div v-if="form.errors.sks" class="text-red-500">
            {{ form.errors.sks }}
          </div>
        </div>
        <div class="mb-3">
          <label for="kurikulum">Kurikulum</label>
          <select name="kurikulum" class="w-full" v-model="form.kurikulum_id">
            <option
              v-for="kurikulum in kurikulums"
              :value="kurikulum.id"
              :selected="form.kurikulum_id == kurikulum.id"
            >
              {{ kurikulum.nama }}
            </option>
          </select>
          <div v-if="form.errors.kurikulum_id" class="text-red-500">
            {{ form.errors.kurikulum_id }}
          </div>
        </div>
        <div class="mb-3">
          <label for="tipe">Tipe</label>
          <select name="tipe" class="w-full" v-model="form.tipe">
            <option
              v-for="tipe in tipes"
              :value="tipe"
              :selected="form.tipe == tipe"
            >
              {{ capitalize(tipe) }}
            </option>
          </select>
          <div v-if="form.errors.tipe" class="text-red-500">
            {{ form.errors.tipe }}
          </div>
        </div>
        <div class="flex justify-between">
          <Button class="px-10" :disabled="form.processing">Simpan</Button>
          <Link
            v-if="!route().current('master.kurikulum.create')"
            @click="remove()"
            class="text-red-500"
            >Hapus Matakuliah</Link
          >
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@layouts/App"
import Input from "@components/Input"
import Button from "@components/Button"
import { Link, useForm } from "@inertiajs/inertia-vue3"
import { Inertia } from "@inertiajs/inertia"

const props = defineProps({
  kurikulums: Array,
  matakuliah: {
    type: Object,
    default: {},
  },
})

const form = useForm({
  id: props.matakuliah?.id || null,
  kode_matakuliah: props.matakuliah?.kode_matakuliah || "",
  nama_matakuliah: props.matakuliah?.nama_matakuliah || "",
  kurikulum_id: props.matakuliah?.kurikulum_id || 1,
  sks: props.matakuliah?.sks || 1,
  tipe: props.matakuliah?.tipe || "wajib",
})

const tipes = ["wajib", "pilihan", "pilihan wajib"]

const submit = (curRoute) => {
  if (curRoute === "master.matakuliah.create") {
    form.post(route("master.matakuliah.store"))
  } else {
    form.put(route("master.matakuliah.update", props.matakuliah.id))
  }
}
function remove() {
  form.delete(route("master.matakuliah.destroy", props.matakuliah.id))
}

const capitalize = (s) =>
  s
    .split(" ")
    .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
    .join(" ")
</script>

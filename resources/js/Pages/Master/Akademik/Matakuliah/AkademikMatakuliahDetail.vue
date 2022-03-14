<template>
  <AppLayout>
    <div
      class="bg-zinc-50 dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">
        Akademik / Matakuliah /
        <span class="font-semibold text-teal-500 dark:text-teal-600">{{
          currentRouteName
        }}</span>
      </p>

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span>{{ currentRouteName }}</span>
            Matakuliah</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit(route().current())">
        <div class="mb-4">
          <label
            class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2"
            for="kode"
          >
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
          <InputError class="mt-2" :message="form.errors.kode_matakuliah" />
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2"
            for="nama"
          >
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
          <InputError class="mt-2" :message="form.errors.nama_matakuliah" />
        </div>
        <div class="mb-4">
          <label
            class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2"
            for="sks"
          >
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
          <InputError class="mt-2" :message="form.errors.sks" />
        </div>
        <div class="mb-4">
          <label
            for="tipe"
            class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2"
            >Tipe</label
          >
          <select
            name="tipe"
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            v-model="form.tipe"
          >
            <option value="null" selected disabled>
              Pilih tipe matakuliah
            </option>
            <option
              v-for="tipe in tipes"
              :value="tipe"
              :selected="form.tipe == tipe"
            >
              {{ capitalize(tipe) }}
            </option>
          </select>
          <InputError class="mt-2" :message="form.errors.tipe" />
        </div>
        <div class="mb-4">
          <label
            for="kurikulum"
            class="block text-gray-500 dark:text-400 text-sm font-bold mb-2"
            >Kurikulum</label
          >
          <select
            name="kurikulum"
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            v-model="form.kurikulum_id"
            @change="loadPrasyarats($event.target.selectedIndex)"
          >
            <option value="null" selected disabled>Pilih kurikulum</option>
            <option
              v-for="kurikulum in kurikulums"
              :value="kurikulum.id"
              :selected="form.kurikulum_id == kurikulum.id"
            >
              {{ kurikulum.nama }}
            </option>
          </select>
          <InputError class="mt-2" :message="form.errors.kurikulum_id" />
        </div>
        <div class="mb-4">
          <label
            for="kurikulum"
            class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2"
            >Jurusan</label
          >
          <select
            name="kurikulum"
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            v-model="form.matakuliah_jurusan.jurusan_id"
          >
            <option value="null" selected disabled>Pilih jurusan</option>
            <option value="-">-</option>
            <option
              v-for="jurusan in jurusans"
              :value="jurusan.id"
              :selected="
                form.matakuliah_jurusan &&
                form.matakuliah_jurusan.jurusan_id == jurusan.id
              "
            >
              {{ jurusan.nama }}
            </option>
          </select>
          <InputError class="mt-2" :message="form.errors.kurikulum_id" />
        </div>
        <div class="mb-4">
          <label
            for="prasyarat"
            class="block text-gray-500 dark:text-gray-400 text-sm font-bold mb-2"
            >Prasyarat</label
          >
          <div
            class="w-full bg-zinc-100 dark:bg-zinc-700 dark:text-zinc-500 rounded-md mb-4 py-2 px-3 flex flex-row items-center"
          >
            <div class="flex-1">
              <div
                v-for="(prasyarat, index) in form.prasyarats"
                class="inline-flex items-center bg-teal-500 text-zinc-50 py-1 px-2 text-sm rounded-lg hover:bg-teal-600 first:ml-0 last:mr-0 mx-1"
              >
                <span>{{
                  `${prasyarat.nama_matakuliah} (${
                    prasyarat.nilai_minimum || prasyarat.pivot.nilai_minimum
                  })`
                }}</span>
                <XIcon
                  @click="removePrasyarat(index)"
                  class="cursor-pointer ml-2 w-4 h-4 hover:text-red-400"
                />
              </div>
            </div>
            <ChevronDownIcon
              @click="isPrasyaratOpen = !isPrasyaratOpen"
              class="w-5 h-5 cursor-pointer text-zinc-500"
            />
          </div>

          <ul
            v-show="isPrasyaratOpen"
            class="bg-zinc-100 dark:bg-zinc-700 w-full rounded-md shadow-inner p-2"
          >
            <li
              v-for="matakuliah in prasyarats"
              @click="openDialogPrasyarat(matakuliah)"
              class="w-full focus:bg-teal-400 focus:text-white cursor-pointer"
            >
              {{ matakuliah.nama_matakuliah }}
            </li>
          </ul>
        </div>
        <div class="inline-flex items-center justify-between w-full">
          <Button class="px-10" :disabled="form.processing">Simpan</Button>
          <button
            type="button"
            v-if="currentRouteName != 'Tambah'"
            @click="isDialogHapusOpen = !isDialogHapusOpen"
            class="text-red-500 bg-transparent hover:bg-transparent focus:bg-transparent"
          >
            Hapus Matakuliah
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :isOpen="isDialogPrasyaratOpen"
      title="Tambah prasyarat"
      confirmText="Simpan"
      classes="text-teal-900 bg-teal-100 hover:bg-teal-200 focus-visible:ring-teal-500"
      @confirm="addPrasyarat"
      @cancel="isDialogPrasyaratOpen = !isDialogPrasyaratOpen"
    >
      <template #content>
        <div class="mb-3">
          <label for="matakuliah" class="block mb-2 text-sm">Matakuliah</label>
          <Input
            class="w-full"
            type="text"
            :value="selectedPrasyarat.nama_matakuliah"
            readonly
          />
        </div>

        <div>
          <label for="nilai" class="block text-sm mb-2">Nilai minimum</label>
          <select
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none"
            v-model="prasyaratNilai"
          >
            <option value="" selected disabled>Pilih nilai minimum</option>
            <option value="A">A</option>
            <option value="AB">AB</option>
            <option value="B">B</option>
            <option value="BA">BA</option>
            <option value="C">C</option>
            <option value="CA">CA</option>
            <option value="D">D</option>
            <option value="DA">DA</option>
            <option value="E">E</option>
          </select>
        </div>
      </template>
    </Dialog>

    <Dialog
      :isOpen="isDialogHapusOpen"
      title="Hapus matakuliah"
      confirmText="Hapus"
      classes="text-red-900 bg-red-100 hover:bg-red-200 focus-visible:ring-red-500"
      @confirm="remove"
      @cancel="isDialogHapusOpen = !isDialogHapusOpen"
    >
      <template #content>
        <p class="text-sm">Apakah anda yakin ingin menghapus matakuliah?</p>
      </template>
    </Dialog>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@layouts/App"
import Button from "@components/Button"
import Input from "@components/Input"
import InputError from "@components/InputError"
import Dialog from "@components/Dialog"
import { useForm } from "@inertiajs/inertia-vue3"
import { computed, onMounted, reactive, ref } from "vue"
import { ChevronDownIcon, XIcon } from "@heroicons/vue/solid"

const props = defineProps({
  jurusans: Array,
  kurikulums: Array,
  matakuliah: Object,
})

const form = useForm({
  id: props.matakuliah?.id || null,
  kode_matakuliah: props.matakuliah?.kode_matakuliah || "",
  nama_matakuliah: props.matakuliah?.nama_matakuliah || "",
  kurikulum_id: props.matakuliah?.kurikulum_id || null,
  matakuliah_jurusan: props.matakuliah?.matakuliah_jurusan || {
    jurusan_id: null,
  },
  sks: props.matakuliah?.sks || 1,
  tipe: props.matakuliah?.tipe || null,
  prasyarats: props.matakuliah?.prasyarats || [],
})

const tipes = ["wajib", "pilihan", "pilihan wajib"]
const prasyarats = reactive([])
const selectedPrasyarat = ref(null)
const isDialogPrasyaratOpen = ref(false)
const isDialogHapusOpen = ref(false)
const isPrasyaratOpen = ref(false)
const prasyaratNilai = ref("")

onMounted(() => {
  if (form.kurikulum_id) {
    const selected = props.kurikulums.find((k) => k.id == form.kurikulum_id)
    prasyarats.length = 0
    prasyarats.push.apply(prasyarats, selected.matakuliahs)
  }
})

const currentRouteName = computed(() =>
  route().current("master.matakuliah.create") ? "Tambah" : "Ubah"
)

const openDialogPrasyarat = (mk) => {
  if (!form.prasyarats.some((m) => m.id == mk.id)) {
    selectedPrasyarat.value = mk
    isDialogPrasyaratOpen.value = !isDialogPrasyaratOpen.value
  }
}

const loadPrasyarats = (index) => {
  prasyarats.length = 0
  prasyarats.push.apply(prasyarats, props.kurikulums[index - 1].matakuliahs)
}

const addPrasyarat = () => {
  isDialogPrasyaratOpen.value = !isDialogPrasyaratOpen.value
  selectedPrasyarat.value.nilai_minimum = prasyaratNilai.value
  prasyaratNilai.value = ""
  form.prasyarats.push(selectedPrasyarat.value)
}

const removePrasyarat = (index) => form.prasyarats.splice(index, 1)

const submit = (curRoute) => {
  if (curRoute === "master.matakuliah.create") {
    form.post(route("master.matakuliah.store"))
  } else {
    form.put(route("master.matakuliah.update", props.matakuliah.id))
  }
}
const remove = () =>
  form.delete(route("master.matakuliah.destroy", props.matakuliah.id))

const capitalize = (s) =>
  s
    .split(" ")
    .map((s) => s.charAt(0).toUpperCase() + s.substring(1))
    .join(" ")
</script>

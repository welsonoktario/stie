<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-zinc-50 p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs text-zinc-500 dark:text-zinc-400 md:text-sm">
        Akademik / Matakuliah /
        <span class="font-semibold text-teal-500 dark:text-teal-600">
          {{ currentRouteName }}
        </span>
      </p>

      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
          >
            <span>{{ currentRouteName }}</span>
            Matakuliah
          </strong>
        </span>
      </div>
      <form @submit.prevent="submit(route().current())">
        <div class="mb-4">
          <label
            class="mb-2 block text-sm font-bold text-gray-500 dark:text-gray-400"
            for="kode"
            >Kode Matakuliah</label
          >
          <Input
            id="kode"
            v-model="form.kode_matakuliah"
            class="w-full"
            type="text"
            placeholder="Kode Matakuliah"
            autocomplete="off"
            maxlength="10"
          ></Input>
          <InputError class="mt-2" :message="form.errors.kode_matakuliah" />
        </div>
        <div class="mb-4">
          <label
            class="mb-2 block text-sm font-bold text-gray-500 dark:text-gray-400"
            for="nama"
            >Nama Matakuliah</label
          >
          <Input
            id="nama"
            v-model="form.nama_matakuliah"
            class="w-full"
            type="text"
            placeholder="Nama Matakuliah"
            autocomplete="off"
          ></Input>
          <InputError class="mt-2" :message="form.errors.nama_matakuliah" />
        </div>

        <div class="flex space-x-2">
          <div class="mb-4 w-full">
            <label
              class="mb-2 block text-sm font-bold text-gray-500 dark:text-gray-400"
              for="sks"
              >Jumlah SKS</label
            >
            <Input
              id="sks"
              v-model="form.sks"
              class="w-full"
              type="number"
              placeholder="Jumlah SKS"
              autocomplete="off"
            ></Input>
            <InputError class="mt-2" :message="form.errors.sks" />
          </div>

          <div class="mb-4 w-full">
            <label
              for="semester"
              class="mb-2 block text-sm font-bold text-gray-500 dark:text-gray-400"
              >Semester</label
            >
            <select
              v-model="form.semester"
              class="w-full rounded-md border-none bg-zinc-100 dark:bg-zinc-700"
            >
              <option value selected>Pilih semester</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              <option value="6">6</option>
              <option value="7">7</option>
              <option value="8">8</option>
              <option value="9">9</option>
              <option value="10">10</option>
            </select>
          </div>
        </div>

        <div class="mb-4">
          <label
            for="tipe"
            class="mb-2 block text-sm font-bold text-gray-500 dark:text-gray-400"
            >Tipe</label
          >
          <select
            v-model="form.tipe"
            name="tipe"
            class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
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
            class="dark:text-400 mb-2 block text-sm font-bold text-gray-500"
            >Kurikulum</label
          >
          <select
            v-model="form.kurikulum_id"
            name="kurikulum"
            class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
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
            class="mb-2 block text-sm font-bold text-gray-500 dark:text-gray-400"
            >Jurusan</label
          >
          <select
            v-model="form.matakuliah_jurusan.jurusan_id"
            name="kurikulum"
            class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
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
            class="mb-2 block text-sm font-bold text-gray-500 dark:text-gray-400"
            >Prasyarat</label
          >
          <div
            class="mb-4 flex w-full flex-row items-center rounded-md bg-zinc-100 py-2 px-3 dark:bg-zinc-700 dark:text-zinc-500"
          >
            <div class="flex-1">
              <div
                v-for="(prasyarat, index) in form.prasyarats"
                class="mx-1 inline-flex items-center rounded-lg bg-teal-500 py-1 px-2 text-sm text-zinc-50 first:ml-0 last:mr-0 hover:bg-teal-600"
              >
                <span>
                  {{
                    `${prasyarat.nama_matakuliah} (${
                      prasyarat.nilai_minimum || prasyarat.pivot.nilai_minimum
                    })`
                  }}
                </span>
                <XIcon
                  class="ml-2 h-4 w-4 cursor-pointer hover:text-red-400"
                  @click="removePrasyarat(index)"
                />
              </div>
            </div>
            <ChevronDownIcon
              class="h-5 w-5 cursor-pointer text-zinc-500"
              @click="isPrasyaratOpen = !isPrasyaratOpen"
            />
          </div>

          <ul
            v-show="isPrasyaratOpen"
            class="w-full rounded-md bg-zinc-100 p-2 shadow-inner dark:bg-zinc-700"
          >
            <li
              v-for="matakuliah in prasyarats"
              class="w-full cursor-pointer focus:bg-teal-400 focus:text-white"
              @click="openDialogPrasyarat(matakuliah)"
            >
              S{{ matakuliah.semester }} - {{ matakuliah.kode_matakuliah }} -
              {{ matakuliah.nama_matakuliah }}
            </li>
          </ul>
        </div>
        <div class="inline-flex w-full items-center justify-between">
          <Button class="px-10" :disabled="form.processing">Simpan</Button>
          <button
            v-if="currentRouteName != 'Tambah'"
            type="button"
            class="bg-transparent text-red-500 hover:bg-transparent focus:bg-transparent"
            @click="isDialogHapusOpen = !isDialogHapusOpen"
          >
            Hapus Matakuliah
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :is-open="isDialogPrasyaratOpen"
      title="Tambah prasyarat"
      confirm-text="Simpan"
      classes="text-teal-900 bg-teal-100 hover:bg-teal-200 focus-visible:ring-teal-500"
      @confirm="addPrasyarat"
      @cancel="isDialogPrasyaratOpen = !isDialogPrasyaratOpen"
    >
      <template #content>
        <div class="mb-3">
          <label for="matakuliah" class="mb-2 block text-sm">Matakuliah</label>
          <Input
            class="w-full"
            type="text"
            :value="selectedPrasyarat.nama_matakuliah"
            readonly
          />
        </div>

        <div>
          <label for="nilai" class="mb-2 block text-sm">Nilai minimum</label>
          <select
            v-model="prasyaratNilai"
            class="w-full rounded-md border-none bg-zinc-100 dark:bg-zinc-700"
          >
            <option value selected disabled>Pilih nilai minimum</option>
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
      :is-open="isDialogHapusOpen"
      title="Hapus matakuliah"
      confirm-text="Hapus"
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
  semester: props.matakuliah?.semester || null,
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
    prasyarats.sort((a, b) => a.semester.localeCompare(b.semester))
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
  prasyarats.sort((a, b) => a.semester.localeCompare(b.semester))
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

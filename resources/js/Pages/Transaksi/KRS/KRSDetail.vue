<template>
  <AppLayout :title="`${currentRouteName} KRS Mahasiswa`">
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Keuangan /
        <span class="font-semibold text-teal-500 dark:text-teal-600">{{
          currentRouteName
        }}</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span>{{ currentRouteName }}</span>
            KRS Mahasiswa</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit">
        <div class="mb-4 flex space-x-3 w-full">
          <div class="w-full">
            <Label for="nama"> Nama Mahasiswa </Label>
            <Input
              v-model="form.nama"
              name="nama"
              class="mt-1 block w-full"
              type="text"
              disabled
            ></Input>
          </div>
          <div class="w-full">
            <Label for="npm"> NPM </Label>
            <Input
              v-model="form.npm"
              name="npm"
              class="mt-1 block w-full"
              type="text"
              disabled
            ></Input>
          </div>
        </div>

        <div class="mb-4 flex space-x-3 w-full">
          <div class="w-full">
            <Label for="nama"> IPK </Label>
            <Input
              v-model="form.nama"
              name="nama"
              class="mt-1 block w-full"
              type="text"
              disabled
            ></Input>
          </div>
          <div class="w-full">
            <Label for="npm">IPS Sebelumnya</Label>
            <Input
              v-model="form.npm"
              name="npm"
              class="mt-1 block w-full"
              type="text"
              disabled
            ></Input>
          </div>
        </div>

        <div class="mb-4">
          <Label for="nama"> Tahun Ajaran <span class="text-red-500">*</span> </Label>
          <select
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            name="Tahun Ajaran"
            v-model="selectedTahunAjaran"
            @change="loadTahunAjaran(selectedTahunAjaran)"
          >
            <!-- <option value="" selected disabled>Pilih agama</option> -->
            <option 
              v-for="(ta, index) in mahasiswa.tahun_ajaran" 
              :key="index"
              :value="ta.id">{{ta.tahun_ajaran}}
              </option>
          </select>
        </div>
        <!-- {{selectedTahunAjaran}} -->

        <label for="nama">
          Daftar Matakuliah
        </label>

        <DataTable :data='jadwalMahasiswa' :columns="columns">
          <template #row(jam)="row">
            {{row.data.hari}}, {{row.data.jam}}
          </template>
            
          <template #actions="row">
            <NavLink
              as="button"
              class="text-red-500"
              @click="openDialogHapus(row.data.kode_matakuliah)"
            >
              <TrashIcon class="h-4" />
            </NavLink>
          </template>
        </DataTable>

        <div class="flex justify-between">
          <Button class="px-10" :disabled="form.processing">Simpan</Button>
        </div>
      </form>

    </div>
    
    <Dialog
      :isOpen="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus tahun ajaran"
      confirmText="Hapus"
      @confirm="remove"
      @cancel="isOpen = !isOpen"
    >
      <template #content>
        <p class="text-sm">
          Apakah anda yakin ingin menghapus tahun ajaran ini?
        </p>
      </template>
    </Dialog>
  </AppLayout>
</template>

<script>
import { computed, ref } from "vue"
import { Link, useForm } from "@inertiajs/inertia-vue3"
import { Switch, SwitchGroup, SwitchLabel } from "@headlessui/vue"
import DataTable from "@components/DataTable.vue"
import AppLayout from "@layouts/App"
import Button from "@components/Button"
import Dialog from "@components/Dialog"
import Input from "@components/Input"
import InputError from "@components/InputError"
import Label from "@/Components/Label"
import { Inertia } from '@inertiajs/inertia'
import NavLink from "@/Components/NavLink"
import { CheckIcon, XIcon, TrashIcon } from "@heroicons/vue/outline"

export default {
  components: {
    AppLayout,
    Button,
    Dialog,
    Input,
    InputError,
    Label,
    Inertia,
    NavLink,
    DataTable,
    Link,
    Switch,
    SwitchGroup,
    SwitchLabel,
    TrashIcon,
  },
  props: {
    // tahunAjaran: Object,
    // tahunAjarans: Object,
    mahasiswa: Object,
    jadwals: Object, 
    jadwalMahasiswa: Object,

  },
  setup(props) {
    const form = useForm({
      nama: props.mahasiswa?.user?.name || null,
      npm: props.mahasiswa?.npm || null,
      history: props.mahasiswa?.tahun_ajaran || null,
      detilHistory: props.mahasiswa.tahun_ajaran.find(t => t.id == route().params.ta)
      // detilHistory
    })

    // const tambahMahasiswa = ref(false)

    const totalCicilan = computed(() => {
      return (Number(form.detilHistory.pivot.jumlah_cicilan_1) +
        Number(form.detilHistory.pivot.jumlah_cicilan_2) +
        Number(form.detilHistory.pivot.jumlah_cicilan_3))
    })

    const sisaComputed = computed(() => {
      return -(Number(form.detilHistory.pivot.uang_semester) - totalCicilan.value)
    })

    const isOpen = ref(false)

    const currentRouteName = computed(() =>
      route().current("master.tahun-ajaran.create") ? "Tambah" : "Edit"
    )

    const selectedTahunAjaran = ref(
      route().params.ta
    );


    const loadTahunAjaran = (id) => {
      // alert(id)
      const current = route().current()

      const r = route(current, {kr: props.mahasiswa.npm, _query: {ta: id}})
      return Inertia.get(r, {},{})
    }

    const submit = () =>
      currentRouteName.value == "Edit"
        ? form.put(route("transaksi.keuangan.update", props.mahasiswa.npm))
        : ""

    const remove = () =>
      form.delete(route("master.tahun-ajaran.destroy", props.tahunAjaran.id))

    const openDialogHapus = (kode_matakuliah) => alert('wow' + kode_matakuliah)

    const columns = [
      {
        key: 'kode_matakuliah',
        label: 'Kode'
      },
      {
        key: 'nama_matakuliah',
        label: 'Nama'
      },
      {
        key: 'sks',
        label: 'SKS'
      },
      {
        key: 'lokal',
        label: 'Lokal'
      },
      {
        key: 'ruangan',
        label: 'Ruangan'
      },
      {
        key: 'jam',
        label: 'Jadwal'
      },
    ]

    return {
      currentRouteName,
      form,
      isOpen,
      selectedTahunAjaran,
      sisaComputed,
      totalCicilan,
      columns,
      openDialogHapus,
      loadTahunAjaran,
      submit,
      remove,
    }
  },
}
</script>

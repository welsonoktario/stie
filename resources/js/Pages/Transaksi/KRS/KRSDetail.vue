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
        
      </form>


      <div class="flex justify-between mb-3">
        <label for="nama"> 
          Daftar Matakuliah
        </label>

        <Button type="button" class="px-10"
          @click="openDialogTambahMatakuliah">
          Tambah Matakuliah</Button>
      </div>

      <DataTable :data='jadwalMahasiswa' :columns="columns">
        <template #row(jam)="row">
          {{row.data.hari}}, {{row.data.jam}}
        </template>
          
        <template #actions="row">
          <NavLink
            as="button"
            class="text-red-500"
            @click="openDialogHapusMatakuliah(row.data.jadwal_id)"
          >
            <TrashIcon class="h-4" />
          </NavLink>
        </template>
      </DataTable>

    </div>
    
    <Dialog
      :isOpen="isOPenDialogHapusMatakuliah"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus Matakuliah"
      confirmText="Hapus"
      @confirm="hapusMatakuliah"
      @cancel="isOPenDialogHapusMatakuliah = !isOPenDialogHapusMatakuliah"
    >
      <template #content>
        <p class="text-sm">
          Apakah anda yakin ingin menghapus tahun ajaran ini? {{selectedJadwalHapus}}
        </p>
      </template>
    </Dialog>

    <Dialog
      :isOpen="isDialogTambahMatakuliahOpen"
      classes="text-green-900 bg-green-100 dark:bg-greeb-300 hover:bg-greeb-200 dark:hover:bg-green-400 focus-visible:ring-green-500"
      title="Tambah Matakuliah"
      confirmText="Tambah"
      @confirm="tambahMatakuliah"
      @cancel="isDialogTambahMatakuliahOpen = !isDialogTambahMatakuliahOpen"
    >
      <template #content>
        <Select
          class="w-full"
          :options="jadwals"
          v-model="selectedJadwal"
        >
          <template #option="option">
            <option :value="option.data.id">
              {{ `${option.data.matakuliah.kode_matakuliah} - ${option.data.matakuliah.nama_matakuliah} - ${option.data.local} - ${option.data.hari},${option.data.jam}` }}
            </option>
          </template>
        </Select>
      </template>
    </Dialog>
  </AppLayout>
</template>

<script>
import { computed, ref } from "vue"
import { Link, useForm } from "@inertiajs/inertia-vue3"
import { Switch, SwitchGroup, SwitchLabel } from "@headlessui/vue"
import { CheckIcon, XIcon, TrashIcon } from "@heroicons/vue/outline"
import { Inertia } from '@inertiajs/inertia'

import DataTable from "@components/DataTable.vue"
import AppLayout from "@layouts/App"
import Button from "@components/Button"
import Dialog from "@components/Dialog"
import Input from "@components/Input"
import InputError from "@components/InputError"
import Label from "@/Components/Label"
import Select from "@components/Select"
import NavLink from "@/Components/NavLink"

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
    Select,
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
    })

    const isOpen = ref(false)
    const isDialogTambahMatakuliahOpen = ref(false)
    const isOPenDialogHapusMatakuliah = ref(false)
    const selectedJadwal = ref()
    const selectedJadwalHapus = ref()

    const currentRouteName = computed(() =>
      route().current("master.tahun-ajaran.create") ? "Tambah" : "Edit"
    )

    const selectedTahunAjaran = ref(
      route().params.ta
    );


    const loadTahunAjaran = (id) => {
      const current = route().current()

      const r = route(current, {kr: props.mahasiswa.npm, _query: {ta: id}})
      return Inertia.get(r, {},{})
    }

    const submit = () =>
      currentRouteName.value == "Edit"
        ? form.put(route("", props.mahasiswa.npm))
        : ""

    const remove = () =>
      form.delete(route("", props.tahunAjaran.id))

    const openDialogHapus = (kode_matakuliah) => alert('wow' + kode_matakuliah)


    // Tambah matakuliah

    const openDialogTambahMatakuliah = () => {
      // isOpen.value = !isOpen.value
      isDialogTambahMatakuliahOpen.value = !isDialogTambahMatakuliahOpen.value
      console.log(isDialogTambahMatakuliahOpen.value)
      console.log(!isDialogTambahMatakuliahOpen.value)
    }

    const tambahMatakuliah = () => {
      Inertia.put(
        route("transaksi.krs.update", props.mahasiswa.npm),
        {
          jadwal_id: selectedJadwal.value,
          ta: selectedTahunAjaran.value,
        },{
          onSuccess: (page) => {
            isDialogTambahMatakuliahOpen.value = !isDialogTambahMatakuliahOpen.value
          }
        })
    }

    // hapus matakuliah

    const openDialogHapusMatakuliah = (jadwal) => {
      // isOpen.value = !isOpen.value
      isOPenDialogHapusMatakuliah.value = !isOPenDialogHapusMatakuliah.value
      selectedJadwalHapus.value = jadwal
      console.log(isOPenDialogHapusMatakuliah.value)
      console.log(!isOPenDialogHapusMatakuliah.value)
    }

    const hapusMatakuliah = () => {
      const r = route('transaksi.krs.destroy', props.mahasiswa.npm)
      console.log(r)
      console.log(selectedJadwalHapus.value)
      
      Inertia.delete(r, {
        data: {
          jadwal_id: selectedJadwalHapus.value,
        },
        onSuccess: page => {
          isOPenDialogHapusMatakuliah.value = !isOPenDialogHapusMatakuliah.value
          console.log(isOPenDialogHapusMatakuliah.value)
          console.log(!isOPenDialogHapusMatakuliah.value)
        },
      })
    }

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
      columns,
      isDialogTambahMatakuliahOpen,
      isOPenDialogHapusMatakuliah,
      selectedJadwal,
      openDialogTambahMatakuliah,
      tambahMatakuliah,
      openDialogHapus,
      loadTahunAjaran,
      openDialogHapusMatakuliah,
      hapusMatakuliah,
      selectedJadwalHapus,
      submit,
      remove,
    }
  },
}
</script>

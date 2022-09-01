<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs md:text-sm">Akademik / Jabatan Struktural</p>
      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
            >Daftar Jabatan Struktural</strong
          >
        </span>

        <!-- <Button type="button">
          <Link :href="route('master.tahun-ajaran.create')">
            Tambah Tahun Akademik
          </Link>
        </Button>-->
      </div>

      <DataTable :columns="columns" :data="jabatans">
        <template #actions="row">
          <Link @click="openDialogJabatan(row.data)">Edit</Link>
        </template>

        <!-- <template #row(name)="row">

        </template>-->
        <template #row(name)="row">
          <p v-if="!row.data.name">-</p>
          <!-- <p v-if="row.data.gelar_belakang || row.data.gelar_depan">{{row.data.gelar_depan}} {{row.data.name}}{{", " + row.data.gelar_belakang}}</p> -->
          <p v-else>
            {{ row.data.gelar_depan && (row.data.gelar_depan + ".") }} {{ row.data.name
            }}{{ row.data.gelar_belakang && (", " + row.data.gelar_belakang) }}
          </p>
          <!-- <p v-else>{{row.data.name}}</p> -->
          <!-- <p v-else>{{row.data.name}}</p> -->
        </template>
      </DataTable>

    </div>

    <Dialog
      :is-open="isDialogJabatanOpen"
      title="Edit Jabatan Struktural"
      confirm-text="Edit"
      classes="text-teal-900 bg-teal-100 hover:bg-teal-200 focus-visible:ring-teal-500"
      @confirm="edit"
      @cancel="isDialogJabatanOpen = !isDialogJabatanOpen">
      <template #content>
        <div class="my-3">
          <Label for="karyawan">Pilih Karyawan</Label>
          <Select
            v-model="selectedIdKaryawan"
            class="w-full"
            :options="karyawans"
            :name="'karyawan'"
            :placeholder="'-'"
          >
            <template #option="option">
              <option :value="option.data.id">{{ option.data.id }} - {{ option.data.user.name }}</option>
            </template>
          </Select>
        </div>
      </template>
    </Dialog>
  </AppLayout>
</template>

<script setup>
// import { Link } from "@inertiajs/inertia-vue3"
import AppLayout from "@layouts/App"
import Button from "@components/Button"
import DataTable from "@/Components/DataTable"
import NavLink from "@/Components/NavLink"
import LinkButton from "@/Components/LinkButton.vue"
import Dialog from "@/Components/Dialog.vue"
import { ref, reactive } from "vue"
import Link from "@/Components/Link.vue"
import Select from "@/Components/Select.vue"
import Label from "@/Components/Label.vue"
import { useForm } from "@inertiajs/inertia-vue3"
import { Inertia } from "@inertiajs/inertia"


const isDialogJabatanOpen = ref(false)

const selectedIdKaryawan = ref("")

const selectedIdJabatan = ref("")

const openDialogJabatan = (jabatan) => {
  selectedIdKaryawan.value = jabatan.staff_id
  selectedIdJabatan.value = jabatan.id
  isDialogJabatanOpen.value = true
}

const edit = () =>
  Inertia.put(
    route("master.jabatan-struktural.update", selectedIdJabatan.value),
    {
      staff_id: selectedIdKaryawan.value,
    },
    {
      onSuccess: (page) => {
        isDialogJabatanOpen.value = false
        console.log('wow bisa')
        // isDialogNilaiOpen.value = !isDialogNilaiOpen.value
        // calcIp()
      },
    }
  )




const columns = [
  {
    key: "nama_jabatan",
    label: "Jabatan",
  },
  {
    key: "name",
    label: "Pemangku Jabatan",
  },
]

const props = defineProps({
  jabatans: Object,
  karyawans: Object
})

</script>

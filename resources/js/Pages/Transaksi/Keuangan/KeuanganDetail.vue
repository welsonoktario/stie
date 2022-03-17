<template>
  <AppLayout :title="`${currentRouteName} Tahun Akademik`">
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
            Detail Keuangan</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <Label for="nama"> Nama Mahasiswa </Label>
          <Input
            v-model="form.nama"
            name="nama"
            class="mt-1 block w-full"
            type="text"
            disabled
          ></Input>
        </div>
        <div class="mb-4">
          <Label for="npm"> NPM </Label>
          <Input
            v-model="form.npm"
            name="npm"
            class="mt-1 block w-full"
            type="text"
            disabled
          ></Input>
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
        <div 
          class="mb-5"
          v-for="(ta, index) in mahasiswa.tahun_ajaran" :key="index"
          
          >
          <div v-if="ta.id == selectedTahunAjaran">
            <div class="mb-3"><strong class="mb-3 whitespace-nowrap capitalize text-sm md:text-lg content-middle">
              {{ta.tahun_ajaran}} - {{ta.pivot.status}}</strong></div>
            
            <table 
              class="min-w-full divide-y divide-gray-200 mb-3">
              <thead class="">
                <tr>
                  <th class="text-gray-500 font-medium">Cicilan</th>
                  <th class="text-gray-500 font-medium w-1/4">Nominal</th>
                  <th class="text-gray-500 font-medium w-1/6">Tanggal Bayar</th>
                  <th class="text-gray-500 font-medium">Keterangan</th>
                </tr>
              </thead>
              <tbody class="">
                <!-- Cicilan 1 -->
                <tr>
                  <th class="text-gray-500 font-medium">C1</th>
                  <td>
                    <Input
                      name="nominal"
                      v-model="form.detilHistory.pivot.jumlah_cicilan_1"
                      class="mt-1 block w-full"
                      type="text"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.tanggal_cicilan_1"
                      class="mt-1 block w-full"
                      type="datetime-local"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.keterangan_ciilan_1"
                      class="mt-1 block w-full"
                      type="text"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                </tr>
                
                <!-- Cicilan 2 -->
                <tr>
                  <th class="text-gray-500 font-medium">C2</th>
                  <td>
                      <Input
                        name="nominal"
                        class="mt-1 block w-full"
                        v-model="form.detilHistory.pivot.jumlah_cicilan_2"
                        type="text"
                        placeholder=""
                        autocomplete="off"
                      ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.tanggal_cicilan_2"
                      class="mt-1 block w-full"
                      type="datetime-local"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.keterangan_ciilan_2"
                      class="mt-1 block w-full"
                      type="text"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                </tr>
                
                <!-- Cicilan 3 -->
                <tr>
                  <th class="text-gray-500 font-medium">C3</th>
                  <td>
                      <Input
                        v-model="form.detilHistory.pivot.jumlah_cicilan_3"
                        name="nominal"
                        class="mt-1 block w-full"
                        type="text"
                        placeholder=""
                        autocomplete="off"
                      ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.tanggal_cicilan_3"
                      class="mt-1 block w-full"
                      type="datetime-local"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.keterangan_ciilan_3"
                      class="mt-1 block w-full"
                      type="text"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                </tr>
              </tbody>
              <thead>
                <tr>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th class="text-gray-500 font-normal">Total Cicilan</th>
                  <td> Rp. {{totalCicilan}}</td>
                </tr>
                <tr>
                  <th class="text-gray-500 font-medium">UPP</th>
                  <td>
                      <Input
                        v-model="form.detilHistory.pivot.uang_semester"
                        name="nominal"
                        class="mt-1 block w-full"
                        type="text"
                        placeholder=""
                        autocomplete="off"
                      ></Input>
                  </td>
                </tr>
                <tr>
                  <th class="text-gray-500 font-medium">Sisa</th>
                  <td> Rp. {{sisaComputed}} </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

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

import AppLayout from "@layouts/App"
import Button from "@components/Button"
import Dialog from "@components/Dialog"
import Input from "@components/Input"
import InputError from "@components/InputError"
import Label from "@/Components/Label"
import { Inertia } from '@inertiajs/inertia'

export default {
  components: {
    AppLayout,
    Button,
    Dialog,
    Input,
    InputError,
    Label,
    Inertia,
    Link,
    Switch,
    SwitchGroup,
    SwitchLabel,
  },
  props: {
    // tahunAjaran: Object,
    // tahunAjarans: Object,
    mahasiswa: Object,
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

      const r = route(current, {keuangan: props.mahasiswa.npm, _query: {ta: id}})
      return Inertia.get(r, {},{})
    }

    const submit = () =>
      currentRouteName.value == "Edit"
        ? form.put(route("transaksi.keuangan.update", props.mahasiswa.npm))
        : ""

    const remove = () =>
      form.delete(route("master.tahun-ajaran.destroy", props.tahunAjaran.id))

    return {
      currentRouteName,
      form,
      isOpen,
      selectedTahunAjaran,
      sisaComputed,
      totalCicilan,
      loadTahunAjaran,
      submit,
      remove,
    }
  },
}
</script>

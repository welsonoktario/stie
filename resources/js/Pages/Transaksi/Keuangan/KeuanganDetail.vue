<template>
  <AppLayout :title="`${currentRouteName} Tahun Akademik`">
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs text-slate-500 md:text-sm">
        Keuangan /
        <span class="font-semibold text-teal-500 dark:text-teal-600">{{
          currentRouteName
        }}</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
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
          <Label for="nama">
            Tahun Ajaran <span class="text-red-500">*</span>
          </Label>
          <select
            v-model="selectedTahunAjaran"
            class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            name="Tahun Ajaran"
            @change="loadTahunAjaran(selectedTahunAjaran)"
          >
            <!-- <option value="" selected disabled>Pilih agama</option> -->
            <option
              v-for="(ta, index) in mahasiswa.tahun_ajaran"
              :key="index"
              :value="ta.id"
            >
              {{ ta.tahun_ajaran }}
            </option>
          </select>
        </div>

        <div class="mb-3">
          <strong
            class="content-middle mb-3 whitespace-nowrap text-sm capitalize md:text-lg"
          >
            Uang Semester</strong
          >
        </div>

        <!-- History Uang Semester (UPP) -->
        <div class="mb-4">
          <Label>History Pembayaran Uang Semester</Label>
          <table class="mt-1 w-full">
            <thead class="border-b-2">
              <tr>
                <th class="p-3 text-sm font-medium text-gray-500">
                  Tahun Akademik
                </th>
                <th class="p-3 text-sm font-medium text-gray-500">Cicilan 1</th>
                <th class="p-3 text-sm font-medium text-gray-500">Cicilan 2</th>
                <th class="p-3 text-sm font-medium text-gray-500">Cicilan 3</th>
                <th class="p-3 text-sm font-medium text-gray-500">
                  Total Cicilan
                </th>
                <th class="p-3 text-sm font-medium text-gray-500">
                  Uang Semester
                </th>
                <th class="p-3 text-sm font-medium text-gray-500">Sisa</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(ta, index) in mahasiswa.tahun_ajaran" :key="index">
                <td class="p-2 px-4 text-sm text-gray-700">
                  {{ ta.tahun_ajaran }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ ta.pivot.jumlah_cicilan_1 ?? "-" }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ ta.pivot.jumlah_cicilan_2 ?? "-" }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ ta.pivot.jumlah_cicilan_3 ?? "-" }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ ta.pivot.total_cicilan ?? "-" }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ ta.pivot.uang_semester ?? "-" }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ -(ta.pivot.uang_semester - ta.pivot.total_cicilan) }}
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- CRUD Cicilan Uang Semester (UPP) -->
        <div
          v-for="(ta, index) in mahasiswa.tahun_ajaran"
          :key="index"
          class="mb-5"
        >
          <div v-if="ta.id == selectedTahunAjaran">
            <!-- <div class="mb-3"><strong class="mb-3 whitespace-nowrap capitalize text-sm md:text-lg content-middle">
              {{ta.tahun_ajaran}} - {{ta.pivot.status}}</strong></div> -->
            <Label class="mb-4">
              Detail pembayaran {{ ta.tahun_ajaran }} - {{ ta.pivot.status }}
            </Label>
            <table class="mb-3 min-w-full divide-y divide-gray-200">
              <thead class="">
                <tr>
                  <th class="font-medium text-gray-500">Cicilan</th>
                  <th class="w-1/4 font-medium text-gray-500">Nominal</th>
                  <th class="w-1/6 font-medium text-gray-500">Tanggal Bayar</th>
                  <th class="font-medium text-gray-500">Keterangan</th>
                </tr>
              </thead>
              <tbody class="">
                <!-- Cicilan 1 -->
                <tr>
                  <th class="font-medium text-gray-500">C1</th>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.jumlah_cicilan_1"
                      name="nominal"
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
                  <th class="font-medium text-gray-500">C2</th>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.jumlah_cicilan_2"
                      name="nominal"
                      class="mt-1 block w-full"
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
                  <th class="font-medium text-gray-500">C3</th>
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
                <tr></tr>
              </thead>
              <tbody>
                <tr>
                  <th class="font-normal text-gray-500">Total Cicilan</th>
                  <td>Rp. {{ totalCicilan }}</td>
                </tr>
                <tr>
                  <th class="font-medium text-gray-500">UPP</th>
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
                  <th class="font-medium text-gray-500">Sisa</th>
                  <td>Rp. {{ sisaComputed }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <div class="mb-3">
          <strong
            class="content-middle mb-3 whitespace-nowrap text-sm capitalize md:text-lg"
          >
            Lain-lain</strong
          >
        </div>

        <!-- History pembayaran lain lain -->
        <div class="mb-4">
          <Label>History Pembayaran Lain-lain (fitur tambahan)</Label>
          <table class="mt-1 w-full">
            <thead>
              <tr class="border-b-2">
                <th class="p-3 text-sm font-medium text-gray-500">
                  Tahun Akademik
                </th>
                <th class="p-3 text-sm font-medium text-gray-500">
                  Cicilan DPP
                </th>
                <th class="p-3 text-sm font-medium text-gray-500">
                  Cicilan Praktikum
                </th>
                <th class="p-3 text-sm font-medium text-gray-500">
                  Cicilan Almamater
                </th>
                <th class="p-3 text-sm font-medium text-gray-500">
                  Biaya Konversi
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(ta, index) in mahasiswa.tahun_ajaran" :key="index">
                <td class="p-2 px-4 text-sm text-gray-700">
                  {{ ta.tahun_ajaran }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ ta.pivot.jumlah_cicilan_dpp ?? "-" }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ ta.pivot.jumlah_cicilan_praktikum ?? "-" }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ ta.pivot.jumlah_cicilan_almamater ?? "-" }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ ta.pivot.jumlah_cicilan_biaya_konversi ?? "-" }}
                </td>
              </tr>

              <!-- Total Cicilan -->
              <tr class="border-t-2">
                <td class="p-2 px-4 text-right text-sm text-gray-700">Total</td>
                <td class="p-2 px-4 text-sm text-gray-700">Rp. -</td>
                <td class="p-2 px-4 text-sm text-gray-700">Rp. -</td>
                <td class="p-2 px-4 text-sm text-gray-700">Rp. -</td>
                <td class="p-2 px-4 text-sm text-gray-700">Rp. -</td>
              </tr>

              <!-- Harus dibayarkan -->
              <tr class="border-t-2">
                <td class="p-2 px-4 text-right text-sm text-gray-700">
                  Harus dibayarkan
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ mahasiswa.k_dpp ?? "-" }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ mahasiswa.k_praktikum ?? "-" }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ mahasiswa.k_almamater ?? "-" }}
                </td>
                <td class="p-2 px-4 text-sm text-gray-700">
                  Rp. {{ mahasiswa.k_biaya_kovnversi ?? "-" }}
                </td>
              </tr>

              <!-- Total Sisa -->
              <tr>
                <td class="p-2 px-4 text-right text-sm text-gray-700">Sisa</td>
                <td class="p-2 px-4 text-sm text-gray-700">Rp. -</td>
                <td class="p-2 px-4 text-sm text-gray-700">Rp. -</td>
                <td class="p-2 px-4 text-sm text-gray-700">Rp. -</td>
                <td class="p-2 px-4 text-sm text-gray-700">Rp. -</td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- CRUD pembayaran lain-lain -->
        <div
          v-for="(ta, index) in mahasiswa.tahun_ajaran"
          :key="index"
          class="mb-5"
        >
          <div v-if="ta.id == selectedTahunAjaran">
            <!-- <div class="mb-3"><strong class="mb-3 whitespace-nowrap capitalize text-sm md:text-lg content-middle">
              {{ta.tahun_ajaran}} - {{ta.pivot.status}}</strong></div> -->
            <Label class="mb-4">
              Detail pembayaran lain-lain {{ ta.tahun_ajaran }} -
              {{ ta.pivot.status }}
            </Label>
            <table class="mb-3 min-w-full divide-y divide-gray-200">
              <thead class="">
                <tr>
                  <th class="font-medium text-gray-500">Cicilan</th>
                  <th class="w-1/4 font-medium text-gray-500">Nominal</th>
                  <th class="w-1/6 font-medium text-gray-500">Tanggal Bayar</th>
                  <th class="font-medium text-gray-500">Keterangan</th>
                </tr>
              </thead>
              <tbody class="">
                <!-- Cicilan DPP -->
                <tr>
                  <th class="font-medium text-gray-500">DPP</th>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.jumlah_cicilan_dpp"
                      name="nominal"
                      class="mt-1 block w-full"
                      type="number"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.tanggal_cicilan_dpp"
                      class="mt-1 block w-full"
                      type="datetime-local"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.keterangan_cicilan_dpp"
                      class="mt-1 block w-full"
                      type="text"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                </tr>

                <!-- Cicilan Praktikum -->
                <tr>
                  <th class="font-medium text-gray-500">Praktikum</th>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.jumlah_cicilan_praktikum"
                      name="nominal"
                      class="mt-1 block w-full"
                      type="number"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="
                        form.detilHistory.pivot.tanggal_cicilan_praktikum
                      "
                      class="mt-1 block w-full"
                      type="datetime-local"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="
                        form.detilHistory.pivot.keterangan_cicilan_praktikum
                      "
                      class="mt-1 block w-full"
                      type="text"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                </tr>

                <!-- Cicilan Almamater -->
                <tr>
                  <th class="font-medium text-gray-500">Almamater</th>
                  <td>
                    <Input
                      v-model="form.detilHistory.pivot.jumlah_cicilan_almamater"
                      name="nominal"
                      class="mt-1 block w-full"
                      type="number"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="
                        form.detilHistory.pivot.tanggal_cicilan_almamater
                      "
                      class="mt-1 block w-full"
                      type="datetime-local"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="
                        form.detilHistory.pivot.keterangan_cicilan_almamater
                      "
                      class="mt-1 block w-full"
                      type="text"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                </tr>

                <!-- Cicilan Biaya Konversi -->
                <tr>
                  <th class="font-medium text-gray-500">Biaya Konversi</th>
                  <td>
                    <Input
                      v-model="
                        form.detilHistory.pivot.jumlah_cicilan_biaya_konversi
                      "
                      name="nominal"
                      class="mt-1 block w-full"
                      type="number"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="
                        form.detilHistory.pivot.tanggal_cicilan_biaya_konversi
                      "
                      class="mt-1 block w-full"
                      type="datetime-local"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                  <td>
                    <Input
                      v-model="
                        form.detilHistory.pivot
                          .keterangan_cicilan_biaya_konversi
                      "
                      class="mt-1 block w-full"
                      type="text"
                      placeholder=""
                      autocomplete="off"
                    ></Input>
                  </td>
                </tr>
              </tbody>
              <thead>
                <tr></tr>
              </thead>
              <!-- <tbody>
                <tr>
                  <th class="text-gray-500 font-normal">Total Cicilan</th>
                  <td> Rp. {{totalCicilan}}</td>
                </tr>
                <tr>
                  <th class="text-gray-500 font-normal">Harus dibayarkan</th>
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
                <tr class="border-t-2">
                  <th class="text-gray-500 font-normal">Sisa</th>
                  <td> Rp. {{sisaComputed}} </td>
                </tr>
              </tbody> -->
            </table>
          </div>
        </div>

        <div class="flex justify-between">
          <Button class="px-10" :disabled="form.processing">Simpan</Button>
        </div>
      </form>
    </div>

    <Dialog
      :is-open="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus tahun ajaran"
      confirm-text="Hapus"
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
import { Inertia } from "@inertiajs/inertia"

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
      detilHistory: props.mahasiswa.tahun_ajaran.find(
        (t) => t.id == route().params.ta
      ),
      // detilHistory
    })

    // const tambahMahasiswa = ref(false)

    const totalCicilan = computed(() => {
      return (
        Number(form.detilHistory.pivot.jumlah_cicilan_1) +
        Number(form.detilHistory.pivot.jumlah_cicilan_2) +
        Number(form.detilHistory.pivot.jumlah_cicilan_3)
      )
    })

    const sisaComputed = computed(() => {
      return -(
        Number(form.detilHistory.pivot.uang_semester) - totalCicilan.value
      )
    })

    const isOpen = ref(false)

    const currentRouteName = computed(() =>
      route().current("master.tahun-ajaran.create") ? "Tambah" : "Edit"
    )

    const selectedTahunAjaran = ref(route().params.ta)

    const loadTahunAjaran = (id) => {
      // alert(id)
      const current = route().current()

      const r = route(current, {
        keuangan: props.mahasiswa.npm,
        _query: { ta: id },
      })
      return Inertia.get(r, {}, {})
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

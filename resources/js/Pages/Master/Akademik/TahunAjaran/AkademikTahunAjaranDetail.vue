<template>
  <AppLayout :title="`${currentRouteName} Tahun Akademik`">
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Akademik / Tahun Akademik /
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
            Tahun Akademik</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <Label for="tahun_ajaran"> Tahun Akademik </Label>
          <Input
            v-model="form.tahun_ajaran"
            name="tahun_ajaran"
            class="mt-1 block w-full"
            type="text"
            placeholder="Tahun ajaran"
            autocomplete="off"
          ></Input>
          <InputError class="mt-2" :message="form.errors.tahun_ajaran" />
        </div>
        <div class="mb-4 flex space-x-2">
          <div class="w-full">
            <Label for="tanggal_mulai"> Tanggal Mulai </Label>
            <Input
              v-model="form.tanggal_mulai"
              name="tanggal_mulai"
              class="mt-1 block w-full"
              type="date"
              min="2000"
              max="3000"
              id="tanggal_mulai"
              placeholder="Tahun mulai"
            ></Input>
            <InputError class="mt-2" :message="form.errors.tanggal_mulai" />
          </div>
          <div class="w-full">
            <Label for="tanggal_selesai"> Tanggal Selesai </Label>
            <Input
              v-model="form.tanggal_selesai"
              name="tanggal_selesai"
              class="mt-1 block w-full"
              type="date"
              min="2000"
              max="3000"
              id="tanggal_selesai"
              placeholder="tanggal selesai"
            ></Input>
            <InputError class="mt-2" :message="form.errors.tanggal_selesai" />
          </div>
        </div>
        <div class="mb-4">
        </div>
        <div class="mb-4">
          <Label for="periode"> Periode </Label>
          <select
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            name="periode"
            v-model="form.periode"
          >
            <option value="null" selected disabled>Pilih periode</option>
            <option value="1">1 - Gasal</option>
            <option value="2">2 - Genap</option>
          </select>
          <InputError class="mt-2" :message="form.errors.periode" />
        </div>

        <div class="mb-4 flex space-x-5">
          <div class="">
            <SwitchGroup>
              <SwitchLabel class="block text-gray-500 text-sm font-bold mb-2"
                >Aktif</SwitchLabel
              >
              <Switch
                v-model="form.aktif"
                :class="form.aktif ? 'bg-teal-600' : 'bg-gray-200'"
                class="relative inline-flex items-center h-6 transition-colors rounded-full w-11 ring-0"
              >
                <span
                  :class="form.aktif ? 'translate-x-6' : 'translate-x-1'"
                  class="inline-block w-4 h-4 transition-transform transform bg-white rounded-full"
                />
              </Switch>
            </SwitchGroup>
          </div>

          <div class="" v-if="currentRouteName == 'Tambah'">
            <SwitchGroup>
              <SwitchLabel class="block text-gray-500 text-sm font-bold mb-2"
                >Tambah Mahasiswa</SwitchLabel
              >
              <Switch
                v-model="form.tambahMahasiswa"
                :class="form.tambahMahasiswa ? 'bg-teal-600' : 'bg-gray-200'"
                class="relative inline-flex items-center h-6 transition-colors rounded-full w-11 ring-0"
              >
                <span
                  :class="form.tambahMahasiswa ? 'translate-x-6' : 'translate-x-1'"
                  class="inline-block w-4 h-4 transition-transform transform bg-white rounded-full"
                />
              </Switch>
            </SwitchGroup>
          </div>
        </div>

        <div class="flex justify-between">
          <Button class="px-10" :disabled="form.processing">Simpan</Button>
          <button
            type="button"
            v-if="currentRouteName != 'Tambah'"
            @click="isOpen = !isOpen"
            class="text-red-500 bg-transparent hover:bg-transparent focus:bg-transparent"
          >
            Hapus Data Tahun Ajaran
          </button>
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

export default {
  components: {
    AppLayout,
    Button,
    Dialog,
    Input,
    InputError,
    Label,
    Link,
    Switch,
    SwitchGroup,
    SwitchLabel,
  },
  props: {
    tahunAjaran: Object,
  },
  setup(props) {
    const form = useForm({
      tahun_ajaran: props.tahunAjaran?.tahun_ajaran || null,
      tanggal_mulai: props.tahunAjaran?.tanggal_mulai || null,
      tanggal_selesai: props.tahunAjaran?.tanggal_selesai || null,
      periode: props.tahunAjaran?.periode || null,
      aktif: props.tahunAjaran == null ? false : props.tahunAjaran.aktif,
      tambahMahasiswa: false
    })

    // const tambahMahasiswa = ref(false)

    const isOpen = ref(false)

    const currentRouteName = computed(() =>
      route().current("master.tahun-ajaran.create") ? "Tambah" : "Edit"
    )

    const submit = () =>
      currentRouteName.value == "Tambah"
        ? form.post(route("master.tahun-ajaran.store"))
        : form.put(route("master.tahun-ajaran.update", props.tahunAjaran.id))

    const remove = () =>
      form.delete(route("master.tahun-ajaran.destroy", props.tahunAjaran.id))

    return {
      currentRouteName,
      form,
      isOpen,
      // tambahMahasiswa,
      submit,
      remove,
    }
  },
}
</script>

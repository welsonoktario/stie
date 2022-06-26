<template>
  <AppLayout :title="`${currentRouteName} Tahun Akademik`">
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs text-slate-500 md:text-sm">
        Akademik / Tahun Akademik /
        <span class="font-semibold text-teal-500 dark:text-teal-600">
          {{ currentRouteName }}
        </span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
          >
            <span>{{ currentRouteName }}</span>
            Tahun Akademik
          </strong>
        </span>
      </div>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <Label for="tahun_ajaran">Tahun Akademik</Label>
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
            <Label for="tanggal_mulai">Tanggal Mulai</Label>
            <Input
              id="tanggal_mulai"
              v-model="form.tanggal_mulai"
              name="tanggal_mulai"
              class="mt-1 block w-full"
              type="date"
              min="2000"
              max="3000"
              placeholder="Tahun mulai"
            ></Input>
            <InputError class="mt-2" :message="form.errors.tanggal_mulai" />
          </div>
          <div class="w-full">
            <Label for="tanggal_selesai">Tanggal Selesai</Label>
            <Input
              id="tanggal_selesai"
              v-model="form.tanggal_selesai"
              name="tanggal_selesai"
              class="mt-1 block w-full"
              type="date"
              min="2000"
              max="3000"
              placeholder="tanggal selesai"
            ></Input>
            <InputError class="mt-2" :message="form.errors.tanggal_selesai" />
          </div>
        </div>
        <div class="mb-4"></div>
        <div class="mb-4">
          <Label for="periode">Periode</Label>
          <select
            v-model="form.periode"
            class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            name="periode"
          >
            <option value="null" selected disabled>Pilih periode</option>
            <option value="1">1 - Ganjil</option>
            <option value="2">2 - Genap</option>
          </select>
          <InputError class="mt-2" :message="form.errors.periode" />
        </div>

        <div class="mb-4 flex space-x-5">
          <div class>
            <SwitchGroup>
              <SwitchLabel class="mb-2 block text-sm font-bold text-gray-500"
                >Aktif</SwitchLabel
              >
              <Switch
                v-model="form.aktif"
                :class="form.aktif ? 'bg-teal-600' : 'bg-gray-200'"
                class="relative inline-flex h-6 w-11 items-center rounded-full ring-0 transition-colors"
              >
                <span
                  :class="form.aktif ? 'translate-x-6' : 'translate-x-1'"
                  class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                />
              </Switch>
            </SwitchGroup>
          </div>

          <div v-if="currentRouteName == 'Tambah'" class>
            <SwitchGroup>
              <SwitchLabel class="mb-2 block text-sm font-bold text-gray-500"
                >Tambah Mahasiswa</SwitchLabel
              >
              <Switch
                v-model="form.tambahMahasiswa"
                :class="form.tambahMahasiswa ? 'bg-teal-600' : 'bg-gray-200'"
                class="relative inline-flex h-6 w-11 items-center rounded-full ring-0 transition-colors"
              >
                <span
                  :class="
                    form.tambahMahasiswa ? 'translate-x-6' : 'translate-x-1'
                  "
                  class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                />
              </Switch>
            </SwitchGroup>
          </div>
        </div>

        <div class="flex justify-between">
          <Button class="px-10" :disabled="form.processing">Simpan</Button>
          <button
            v-if="currentRouteName != 'Tambah'"
            type="button"
            class="bg-transparent text-red-500 hover:bg-transparent focus:bg-transparent"
            @click="isOpen = !isOpen"
          >
            Hapus Data Tahun Ajaran
          </button>
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
      tambahMahasiswa: false,
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

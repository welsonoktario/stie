<template>
  <AppLayout :title="`${currentRouteName} Tahun Ajaran`">
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Akademik / Tahun Ajaran /
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
            Tahun Ajaran</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit">
        <div class="mb-4">
          <Label for="tahun_ajaran"> Tahun Ajaran </Label>
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
        <div class="mb-4">
          <Label for="tahun_mulai"> Tahun Mulai </Label>
          <Input
            v-model="form.tahun_mulai"
            name="tahun_mulai"
            class="mt-1 block w-full"
            type="number"
            min="2000"
            max="3000"
            placeholder="Tahun mulai"
          ></Input>
          <InputError class="mt-2" :message="form.errors.tahun_mulai" />
        </div>
        <div class="mb-4">
          <Label for="tahun_selesai"> Tahun Selesai </Label>
          <Input
            v-model="form.tahun_selesai"
            name="tahun_selesai"
            class="mt-1 block w-full"
            type="number"
            min="2000"
            max="3000"
            placeholder="Tahun selesai"
          ></Input>
          <InputError class="mt-2" :message="form.errors.tahun_selesai" />
        </div>
        <div class="mb-4">
          <Label for="periode"> Periode </Label>
          <select
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            name="periode"
            v-model="form.periode"
          >
            <option value="null" selected disabled>Pilih periode</option>
            <option value="1">1</option>
            <option value="2">2</option>
          </select>
          <InputError class="mt-2" :message="form.errors.periode" />
        </div>
        <div class="mb-4">
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
      tahun_mulai: props.tahunAjaran?.tahun_mulai || null,
      tahun_selesai: props.tahunAjaran?.tahun_selesai || null,
      periode: props.tahunAjaran?.periode || null,
      aktif: props.tahunAjaran?.aktif || true,
    })

    const isOpen = ref(false)

    const currentRouteName = computed(() =>
      route().current("master.tahun_ajaran.create") ? "Tambah" : "Edit"
    )

    const submit = () =>
      currentRouteName.value == "Tambah"
        ? form.post(route("master.tahun_ajaran.store"))
        : form.put(route("master.tahun_ajaran.update", props.tahunAjaran.id))

    const remove = () =>
      form.delete(route("master.tahun_ajaran.destroy", props.tahunAjaran.id))

    return {
      currentRouteName,
      form,
      isOpen,
      submit,
      remove,
    }
  },
}
</script>

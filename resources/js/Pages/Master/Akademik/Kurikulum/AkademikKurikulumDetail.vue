<template>
  <AppLayout title="Tambah Kurikulum">
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm text-slate-500">
        Akademik / Kurikulum /
        <span class="font-semibold text-teal-500 dark:text-teal-600">{{ currentRouteName }}</span>
      </p>

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span>{{ currentRouteName }}</span>
            Kurikulum</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit(route().current())">
        <InputError :message="form.errors.nama" class="mb-3" />
        <div class="mb-4">
          <label class="text-gray-500 text-sm font-bold" for="nama">
            Nama Kurikulum
          </label>
          <Input
            class="w-full mt-2"
            v-model="form.nama"
            id="nama"
            type="text"
            placeholder="Nama Kurikulum"
            autocomplete="off"
          ></Input>
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
          <Button class="px-10">Simpan</Button>
          <Button
            type="button"
            v-if="currentRouteName != 'Tambah'"
            @click="isOpen = !isOpen"
            class="text-red-500 bg-transparent hover:bg-transparent focus:bg-transparent"
            >Hapus Data Kurikulum</Button
          >
        </div>
      </form>
    </div>

    <Dialog
      :isOpen="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus kurikulum"
      confirmText="Hapus"
      @confirm="remove"
      @cancel="isOpen = !isOpen"
    >
      <p class="text-sm">Apakah anda yakin ingin menghapus kurikulum ini?</p>
    </Dialog>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App"
import Input from "@components/Input"
import InputError from "@components/InputError"
import Dialog from "@components/Dialog"
import Button from "@components/Button"
import { Link, useForm } from "@inertiajs/inertia-vue3"
import { computed, ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
import { Switch, SwitchGroup, SwitchLabel } from "@headlessui/vue"

export default {
  components: {
    AppLayout,
    Button,
    Dialog,
    Input,
    InputError,
    Link,
    Switch,
    SwitchGroup,
    SwitchLabel,
  },
  props: {
    kurikulum: Object,
  },
  setup(props) {
    const isOpen = ref(false)

    const form = useForm({
      nama: props?.kurikulum ? props.kurikulum.nama : null,
      aktif: props?.kurikulum ? props.kurikulum.aktif : false,
    })

    const currentRouteName = computed(() =>
      route().current("master.kurikulum.create") ? "Tambah" : "Ubah"
    )

    const submit = () => {
      if (currentRouteName.value == "Tambah") {
        form.post(route("master.kurikulum.store"))
      } else {
        form.put(route("master.kurikulum.update", props.kurikulum.id))
      }
    }

    const remove = () => {
      isOpen.value = !isOpen.value
      Inertia.delete(route("master.kurikulum.destroy", props.kurikulum.id))
    }

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

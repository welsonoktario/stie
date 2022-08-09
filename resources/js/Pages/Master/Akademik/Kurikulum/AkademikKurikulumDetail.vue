<template>
  <AppLayout title="Tambah Kurikulum">
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs text-slate-500 md:text-sm">
        Akademik / Kurikulum /
        <span class="font-semibold text-teal-500 dark:text-teal-600">{{
          currentRouteName
        }}</span>
      </p>

      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
          >
            <span>{{ currentRouteName }}</span>
            Kurikulum
          </strong>
        </span>
      </div>
      <form @submit.prevent="submit(route().current())">
        <InputError :message="form.errors.nama" class="mb-3" />
        <div class="mb-4">
          <label class="text-sm font-bold text-gray-500" for="nama"
            >Nama Kurikulum</label
          >
          <Input
            id="nama"
            v-model="form.nama"
            class="mt-2 w-full"
            type="text"
            placeholder="Nama Kurikulum"
            autocomplete="off"
          ></Input>
        </div>
        <div class="mb-4">
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
        <div class="flex justify-between">
          <Button class="px-10">Simpan</Button>
          <Button
            v-if="currentRouteName != 'Tambah'"
            type="button"
            class="bg-transparent text-red-500 hover:bg-transparent focus:bg-transparent"
            @click="isOpen = !isOpen"
            >Hapus Data Kurikulum</Button
          >
        </div>
      </form>
    </div>

    <Dialog
      :is-open="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus kurikulum"
      confirm-text="Hapus"
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

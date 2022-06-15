<template>
  <AppLayout>
    <div
      class="bg-zinc-50 dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm text-zinc-500 dark:text-zinc-400">
        Jadwal /
        <span class="font-semibold text-teal-500 dark:text-teal-600">{{
          currentRouteName
        }}</span>
      </p>

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span>{{ currentRouteName }}</span>
            Jadwal</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit(route().current())">
        <div>
          <Label for="tahun_akademik">Tahun Akademik</Label>
          <Input
            id="tahun_akademik"
            name="tahun_akademik"
            type="text"
            class="w-full"
            placeholder="Nama Matakuliah"
            v-model="tahunAkademik.tahun_ajaran"
            readonly
          />
        </div>
        <div class="mt-4">
          <Label for="matakuliah"> Matakuliah </Label>
          <Select
            class="w-full"
            :options="matakuliahs"
            :name="'matakuliah'"
            :placeholder="'Pilih matakuliah'"
            v-model="form.matakuliah_id"
          >
            <template #option="option">
              <option :value="Number(option.data.id)">
                {{
                  `S${option.data.semester} - ${option.data.kode_matakuliah} - ${option.data.nama_matakuliah}`
                }}
              </option>
            </template>
          </Select>
          <InputError class="mt-2" :message="form.errors.matakuliah_id" />
        </div>
        <div class="mt-4">
          <Label for="ruangan"> Ruangan </Label>
          <Select
            class="w-full"
            :options="ruangans"
            :name="'ruangan'"
            :placeholder="'Pilih ruangan'"
            v-model="form.ruangan_id"
          >
            <template #option="option">
              <option :value="Number(option.data.id)">
                {{ option.data.nama_ruangan }}
              </option>
            </template>
          </Select>
          <InputError class="mt-2" :message="form.errors.ruangan_id" />
        </div>
        <div class="mt-4">
          <Label for="tahun_akademik">Hari</Label>
          <Select
            class="w-full"
            :options="hari"
            :name="'hari'"
            :placeholder="'Pilih hari'"
            v-model="form.hari"
          >
            <template #option="option">
              <option :value="option.data">
                {{ option.data }}
              </option>
            </template>
          </Select>
          <InputError class="mt-2" :message="form.errors.hari" />
        </div>
        <div class="mt-4">
          <Label for="jam">Jam</Label>
          <Input
            id="jam"
            class="w-full"
            name="jam"
            type="time"
            v-model="form.jam"
            placeholder="Jam jadwal"
          />
          <InputError class="mt-2" :message="form.errors.jam" />
        </div>
        <div class="mt-4">
          <Label for="local">Local</Label>
          <Input
            id="local"
            class="w-full"
            name="local"
            type="text"
            maxlength="2"
            minlength="1"
            v-model="form.local"
            placeholder="Local jadwal"
            autocomplete="off"
          />
          <InputError class="mt-2" :message="form.errors.jam" />
        </div>

        <!-- uts -->

        <div class="flex justify-between mt-3 item-center">
          <span class="align-middle">
            <strong
              class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
            >
              Jadwal UTS</strong
            >
          </span>
        </div>

        <div class="flex justify-between space-x-3">

          <div class="mt-4 w-full">
            <Label for="uts_tanggal">Tanggal UTS</Label>
            <Input
              id="uts_tanggal"
              class="w-full"
              name="uts_tanggal"
              v-model="form.uts_tanggal"
              type="date"
            />
            <InputError class="mt-2" :message="form.errors.uts_tanggal" />
          </div>

          <div class="mt-4 w-full">
            <Label for="uts_pukul_mulai">Mulai Pukul</Label>
            <Input
              id="uts_pukul_mulai"
              class="w-full"
              name="uts_pukul_mulai"
              v-model="form.uts_pukul_mulai"
              type="time"
            />
            <InputError class="mt-2" :message="form.errors.uts_pukul_mulai" />
          </div>
          <div class="mt-4 w-full">
            <Label for="uts_pukul_selesai">Selesai Pukul</Label>
            <Input
              id="uts_pukul_selesai"
              class="w-full"
              name="uts_pukul_selesai"
              v-model="form.uts_pukul_selesai"
              type="time"
            />
            <InputError class="mt-2" :message="form.errors.uts_pukul_selesai" />
          </div>
        </div>

        <div class="mt-4">
          <Label for="uts_ruangan"> Ruangan UTS </Label>
          <Select
            class="w-full"
            :options="ruangans"
            :name="'uts_ruangan'"
            :placeholder="'Pilih ruangan UTS'"
            v-model="form.uts_ruangan"
          >
            <template #option="option">
              <option :value="Number(option.data.id)">
                {{ option.data.nama_ruangan }}
              </option>
            </template>
          </Select>
          <InputError class="mt-2" :message="form.errors.uts_ruangan" />
        </div>


        <!-- UAS -->

        <div class="flex justify-between mt-3 item-center">
          <span class="align-middle">
            <strong
              class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
            >
              Jadwal UAS</strong
            >
          </span>
        </div>

        <div class="flex justify-between space-x-3">

          <div class="mt-4 w-full">
            <Label for="uas_tanggal">Tanggal UAS</Label>
            <Input
              id="uas_tanggal"
              class="w-full"
              name="uas_tanggal"
              type="date"
              v-model="form.uas_tanggal"
            />
            <InputError class="mt-2" :message="form.errors.uas_tanggal" />
          </div>

          <div class="mt-4 w-full">
            <Label for="uas_pukul_mulai">Mulai Pukul</Label>
            <Input
              id="uas_pukul_mulai"
              class="w-full"
              name="uas_pukul_mulai"
              v-model="form.uas_pukul_mulai"
              type="time"
            />
            <InputError class="mt-2" :message="form.errors.uas_pukul_mulai" />
          </div>
          <div class="mt-4 w-full">
            <Label for="uas_pukul_selesai">Selesai Pukul</Label>
            <Input
              id="uas_pukul_selesai"
              class="w-full"
              name="uas_pukul_selesai"
              v-model="form.uas_pukul_selesai"
              type="time"
            />
            <InputError class="mt-2" :message="form.errors.uas_pukul_selesai" />
          </div>
        </div>

        <div class="mt-4">
          <Label for="uas_ruangan"> Ruangan UAS </Label>
          <Select
            class="w-full"
            :options="ruangans"
            :name="'uas_ruangan'"
            :placeholder="'Pilih ruangan UAS'"
            v-model="form.uas_ruangan"
          >
            <template #option="option">
              <option :value="Number(option.data.id)">
                {{ option.data.nama_ruangan }}
              </option>
            </template>
          </Select>
          <InputError class="mt-2" :message="form.errors.uas_ruangan" />
        </div>


        <div class="inline-flex items-center justify-between w-full mt-8">
          <Button class="px-10" :disabled="form.processing">Simpan</Button>
          <button
            type="button"
            v-if="currentRouteName != 'Tambah'"
            @click="isDialogHapusOpen = !isDialogHapusOpen"
            class="text-red-500 bg-transparent hover:bg-transparent focus:bg-transparent"
          >
            Hapus Jadwal
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :isOpen="isDialogHapusOpen"
      title="Hapus matakuliah"
      confirmText="Hapus"
      classes="text-red-900 bg-red-100 hover:bg-red-200 focus-visible:ring-red-500"
      @confirm="remove"
      @cancel="isDialogHapusOpen = !isDialogHapusOpen"
    >
      <template #content>
        <p class="text-sm">Apakah anda yakin ingin menghapus jadwal?</p>
      </template>
    </Dialog>
  </AppLayout>
</template>

<script setup>
import AppLayout from "@layouts/App"
import Button from "@components/Button"
import Dialog from "@components/Dialog"
import Input from "@components/Input"
import InputError from "@components/InputError"
import Label from "@components/Label"
import Select from "@components/Select"
import { useForm } from "@inertiajs/inertia-vue3"
import { computed, ref } from "vue"

const props = defineProps({
  jadwal: Object,
  tahunAkademik: Object,
  ruangans: Array,
  matakuliahs: Array,
})

const form = useForm({
  id: props.jadwal?.id || null,
  jam: props.jadwal?.jam || null,
  hari: props.jadwal?.hari || "-",
  local: props.jadwal?.local || null,
  matakuliah_id: props.jadwal?.matakuliah_id || "-",
  ruangan_id: props.jadwal?.ruangan_id || "-",
  tahun_ajaran_id: props.tahunAkademik?.id || "-",

  // uts
  uts_tanggal: props.jadwal?.uts_tanggal || null,
  uts_ruangan: props.jadwal?.uts_ruangan || null,
  uts_pukul_mulai: props.jadwal?.uts_pukul_mulai || null,
  uts_pukul_selesai: props.jadwal?.uts_pukul_selesai || null,

  // uas
  uas_tanggal: props.jadwal?.uas_tanggal || null,
  uas_ruangan: props.jadwal?.uas_ruangan || null,
  uas_pukul_mulai: props.jadwal?.uas_pukul_mulai || null,
  uas_pukul_selesai: props.jadwal?.uas_pukul_selesai || null,
})

const hari = ["Senin", "Selasa", "Rabu", "Kamis", "Jumat"]

const isDialogHapusOpen = ref(false)

const currentRouteName = computed(() =>
  route().current("transaksi.jadwal.create") ? "Tambah" : "Ubah"
)

const submit = (curRoute) => {
  if (curRoute === "transaksi.jadwal.create") {
    form.post(route("transaksi.jadwal.store"))
  } else {
    form.put(route("transaksi.jadwal.update", props.jadwal.id))
  }
}
const remove = () =>
  form.delete(route("transaksi.jadwal.destroy", props.jadwal.id))
</script>

<style>
@media (prefers-color-scheme: dark) {
  input {
    color-scheme: dark;
  }
}
</style>

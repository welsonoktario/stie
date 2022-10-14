<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-zinc-50 p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs text-zinc-500 dark:text-zinc-400 md:text-sm">
        Jadwal /
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
            Jadwal</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit(route().current())">
        <div>
          <Label for="tahun_akademik">Tahun Akademik</Label>
          <Input
            id="tahun_akademik"
            v-model="tahunAkademik.tahun_ajaran"
            name="tahun_akademik"
            type="text"
            class="w-full"
            placeholder="Tahun Akademik"
            readonly
          />
        </div>
        <div class="mt-4">
          <Label for="matakuliah"> Matakuliah </Label>
          <Select
            v-model="form.matakuliah_id"
            class="w-full"
            :options="matakuliahs"
            :name="'matakuliah'"
            :placeholder="'Pilih matakuliah'"
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
            v-model="form.ruangan_id"
            class="w-full"
            :options="ruangans"
            :name="'ruangan'"
            :placeholder="'Pilih ruangan'"
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
            v-model="form.hari"
            class="w-full"
            :options="hari"
            :name="'hari'"
            :placeholder="'Pilih hari'"
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
            v-model="form.jam"
            class="w-full"
            name="jam"
            type="time"
            placeholder="Jam jadwal"
          />
          <InputError class="mt-2" :message="form.errors.jam" />
        </div>
        <div class="mt-4">
          <Label for="local">Local</Label>
          <Input
            id="local"
            v-model="form.local"
            class="w-full"
            name="local"
            type="text"
            maxlength="2"
            minlength="1"
            placeholder="Local jadwal"
            autocomplete="off"
          />
          <InputError class="mt-2" :message="form.errors.jam" />
        </div>
        <div class="mt-4">
          <Label for="dosens">Dosen Pengajar</Label>
          <div
            class="mb-4 flex w-full flex-row items-center rounded-md bg-zinc-100 py-2 px-3 dark:bg-zinc-700 dark:text-zinc-500"
          >
            <div class="flex-1">
              <div
                v-for="(dosen, index) in selectedDosens"
                :key="`dosen-${index}`"
                class="mx-1 inline-flex items-center rounded-lg bg-teal-500 py-1 px-2 text-sm text-zinc-50 first:ml-0 last:mr-0 hover:bg-teal-600"
              >
                <span>
                  {{ `${dosen.id} - ${dosen.staff.user.name}` }}
                </span>
                <XIcon
                  class="ml-2 h-4 w-4 cursor-pointer hover:text-red-400"
                  @click="removeDosen(index)"
                />
              </div>
            </div>
            <ChevronDownIcon
              class="h-5 w-5 cursor-pointer text-zinc-500"
              @click="isDosenOpen = !isDosenOpen"
            />
          </div>
          <ul
            v-show="isDosenOpen"
            class="w-full rounded-md bg-zinc-100 p-2 shadow-inner dark:bg-zinc-700"
          >
            <li
              v-for="dosen in props.dosens"
              :key="`selected-${dosen.id}`"
              class="w-full cursor-pointer focus:bg-teal-400 focus:text-white"
              @click="addDosen(dosen)"
            >
              {{ `${dosen.id} - ${dosen.staff.user.name}` }}
            </li>
          </ul>
        </div>

        <!-- uts -->

        <div class="item-center mt-3 flex justify-between">
          <span class="align-middle">
            <strong
              class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
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
              v-model="form.uts_tanggal"
              class="w-full"
              name="uts_tanggal"
              type="date"
            />
            <InputError class="mt-2" :message="form.errors.uts_tanggal" />
          </div>

          <div class="mt-4 w-full">
            <Label for="uts_pukul_mulai">Mulai Pukul</Label>
            <Input
              id="uts_pukul_mulai"
              v-model="form.uts_pukul_mulai"
              class="w-full"
              name="uts_pukul_mulai"
              type="time"
            />
            <InputError class="mt-2" :message="form.errors.uts_pukul_mulai" />
          </div>
          <div class="mt-4 w-full">
            <Label for="uts_pukul_selesai">Selesai Pukul</Label>
            <Input
              id="uts_pukul_selesai"
              v-model="form.uts_pukul_selesai"
              class="w-full"
              name="uts_pukul_selesai"
              type="time"
            />
            <InputError class="mt-2" :message="form.errors.uts_pukul_selesai" />
          </div>
        </div>

        <div class="mt-4">
          <Label for="uts_ruangan"> Ruangan UTS </Label>
          <Select
            v-model="form.uts_ruangan"
            class="w-full"
            :options="ruangans"
            :name="'uts_ruangan'"
            :placeholder="'Pilih ruangan UTS'"
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

        <div class="item-center mt-3 flex justify-between">
          <span class="align-middle">
            <strong
              class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
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
              v-model="form.uas_tanggal"
              class="w-full"
              name="uas_tanggal"
              type="date"
            />
            <InputError class="mt-2" :message="form.errors.uas_tanggal" />
          </div>

          <div class="mt-4 w-full">
            <Label for="uas_pukul_mulai">Mulai Pukul</Label>
            <Input
              id="uas_pukul_mulai"
              v-model="form.uas_pukul_mulai"
              class="w-full"
              name="uas_pukul_mulai"
              type="time"
            />
            <InputError class="mt-2" :message="form.errors.uas_pukul_mulai" />
          </div>
          <div class="mt-4 w-full">
            <Label for="uas_pukul_selesai">Selesai Pukul</Label>
            <Input
              id="uas_pukul_selesai"
              v-model="form.uas_pukul_selesai"
              class="w-full"
              name="uas_pukul_selesai"
              type="time"
            />
            <InputError class="mt-2" :message="form.errors.uas_pukul_selesai" />
          </div>
        </div>

        <div class="mt-4">
          <Label for="uas_ruangan"> Ruangan UAS </Label>
          <Select
            v-model="form.uas_ruangan"
            class="w-full"
            :options="ruangans"
            :name="'uas_ruangan'"
            :placeholder="'Pilih ruangan UAS'"
          >
            <template #option="option">
              <option :value="Number(option.data.id)">
                {{ option.data.nama_ruangan }}
              </option>
            </template>
          </Select>
          <InputError class="mt-2" :message="form.errors.uas_ruangan" />
        </div>

        <div class="mt-8 inline-flex w-full items-center justify-between">
          <Button class="px-10" :disabled="form.processing">Simpan</Button>
          <button
            v-if="currentRouteName != 'Tambah'"
            type="button"
            class="bg-transparent text-red-500 hover:bg-transparent focus:bg-transparent"
            @click="isDialogHapusOpen = !isDialogHapusOpen"
          >
            Hapus Jadwal
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :is-open="isDialogHapusOpen"
      title="Hapus matakuliah"
      confirm-text="Hapus"
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
import Button from "@components/Button"
import Dialog from "@components/Dialog"
import Input from "@components/Input"
import InputError from "@components/InputError"
import Label from "@components/Label"
import Select from "@components/Select"
import { ChevronDownIcon, XIcon } from "@heroicons/vue/solid"
import { useForm } from "@inertiajs/inertia-vue3"
import AppLayout from "@layouts/App"
import { computed, onMounted, ref } from "vue"

const props = defineProps({
  jadwal: Object,
  tahunAkademik: Object,
  ruangans: Array,
  matakuliahs: Array,
  dosens: Array,
})

const form = useForm({
  id: props.jadwal?.id || null,
  jam: props.jadwal?.jam || null,
  hari: props.jadwal?.hari || "-",
  local: props.jadwal?.local || null,
  matakuliah_id: props.jadwal?.matakuliah_id || "-",
  ruangan_id: props.jadwal?.ruangan_id || "-",
  tahun_ajaran_id: props.tahunAkademik?.id || "-",
  dosens: props.jadwal?.dosens || [],

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
const selectedDosens = ref([])
const isDosenOpen = ref(false)

onMounted(() => {
  if (props.jadwal?.dosens) {
    selectedDosens.value = props.jadwal.dosens
  }
})

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

const addDosen = (dosen) => {
  const index = selectedDosens.value.findIndex((d) => d.id === dosen.id)

  if (index === -1) {
    selectedDosens.value.push(dosen)
    // tambahan untuk tambah dosen ke form
    form.dosens = selectedDosens.value
  }
}

const removeDosen = (index) => {
  selectedDosens.value.splice(index, 1)
  // tambahan untuk tambah dosen ke form
  form.dosens = selectedDosens.value
}
</script>

<style>
@media (prefers-color-scheme: dark) {
  input {
    color-scheme: dark;
  }
}
</style>

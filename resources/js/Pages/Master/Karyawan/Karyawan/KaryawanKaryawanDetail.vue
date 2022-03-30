<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <p class="text-xs md:text-sm text-slate-500">
        Karyawan / Karyawan /
        <span class="font-semibold text-teal-500 dark:text-teal-600">{{
          currentRouteName.route
        }}</span>
      </p>

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span>{{ currentRouteName.route }}</span>
            Karyawan</strong
          >
        </span>
      </div>
      <form @submit.prevent="submit">
        <!-- ID, NITK -->
        <div class="mb-4 flex space-x-2">
          <div class="w-full">
            <Label for="id">
              ID Karyawan <em> (Nomor Induk Karyawan)</em>
            </Label>
            <Input
              v-model="form.id"
              id="id"
              name="id"
              class="mt-1 block w-full"
              type="text"
              placeholder="ID"
              autocomplete="off"
              required
            ></Input>
          </div>
          <div class="w-full">
            <Label for="nitk">
              NITK <i> (Tenaga Kependidikan - Opsional)</i>
            </Label>
            <Input
              v-model="form.nitk"
              id="nitk"
              class="mt-1 block w-full"
              type="text"
              placeholder="NITK (Opsional)"
              autocomplete="off"
            ></Input>
          </div>
        </div>
        <!-- NAMA, NIK-->
        <div class="mb-4 flex space-x-2">
          <div class="w-full">
            <Label for="nama"> Nama </Label>
            <Input
              v-model="form.name"
              id="nama"
              name="nama"
              class="mt-1 block w-full"
              type="text"
              placeholder="Nama"
              autocomplete="off"
              required
            ></Input>
          </div>
          <div class="w-full">
            <Label for="nik">NIK <i>(Nomor Induk Kependudukan)</i></Label>
            <Input
              v-model="form.nik"
              id="nik"
              name="nik"
              class="mt-1 block w-full"
              type="text"
              placeholder="NIK"
              autocomplete="off"
            >
            </Input>
          </div>
        </div>
        <!-- EMAIL, JENIS KELAMIN -->
        <div class="mb-4 flex space-x-2">
          <div class="w-full">
            <Label for="email"> Email </Label>
            <Input
              v-model="form.email"
              id="email"
              name="email"
              class="mt-1 block w-full"
              type="email"
              placeholder="Email"
              autocomplete="off"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="jenis_kelamin"
            >
              Jenis Kelamin
            </label>
            <select
              class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
              id="jenis_kelamin"
              v-model="form.jenis_kelamin"
            >
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
        </div>
        <!-- TTL -->
        <div class="mb-3">
          <div class="flex space-x-2">
            <div class="w-full">
              <Label for="tempat_lahir">Tempat Lahir</Label>
              <Input
                v-model="form.tempat_lahir"
                class="w-full"
                id="tempat_lahir"
                type="text"
                placeholder="Tempat Lahir"
              ></Input>
            </div>
            <div class="w-full">
              <Label for="tanggal_lahir">Tanggal Lahir</Label>
              <Input
                v-model="form.tanggal_lahir"
                class="w-full"
                id="tanggal_lahir"
                type="date"
                placeholder="tanggal Lahir"
              ></Input>
            </div>
          </div>
        </div>

        <!-- NOMOR HP -->
        <div class="mb-3">
          <label
            class="block text-gray-500 text-sm font-bold mb-2"
            for="nomor_hp"
          >
            Nomor HP
          </label>
          <Input
            v-model="form.nomor_hp"
            class="w-full"
            id="nomor_hp"
            type="text"
            placeholder="Nomor HP"
          ></Input>
        </div>

        <!-- alamat lengkap -->
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="alamat">
            Alamat
          </label>
          <Input
            v-model="form.jalan"
            class="w-full"
            id="alamat"
            type="text"
            placeholder="Alamat (Jl. Nama Jalan, RT. 1, Nomor 1)"
          ></Input>
        </div>

        <!-- kelurahan, kecamatan, kode pos -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="kelurahan"
            >
              Kelurahan
            </label>
            <Input
              v-model="form.kelurahan"
              class="w-full"
              id="kelurahan"
              type="text"
              placeholder="Kelurahan"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="kecamatan"
            >
              Kecamatan
            </label>
            <Input
              v-model="form.kecamatan"
              class="w-full"
              id="kecamatan"
              type="text"
              placeholder="Kecamatan"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="kode_pos"
            >
              Kode Pos
            </label>
            <Input
              v-model="form.kode_pos"
              class="w-full"
              id="kode_pos"
              type="text"
              placeholder="Kode Pos"
            ></Input>
          </div>
        </div>

        
        <!-- Provinsi -->
        <div class="flex space-x-3 mb-3">            
          <div class="w-full">
            <Label for="provinsi"> Provinsi </Label>
            <Select
              class="w-full"
              :options="provinsis"
              :name="'provinsi'"
              :placeholder="'Pilih provinsi'"
              v-model="form.provinsi"
            >
              <!-- <template #option="option">
                <option :value="Number(option.data.id)">
                  {{ option.data.nama_ruangan }}
                </option>
              </template> -->
            </Select>
            <!-- <InputError class="mt-2" :message="form.errors.ruangan_id" /> -->
          </div>

          <!-- Kabupaten/Kota -->
          <div class="w-full">
            <Label for="kota"> Kabupaten/Kota </Label>
            <Select
              class="w-full"
              :options="kotas"
              :name="'kota'"
              :placeholder="'Pilih kota'"
              v-model="form.kota"
            >
              <!-- <template #option="option">
                <option :value="Number(option.data.id)">
                  {{ option.data.nama_ruangan }}
                </option>
              </template> -->
            </Select>
            <!-- <InputError class="mt-2" :message="form.errors.ruangan_id" /> -->
          </div>
        </div>

        <!-- SK AWAL -->
        <div class="mb-3">
          <div class="flex space-x-2">
            <div class="w-full">
              <Label for="nomor_sk_awal">Nomor SK Awal</Label>
              <Input
                v-model="form.nomor_sk_awal"
                class="w-full"
                id="nomor_sk_awal"
                type="text"
                placeholder="Nomor SK Awal"
              ></Input>
            </div>
            <div class="w-full">
              <Label for="tanggal_sk_awal">Tanggal SK Awal</Label>
              <Input
                v-model="form.tanggal_sk_awal"
                class="w-full"
                id="tanggal_sk_awal"
                type="date"
                placeholder="Tanggal SK Awal"
              ></Input>
            </div>
          </div>
        </div>

        <!-- SK Akhir -->
        <div class="mb-3">
          <div class="flex space-x-2">
            <div class="w-full">
              <Label for="nomor_sk_akhir">Nomor SK Akhir</Label>
              <Input
                v-model="form.nomor_sk_akhir"
                class="w-full"
                id="nomor_sk_akhir"
                type="text"
                placeholder="Nomor SK Akhir"
              ></Input>
            </div>
            <div class="w-full">
              <Label for="tanggal_sk_akhir">Tanggal SK Akhir</Label>
              <Input
                v-model="form.tanggal_sk_akhir"
                class="w-full"
                id="tanggal_sk_akhir"
                type="date"
                placeholder="Tanggal SK Akhir"
              ></Input>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <p>Masa Kerja: {{calculatedMasaKerja}}</p>
        </div>

        <!-- GOLONGAN -->
        <div class="mb-3">
          <Label for='golongan'>Golongan</Label>
          <Input class="w-full" type="text" v-model="form.golongan" id="golongan" name="golongan"></Input>
        </div>

        <!-- DIVISI, LEVEL PENGGUNA -->
        <div class="mb-4 flex space-x-2">
          <div class="w-full">
            <Label for="divisi"> Divisi </Label>
            <select
              class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
              id="divisi"
              v-model="form.divisi"
            >
              <option value="BAAK">BAAK</option>
              <option value="Data">Data</option>
              <option value="Dosen">Dosen</option>
            </select>
          </div>
          <div class="w-full">
            <Label for="level_pengguna">Level Pengguna</Label>
            <select
              class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
              id="level_pengguna"
              v-model="form.level_pengguna"
            >
              <option value="Staff">Staff</option>
              <option value="Pengguna">Pengguna</option>
              <option value="Administrator">Administrator</option>
              <option value="Tidak Aktif">Tidak Aktif (Jika sudah tidak bekerja)</option>
            </select>
          </div>
        </div>

        <!-- kelurahan, kecamatan, kode pos -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <Label for="jenjang_pendidikan">Jenjang Pendidikan</Label>
            <Input
              v-model="form.jenjang_pendidikan"
              class="w-full"
              id="jenjang_pendidikan"
              type="text"
              placeholder="Jenjang Pendidikan"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="gelar_depan">Gelar Depan</Label>
            <Input
              v-model="form.gelar_depan"
              class="w-full"
              id="gelar_depan"
              type="text"
              placeholder="Gelar Depan"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="gelar_belakang">Gelar Belakang</Label>
            <Input
              v-model="form.gelar_belakang"
              class="w-full"
              id="gelar_belakang"
              type="text"
              placeholder="Gelar Belakang"
            ></Input>
          </div>
        </div>

        <div class="flex justify-between">
          <Button class="px-10">Simpan</Button>
          <button
            type="button"
            v-if="currentRouteName.route != 'Tambah'"
            @click="isOpen = !isOpen"
            class="text-red-500 bg-transparent hover:bg-transparent focus:bg-transparent"
          >
            Hapus Data Karyawan
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :isOpen="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus karyawan"
      confirmText="Hapus"
      @confirm="remove"
      @cancel="isOpen = !isOpen"
    >
      <template #content>
        <p class="text-sm">Apakah anda yakin ingin menghapus karyawan ini?</p>
      </template>
    </Dialog>
  </AppLayout>
</template>

<script>
import { computed, reactive, ref } from "vue"
import { Link, useForm } from "@inertiajs/inertia-vue3"
import AppLayout from "@layouts/App"
import Button from "@components/Button"
import Dialog from "@components/Dialog"
import Input from "@components/Input"
import InputError from "@components/InputError"
import Label from "@/Components/Label"
import Select from "@/Components/Select.vue"

export default {
  components: {
    AppLayout,
    Button,
    Dialog,
    Input,
    InputError,
    Label,
    Select,
    Link,
  },
  props: {
    staff: Object,
  },
  setup(props) {
    const form = useForm({
      // data user
      email: props.staff?.user?.email,
      name: props.staff?.user?.name,
      nik: props.staff?.user?.nik,
      jenis_kelamin: props.staff?.user.jenis_kelamin || "Laki-laki",
      agama: props.staff?.user.agama || null,
      nomor_hp: props.staff?.user.nomor_hp || null,
      tempat_lahir: props.staff?.user.tempat_lahir || null,
      tanggal_lahir: props.staff?.user.tanggal_lahir || null,
      jalan: props.staff?.user.jalan || null,
      kelurahan: props.staff?.user.kelurahan || null,
      kode_pos: props.staff?.user.kode_pos || null,
      kewarganegaraan: props.staff?.user.kewarganegaraan || "WNI",

      // data staff
      id: props.staff?.id,
      divisi: props.staff?.divisi || "BAAK",
      level_pengguna: props.staff?.level_pengguna || "Staff",
      jenjang_pendidikan: props.staff?.jenjang_pendidikan || null,
      gelar_depan: props.staff?.gelar_depan || null,
      gelar_belakang: props.staff?.gelar_belakang || null,
      status_karyawan: props.staff?.status_karyawan || null,
      nomor_sk_awal: props.staff?.nomor_sk_awal || null,
      tanggal_sk_awal: props.staff?.tanggal_sk_awal || null,
      nomor_sk_akhir: props.staff?.nomor_sk_akhir || null,
      tanggal_sk_akhir: props.staff?.tanggal_sk_akhir || null,
      status_karyawan: props.staff?.status_karyawan || "Aktif",

      // data tenaga kependidikan
      nitk: props.staff?.tenaga_kependidikan?.id,
    })

    const isOpen = ref(false)

    const currentRouteName = reactive({
      route: computed(() =>
        route().current("master.karyawan.create") ? "Tambah" : "Ubah"
      ),
    })

    const submit = () =>
      currentRouteName.route == "Tambah"
        ? form.post(route("master.karyawan.store"))
        : form.put(route("master.karyawan.update", props.staff.id))

    const remove = () =>
      form.delete(route("master.karyawan.destroy", props.staff.id))

    const calculatedMasaKerja = computed(() => {
      const now =  new Date(Date.now())
      const tanggal_sk_awal = new Date(props.staff.tanggal_sk_awal)
      const timediff = now.getTime() - tanggal_sk_awal.getTime()
      const daydiff = Math.floor(timediff /  (1000 * 3600 * 24))
      // const monthdiff = daydiff / 30
      // const yeardiff = monthdiff / 12

      const num_year = daydiff / 366
      const num_month = Math.floor((daydiff % 365) / 30)
      const num_days = Math.floor(daydiff % 365) % 30
      // return Math.round(daydiff) + " hari, " + Math.round(monthdiff) + " bulan, " + Math.round(yeardiff) + " tahun"
      return ' total hari ' + Math.round(num_year) + ' Tahun, ' + Math.round(num_month) + ' Bulan, ' + Math.round(num_days) + ' Hari.'
      // return now
    })
    
    return {
      currentRouteName,
      calculatedMasaKerja,
      form,
      isOpen,
      submit,
      remove,
    }
  },
}
</script>

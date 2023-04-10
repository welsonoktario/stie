<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs text-slate-500 md:text-sm">
        Karyawan / Karyawan /
        <span class="font-semibold text-teal-500 dark:text-teal-600">
          {{ currentRouteName.route }}
        </span>
      </p>

      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
          >
            <span>{{ currentRouteName.route }}</span>
            Karyawan
          </strong>
        </span>
      </div>
      <form @submit.prevent="submit">
        <!-- ID, NITK -->
        <div class="mb-4 flex space-x-2">
          <div class="w-full">
            <Label for="id">
              ID Karyawan
              <em>(Nomor Induk Karyawan)</em>
              <span class="text-red-500">*</span>
            </Label>
            <Input
              id="id"
              v-model="form.id"
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
              NITK
              <i>(Tenaga Kependidikan - Opsional)</i>
            </Label>
            <Input
              id="nitk"
              v-model="form.nitk"
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
            <Label for="nama">
              Nama
              <span class="text-red-500">*</span>
            </Label>
            <Input
              id="nama"
              v-model="form.name"
              name="nama"
              class="mt-1 block w-full"
              type="text"
              placeholder="Nama"
              autocomplete="off"
              required
            ></Input>
          </div>
          <div class="w-full">
            <Label for="nik">
              NIK
              <i>(Nomor Induk Kependudukan)</i>
            </Label>
            <Input
              id="nik"
              v-model="form.nik"
              name="nik"
              class="mt-1 block w-full"
              type="text"
              placeholder="NIK"
              autocomplete="off"
            ></Input>
          </div>
        </div>
        <!-- EMAIL, JENIS KELAMIN -->
        <div class="mb-4 flex space-x-2">
          <div class="w-full">
            <Label for="email">
              Email
              <span class="text-red-500">*</span>
            </Label>
            <Input
              id="email"
              v-model="form.email"
              name="email"
              class="mt-1 block w-full"
              type="email"
              placeholder="Email"
              autocomplete="off"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="mb-2 block text-sm font-bold text-gray-500"
              for="jenis_kelamin"
              >Jenis Kelamin</label
            >
            <select
              id="jenis_kelamin"
              v-model="form.jenis_kelamin"
              class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
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
                id="tempat_lahir"
                v-model="form.tempat_lahir"
                class="w-full"
                type="text"
                placeholder="Tempat Lahir"
              ></Input>
            </div>
            <div class="w-full">
              <Label for="tanggal_lahir">Tanggal Lahir</Label>
              <Input
                id="tanggal_lahir"
                v-model="form.tanggal_lahir"
                class="w-full"
                type="date"
                placeholder="tanggal Lahir"
              ></Input>
            </div>
          </div>
        </div>

        <!-- NOMOR HP -->
        <div class="mb-3">
          <label
            class="mb-2 block text-sm font-bold text-gray-500"
            for="nomor_hp"
            >Nomor HP</label
          >
          <Input
            id="nomor_hp"
            v-model="form.nomor_hp"
            class="w-full"
            type="text"
            placeholder="Nomor HP"
          ></Input>
        </div>

        <!-- alamat lengkap -->
        <div class="mb-3">
          <label class="mb-2 block text-sm font-bold text-gray-500" for="alamat"
            >Alamat</label
          >
          <Input
            id="alamat"
            v-model="form.jalan"
            class="w-full"
            type="text"
            placeholder="Alamat (Jl. Nama Jalan, RT. 1, Nomor 1)"
          ></Input>
        </div>

        <!-- kelurahan, kecamatan, kode pos -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label
              class="mb-2 block text-sm font-bold text-gray-500"
              for="kelurahan"
              >Kelurahan</label
            >
            <Input
              id="kelurahan"
              v-model="form.kelurahan"
              class="w-full"
              type="text"
              placeholder="Kelurahan"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="mb-2 block text-sm font-bold text-gray-500"
              for="kecamatan"
              >Kecamatan</label
            >
            <Input
              id="kecamatan"
              v-model="form.kecamatan"
              class="w-full"
              type="text"
              placeholder="Kecamatan"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="mb-2 block text-sm font-bold text-gray-500"
              for="kode_pos"
              >Kode Pos</label
            >
            <Input
              id="kode_pos"
              v-model="form.kode_pos"
              class="w-full"
              type="text"
              placeholder="Kode Pos"
            ></Input>
          </div>
        </div>

        <!-- Provinsi -->
        <div class="mb-3 flex space-x-3">
          <div class="w-full">
            <Label for="provinsi">Provinsi</Label>
            <Select
              v-model="form.provinsi"
              class="w-full"
              @click="getKabupatenKota(form.provinsi)"
              :options="provinsis"
              :name="'provinsi'"
            >
              <template #option="option">
                <option :value="option.data.id">{{ option.data.nama }}</option>
              </template>
            </Select>
            <!-- <InputError class="mt-2" :message="form.errors.ruangan_id" /> -->
          </div>

          <!-- Kabupaten/Kota -->
          <div class="w-full">
            <Label for="kota">Kabupaten/Kota</Label>
            <Select
              v-model="form.kota"
              class="w-full"
              :options="kotas"
              :name="'kota'"
              :placeholder="'Pilih kota'"
            >
              <template #option="option">
                <option :value="option.data.id">{{ option.data.nama }}</option>
              </template>
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
                id="nomor_sk_awal"
                v-model="form.nomor_sk_awal"
                class="w-full"
                type="text"
                placeholder="Nomor SK Awal"
              ></Input>
            </div>
            <div class="w-full">
              <Label for="tanggal_sk_awal">Tanggal SK Awal</Label>
              <Input
                id="tanggal_sk_awal"
                v-model="form.tanggal_sk_awal"
                class="w-full"
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
                id="nomor_sk_akhir"
                v-model="form.nomor_sk_akhir"
                class="w-full"
                type="text"
                placeholder="Nomor SK Akhir"
              ></Input>
            </div>
            <div class="w-full">
              <Label for="tanggal_sk_akhir">Tanggal SK Akhir</Label>
              <Input
                id="tanggal_sk_akhir"
                v-model="form.tanggal_sk_akhir"
                class="w-full"
                type="date"
                placeholder="Tanggal SK Akhir"
              ></Input>
            </div>
          </div>
        </div>

        <div v-if="currentRouteName.route != 'Tambah'" class="mb-3">
          <p>Masa Kerja: {{ calculatedMasaKerja }}</p>
        </div>

        <!-- GOLONGAN -->
        <div class="mb-3">
          <Label for="golongan">Golongan</Label>
          <Input
            id="golongan"
            v-model="form.golongan"
            class="w-full"
            type="text"
            name="golongan"
          ></Input>
        </div>

        <!-- DIVISI, LEVEL PENGGUNA -->
        <div class="mb-3">
          <div class="w-full">
            <Label for="divisi">Status Karyawan Berdasarkan Fungsinya</Label>
            <select
              id="divisi"
              v-model="form.status_berdasarkan_fungsi"
              class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            >
              <option value="Tenaga Kependidikan - Administrasi">
                Tenaga Kependidikan - Administrasi
              </option>
              <option value="Tenaga Kependidikan - Pustakawan">
                Tenaga Kependidikan - Pustakawan
              </option>
              <option value="Tenaga Kependidikan - Arsiparis">
                Tenaga Kependidikan - Arsiparis
              </option>
              <option value="Tenaga Kependidikan - Teknisi">
                Tenaga Kependidikan - Teknisi
              </option>
              <option value="Tenaga Kependidikan - Laboran">
                Tenaga Kependidikan - Laboran
              </option>
              <option value="Tenaga Kependidikan - Humas">
                Tenaga Kependidikan - Humas
              </option>
              <option value="Tenaga Penunjang Akademik - Cleaning Service">
                Tenaga Penunjang Akademik - Cleaning Service
              </option>
              <option value="Tenaga Penunjang Akademik - Satpam/Waker">
                Tenaga Penunjang Akademik - Satpam/Waker
              </option>
            </select>
          </div>
        </div>

        <!-- DIVISI, LEVEL PENGGUNA -->
        <div class="mb-4 flex space-x-2">
          <div class="w-full">
            <Label for="divisi">Divisi</Label>
            <select
              id="divisi"
              v-model="form.divisi"
              class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            >
              <option value="BAAK">BAAK</option>
              <option value="BAU">BAU</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="w-full">
            <Label for="level_pengguna">Level Pengguna</Label>
            <select
              id="level_pengguna"
              v-model="form.level_pengguna"
              class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            >
              <option value="Staff">Staff</option>
              <option value="Pengguna">Pengguna</option>
              <option value="Administrator">Administrator</option>
              <option value="Tidak Aktif">
                Tidak Aktif (Jika sudah tidak bekerja)
              </option>
            </select>
          </div>
        </div>

        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <Label for="jenjang_pendidikan">Jenjang Pendidikan</Label>
            <Input
              id="jenjang_pendidikan"
              v-model="form.jenjang_pendidikan"
              class="w-full"
              type="text"
              placeholder="Jenjang Pendidikan"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="gelar_depan">Gelar Depan</Label>
            <Input
              id="gelar_depan"
              v-model="form.gelar_depan"
              class="w-full"
              type="text"
              placeholder="Gelar Depan"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="gelar_belakang">Gelar Belakang</Label>
            <Input
              id="gelar_belakang"
              v-model="form.gelar_belakang"
              class="w-full"
              type="text"
              placeholder="Gelar Belakang"
            ></Input>
          </div>
        </div>

        <div class="flex justify-between">
          <Button @click="submit()" class="px-10">Simpan</Button>
          <button
            v-if="currentRouteName.route != 'Tambah'"
            type="button"
            class="bg-transparent text-red-500 hover:bg-transparent focus:bg-transparent"
            @click="isOpen = !isOpen"
          >
            Hapus Data Karyawan
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :is-open="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus karyawan"
      confirm-text="Hapus"
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
import { computed, reactive, ref, onMounted } from "vue"
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
      kecamatan: props.staff?.user.kecamatan || null,
      kota: props.staff?.user.kota || null,
      provinsi: props.staff?.user.provinsi || null,
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
      status_berdasarkan_fungsi: props.staff?.status_berdasarkan_fungsi || "-",
      golongan: props.staff?.golongan || null,

      // data tenaga kependidikan
      nitk: props.staff?.tenaga_kependidikan?.id,
    })


    const isOpen = ref(false)


    // Script provinsi-kota
    const kotas = ref(["Tarakan"])
    const provinsis = ref(["Kalimantan Utara"])

    onMounted (() => {
      getProvinsi()
      getKabupatenKota(form.provinsi)
    })


    async function getProvinsi() {
      return await fetch("https://dev.farizdotid.com/api/daerahindonesia/provinsi")
        .then((res) => res.json())
        .then((data) => {
          provinsis.value = data.provinsi
          console.log(data.provinsi)
        })
    }

    async function getKabupatenKota(idProvinsi) {
      if (!idProvinsi) return kotas.value = []
      return await fetch(`https://dev.farizdotid.com/api/daerahindonesia/kota?id_provinsi=${idProvinsi}`)
        .then((res) => res.json())
        .then((data) => {
          kotas.value = data.kota_kabupaten
          console.log(data.kota_kabupaten)
        })
    }
    // End cript provinsi-kota


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
      if (props.staff.tanggal_sk_awal == null) {
        return 0
      }

      const now = new Date(Date.now())
      const tanggal_sk_awal = new Date(props.staff.tanggal_sk_awal)
      const timediff = now.getTime() - tanggal_sk_awal.getTime()
      const daydiff = Math.floor(timediff / (1000 * 3600 * 24))
      // const monthdiff = daydiff / 30
      // const yeardiff = monthdiff / 12

      const num_year = daydiff / 366
      const num_month = Math.floor((daydiff % 365) / 30)
      const num_days = Math.floor(daydiff % 365) % 30
      // return Math.round(daydiff) + " hari, " + Math.round(monthdiff) + " bulan, " + Math.round(yeardiff) + " tahun"
      return (
        " " +
        Math.round(num_year) +
        " Tahun, " +
        Math.round(num_month) +
        " Bulan, " +
        Math.round(num_days) +
        " Hari."
      )
    })

    return {
      getProvinsi,
      getKabupatenKota,
      currentRouteName,
      calculatedMasaKerja,
      kotas,
      provinsis,
      form,
      isOpen,
      submit,
      remove,
    }
  },
}
</script>

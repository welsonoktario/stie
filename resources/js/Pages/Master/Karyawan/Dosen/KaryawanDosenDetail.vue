<template>
  <AppLayout>
    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Karyawan / Dosen /
        <span class="font-semibold text-teal-500 dark:text-teal-600">
          {{
            currentRouteName.route
          }}
        </span>
      </p>

      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong class="whitespace-nowrap capitalize text-sm md:text-lg content-middle">
            <span>{{ currentRouteName.route }}</span>
            Dosen
          </strong>
        </span>
      </div>

      <form @submit.prevent="submit">
        <!-- ID KARYAWAN -->
        <div class="w-full mb-4">
          <Label for="id_karyawan">
            ID Karyawan
            <em>(Nomor Induk Karyawan)</em>
            <span class="text-red-500">*</span>
          </Label>
          <Input
            id="id_karyawan"
            v-model="form.id_karyawan"
            class="mt-1 block w-full"
            name="id_karyawan"
            type="text"
            placeholder="ID"
            required
          ></Input>
        </div>

        <!-- ID DOSEN, TIPE ID -->
        <div class="mb-4 flex space-x-3">
          <div class="w-full">
            <Label for="id_dosen">
              ID Dosen
              <span class="text-red-500">*</span>
            </Label>
            <Input
              id="id_dosen"
              v-model="form.id_dosen"
              class="mt-1 block w-full"
              name="ID Dosen"
              type="text"
              placeholder="ID Dosen"
              required
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="tipe_id">
              Tipe ID Dosen
              <span class="text-red-500">*</span>
            </label>
            <select
              id="tipe_id"
              v-model="form.tipe_id"
              class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
              name="tipe_id"
            >
              <option value="NIDN">NIDN</option>
              <option value="NIDK">NIDK</option>
              <option value="NUPN">NUPN</option>
            </select>
          </div>
        </div>

        <!-- NAMA, NIK -->
        <div class="mb-4 flex space-x-3">
          <div class="w-full">
            <Label for="nama">
              Nama
              <span class="text-red-500">*</span>
            </Label>
            <Input
              id="nama"
              v-model="form.name"
              class="mt-1 block w-full"
              name="nama"
              type="text"
              placeholder="Nama"
              required
            ></Input>
          </div>
          <div class="w-full">
            <Label for="nik">NIK</Label>
            <Input
              id="nik"
              v-model="form.nik"
              class="mt-1 block w-full"
              name="nik"
              type="text"
              placeholder="NIK"
            ></Input>
          </div>
        </div>

        <!-- EMAIL, JENIS KELAMIN -->
        <div class="mb-4 flex space-x-2">
          <div class="w-full">
            <Label for="email">Email</Label>
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
            <Label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="jenis_kelamin"
            >Jenis Kelamin</Label>
            <Select
              v-model="form.jenis_kelamin"
              class="w-full"
              :options="['Laki-laki', 'Perempuan']"
              :name="'jenis_kelamin'"
            >
              <template #option="option">
                <option :value="option.data">{{ option.data }}</option>
              </template>
            </Select>
          </div>
        </div>

        <!-- JABATAN AKADEMIK -->
        <div class="mb-4">
          <Label for="jabatan_akademik">Jabatan Akademik</Label>
          <select
            id="jabatan_akademik"
            v-model="form.jabatan_akademik"
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            name="jabatan_akademik"
          >
            <option value="null">-</option>
            <option value="Tenaga Pengajar">Tenaga Pengajar</option>
            <option value="Asisten Ahli">Asisten Ahli</option>
            <option value="Lektor">Lektor</option>
            <option value="Lektor Kepala">Lektor Kepala</option>
            <option value="Guru Besar">Guru Besar</option>
          </select>
        </div>

        <!-- JURUSAN/HOMEBASE, KONSENTRASI -->
        <div class="mb-4 flex space-x-3">
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="jurusan"
            >Jurusan / Homebase</label>
            <select
              id="jurusan"
              v-model="form.jurusan"
              class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
              name="jurusan"
            >
              <option value="-">-</option>
              <option
                v-for="jurusan in jurusans"
                :key="jurusan.id"
                :value="jurusan.id.toString()"
              >{{ jurusan.nama }} - {{ jurusan.kode_jurusan }}</option>
            </select>
          </div>
          <div class="w-full">
            <Label for="konsentrasi">Konsentrasi</Label>
            <Input
              id="konsentrasi"
              v-model="form.konsentrasi"
              class="mt-1 block w-full"
              name="konsentrasi"
              type="text"
              placeholder="Konsentrasi"
            ></Input>
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
          <label class="block text-gray-500 text-sm font-bold mb-2" for="nomor_hp">Nomor HP</label>
          <Input
            id="nomor_hp"
            v-model="form.nomor_hp"
            class="w-full"
            type="text"
            placeholder="Nomor HP"
          ></Input>
        </div>

        <!-- alamat jalan -->
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="jalan">Alamat</label>
          <Input
            id="jalan"
            v-model="form.jalan"
            class="w-full"
            type="text"
            autocomplete="disable"
            placeholder="Jalan Gunung Amal Nomor 1"
          ></Input>
        </div>

        <!-- kelurahan, kecamatan, kode pos -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="kelurahan">Kelurahan</label>
            <Input
              id="kelurahan"
              v-model="form.kelurahan"
              class="w-full"
              type="text"
              placeholder="Kelurahan"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="kecamatan">Kecamatan</label>
            <Input
              id="kecamatan"
              v-model="form.kecamatan"
              class="w-full"
              type="text"
              placeholder="Kecamatan"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="kode_pos">Kode Pos</label>
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
        <div class="flex space-x-3 mb-3">
          <div class="w-full">
            <Label for="provinsi">Provinsi</Label>
            <Select
              v-model="form.provinsi"
              class="w-full"
              :options="provinsis"
              :name="'provinsi'"
              :placeholder="'Pilih provinsi'"
            >
              <template #option="option">
                <option :value="option.data">{{ option.data }}</option>
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
                <option :value="option.data">{{ option.data }}</option>
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

        <!-- Masa Kerja -->
        <div v-if="currentRouteName.route != 'Tambah'" class="mb-3">
          <p>Masa Kerja: {{ calculatedMasaKerja }}</p>
        </div>

        <!-- JENJANG PENDIDIKAN, GELAR DEPAN, GELAR BELAKANG -->
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

        <!-- GOLONGAN -->
        <div class="mb-3">
          <Label for="golongan">Golongan</Label>
          <Input id="golongan" v-model="form.golongan" class="w-full" type="text" name="golongan"></Input>
        </div>

        <!-- LEVEL PENGGUNA -->
        <div class="mb-4 flex space-x-2">
          <div class="w-full">
            <Label for="level_pengguna">Level Pengguna</Label>
            <select
              id="level_pengguna"
              v-model="form.level_pengguna"
              class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >
              <option value="Staff">Staff</option>
              <option value="Pengguna">Pengguna</option>
              <option value="Administrator">Administrator</option>
            </select>
          </div>
        </div>

        <!--  -->

        <div class="flex justify-between">
          <Button class="px-10">Simpan</Button>
          <button
            v-if="currentRouteName.route != 'Tambah'"
            type="button"
            class="text-red-500 bg-transparent hover:bg-transparent focus:bg-transparent"
            @click="isOpen = !isOpen"
          >Hapus Data Dosen</button>
        </div>
      </form>
    </div>

    <Dialog
      :is-open="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus dosen"
      confirm-text="Hapus"
      @confirm="remove"
      @cancel="isOpen = !isOpen"
    >
      <template #content>
        <p class="text-sm">Apakah anda yakin ingin menghapus dosen ini?</p>
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
import Select from "@/Components/Select"

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
    dosen: Object,
    jurusans: Object,
  },
  setup(props) {
    const form = useForm({
      // user data
      email: props.dosen?.staff?.user?.email || null,
      name: props.dosen?.staff?.user?.name || null,
      nik: props.dosen?.staff?.user?.nik || null,
      jenis_kelamin: props.dosen?.staff?.user.jenis_kelamin || "Laki-laki",
      agama: props.dosen?.staff?.user.agama || null,
      nomor_hp: props.dosen?.staff?.user.nomor_hp || null,
      tempat_lahir: props.dosen?.staff?.user.tempat_lahir || null,
      tanggal_lahir: props.dosen?.staff?.user.tanggal_lahir || null,
      jalan: props.dosen?.staff?.user.jalan || null,
      kelurahan: props.dosen?.staff?.user.kelurahan || null,
      kota: props.dosen?.staff?.user.kota || null,
      provinsi: props.dosen?.staff?.user.provinsi || null,
      kode_pos: props.dosen?.staff?.user.kode_pos || null,
      kewarganegaraan: props.dosen?.staff?.user.kewarganegaraan || "WNI",

      // karyawan data (mandatory)
      id_karyawan: props.dosen?.staff?.id || null,
      divisi: "Dosen",
      level_pengguna: props.dosen?.staff?.level_pengguna || "Staff",
      jenjang_pendidikan: props.dosen?.staff?.jenjang_pendidikan || null,
      gelar_depan: props.dosen?.staff?.gelar_depan || null,
      gelar_belakang: props.dosen?.staff?.gelar_belakang || null,
      status_karyawan: props.dosen?.staff?.status_karyawan || null,
      nomor_sk_awal: props.dosen?.staff?.nomor_sk_awal || null,
      tanggal_sk_awal: props.dosen?.staff?.tanggal_sk_awal || null,
      nomor_sk_akhir: props.dosen?.staff?.nomor_sk_akhir || null,
      tanggal_sk_akhir: props.dosen?.staff?.tanggal_sk_akhir || null,
      status_karyawan: props.dosen?.staff?.status_karyawan || "Aktif",
      golongan: props.dosen?.staff?.golongan || null,

      // dosen primary data (mandatory)
      id_dosen: props.dosen?.id || null,
      tipe_id: props.dosen?.tipe_id || "NIDN",
      jabatan_akademik: props.dosen?.jabatan_akademik || "Tenaga Pengajar",
      jurusan: props.dosen?.jurusan?.id || "-",
      konsentrasi: props.dosen?.konsentrasi || "-",
    })

    const kotas = ['Tarakan']

    const provinsis = ['Kalimantan Utara']

    const isOpen = ref(false)

    const currentRouteName = reactive({
      route: computed(() =>
        route().current("master.dosen.create") ? "Tambah" : "Ubah"
      ),
    })

    const submit = () =>
      currentRouteName.route == "Tambah"
        ? form.post(route("master.dosen.store"))
        : form.put(route("master.dosen.update", props.dosen.id))

    const remove = () =>
      form.delete(route("master.dosen.destroy", props.dosen.id))

    const calculatedMasaKerja = computed(() => {
      if (props.dosen.staff.tanggal_sk_awal == null) {
        return 0
      }
      const now = new Date(Date.now())
      const tanggal_sk_awal = new Date(props.dosen.staff.tanggal_sk_awal)
      const timediff = now.getTime() - tanggal_sk_awal.getTime()
      const daydiff = Math.floor(timediff / (1000 * 3600 * 24))
      // const monthdiff = daydiff / 30
      // const yeardiff = monthdiff / 12

      const num_year = daydiff / 366
      const num_month = Math.floor((daydiff % 365) / 30)
      const num_days = Math.floor(daydiff % 365) % 30
      // return Math.round(daydiff) + " hari, " + Math.round(monthdiff) + " bulan, " + Math.round(yeardiff) + " tahun"
      return ' ' + Math.round(num_year) + ' Tahun, ' + Math.round(num_month) + ' Bulan, ' + Math.round(num_days) + ' Hari.'
      return now
    })

    return {
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

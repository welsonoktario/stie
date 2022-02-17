<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Karyawan / Dosen /
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
            Dosen</strong
          >
        </span>
      </div>

      <form @submit.prevent="submit">

        <!-- ID KARYAWAN -->
        <div class="w-full mb-4">
          <Label for="id_karyawan">
            ID Karyawan <em> (Nomor Induk Karyawan)</em>
            <span class="text-red-500">*</span>
          </Label>
          <Input
            v-model="form.id_karyawan"
            class="mt-1 block w-full"
            name="id_karyawan"
            id="id_karyawan"
            type="text"
            placeholder="ID"
            required
          ></Input>
        </div>

        <!-- ID DOSEN, TIPE ID -->
        <div class="mb-4 flex space-x-3">
          <div class="w-full">
            <Label for="id_dosen">
              ID Dosen <span class="text-red-500">*</span>
            </Label>
            <Input
              v-model="form.id_dosen"
              class="mt-1 block w-full"
              name="ID Dosen"
              id="id_dosen"
              type="text"
              placeholder="id_dosen"
              required
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="tipe_id"
            >
              Tipe ID Dosen <span class="text-red-500">*</span>
            </label>
            <select
              class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
              name="tipe_id"
              id="tipe_id"
              v-model="form.tipe_id"
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
            <Label for="nama"> Nama <span class="text-red-500">*</span> </Label>
            <Input
              v-model="form.name"
              class="mt-1 block w-full"
              name="nama"
              id="nama"
              type="text"
              placeholder="Nama"
              required
            ></Input>
          </div>
          <div class="w-full">
            <Label for="nik"> NIK </Label>
            <Input
              v-model="form.nik"
              class="mt-1 block w-full"
              name="nik"
              id="nik"
              type="text"
              placeholder="NIK"
            ></Input>
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
            <label class="block text-gray-500 text-sm font-bold mb-2" for="jenis_kelamin">
              Jenis Kelamin
            </label>
            <select 
              class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
              id="jenis_kelamin"
              v-model="form.jenis_kelamin">
              <option value="Laki-laki">Laki-laki</option>
              <option value="Perempuan">Perempuan</option>
            </select>
          </div>
        </div>

        <!-- JABATAN AKADEMIK -->
        <div class="mb-4">
          <Label for="jabatan_akademik">
            Jabatan Akademik
          </Label>
          <select
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            name="jabatan_akademik"
            id="jabatan_akademik"
            v-model="form.jabatan_akademik"
          >
            <option value="Lektor">Lektor</option>
            <option value="Asisten Ahli">Asisten Ahli</option>
            <option value="Tenaga Pengajar">Tenaga Pengajar</option>
          </select>
        </div>

        <!-- JURUSAN/HOMEBASE, KONSENTRASI -->
        <div class="mb-4 flex space-x-3">
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="jurusan"
            >
              Jurusan / Homebase
            </label>
            <select
              class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
              name="jurusan"
              id="jurusan"
              v-model="form.jurusan"
            >
              <option value="-">-</option>
              <option
                v-for="jurusan in jurusans"
                :key="jurusan.id"
                :value="jurusan.id.toString()"
              >
                {{ jurusan.nama }} - {{ jurusan.kode_jurusan }}
              </option>
            </select>
          </div>
          <div class="w-full">
            <Label for="konsentrasi"> Konsentrasi </Label>
            <Input
              v-model="form.konsentrasi"
              class="mt-1 block w-full"
              name="konsentrasi"
              id="konsentrasi"
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
          <label class="block text-gray-500 text-sm font-bold mb-2" for="nomor_hp">
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
        
        <!-- alamat jalan -->
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="jalan">
            Jalan 
          </label>
          <Input
            v-model="form.jalan"
            class="w-full"
            id="jalan"
            type="text"
            placeholder="jalan"
          ></Input>
        </div>

        <!-- kelurahan, kecamatan, kode pos -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="kelurahan">
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
            <label class="block text-gray-500 text-sm font-bold mb-2" for="kecamatan">
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
            <label class="block text-gray-500 text-sm font-bold mb-2" for="kode_pos">
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

        <!-- JENJANG PENDIDIKAN, GELAR DEPAN, GELAR BELAKANG -->
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

        
        <!-- LEVEL PENGGUNA -->
        <div class="mb-4 flex space-x-2">
          <div class="w-full">
            <Label for="level_pengguna">Level Pengguna</Label>
            <select 
              class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
              id="level_pengguna"
              v-model="form.level_pengguna">
              <option value="Staff">Staff</option>
              <option value="Administrator">Administrator</option>
            </select>
          </div>
        </div>


        <!--  -->

        <div class="flex justify-between">
          <Button class="px-10">Simpan</Button>
          <button
            type="button"
            v-if="currentRouteName != 'Tambah'"
            @click="isOpen = !isOpen"
            class="text-red-500 bg-transparent hover:bg-transparent focus:bg-transparent"
          >
            Hapus Data Dosen
          </button>
        </div>
      </form>
    </div>

    <Dialog
      :isOpen="isOpen"
      classes="text-red-900 bg-red-100 dark:bg-red-300 hover:bg-red-200 dark:hover:bg-red-400 focus-visible:ring-red-500"
      title="Hapus dosen"
      confirmText="Hapus"
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
import { computed, ref } from "vue"
import { Link, useForm } from "@inertiajs/inertia-vue3"
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
      kode_pos: props.dosen?.staff?.user.kode_pos || null,
      kewarganegaraan: props.dosen?.staff?.user.kewarganegaraan || 'WNI',

      // karyawan data (mandatory)
      id_karyawan: props.dosen?.staff?.id || null,
      divisi: "Dosen" ,
      level_pengguna: props.dosen?.staff?.level_pengguna || "Staff" ,
      jenjang_pendidikan: props.dosen?.staff?.jenjang_pendidikan || null ,
      gelar_depan: props.dosen?.staff?.gelar_depan || null ,
      gelar_belakang: props.dosen?.staff?.gelar_belakang || null ,
      status_karyawan: props.dosen?.staff?.status_karyawan || null ,
      nomor_sk_awal: props.dosen?.staff?.nomor_sk_awal || null ,
      tanggal_sk_awal: props.dosen?.staff?.tanggal_sk_awal || null ,
      nomor_sk_akhir: props.dosen?.staff?.nomor_sk_akhir || null ,
      tanggal_sk_akhir: props.dosen?.staff?.tanggal_sk_akhir || null ,
      status_karyawan: props.dosen?.staff?.status_karyawan || 'Aktif' ,

      // dosen primary data (mandatory)
      id_dosen: props.dosen?.id || null,
      tipe_id: props.dosen?.tipe_id || "NIDN",
      jabatan_akademik: props.dosen?.jabatan_akademik || "Tenaga Pengajar",
      jurusan: props.dosen?.jurusan?.id || "-",
      konsentrasi: props.dosen?.konsentrasi || "-",
    })

    const isOpen = ref(false)

    const currentRouteName = computed(() =>
      route().current("master.dosen.create") ? "Tambah" : "Ubah"
    )

    const submit = () =>
      // console.log(currentRouteName)
      currentRouteName.value == "Tambah"
        ? form.post(route("master.dosen.store"))
        : form.put(route("master.dosen.update", props.dosen.id))

    const remove = () =>
      form.delete(route("master.dosen.destroy", props.dosen.id))

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

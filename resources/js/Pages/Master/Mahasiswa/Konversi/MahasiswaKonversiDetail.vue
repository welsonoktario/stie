<template>
  <AppLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Mahasiswa / Mahasiswa Konversi /
        <span v-if="route().current('master.mahasiswa-konversi.create')">Tambah</span>
        <span v-else>Ubah</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong
            class="whitespace-nowrap capitalize text-sm md:text-lg content-middle"
          >
            <span v-if="route().current('master.mahasiswa-konversi.create')">Tambah</span>
            <span v-else>Ubah</span>
            Mahasiswa Konversi</strong
          >
        </span>
      </div>


      <form @submit.prevent="submit(route().current())">
        <div class="flex sm:space-x-2 sm:flex-row flex-col">

          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="npm">
              NPM / NIM <span class="text-red-500">*</span>
            </label>
            <Input
              v-model="form.npm"
              class="w-full"
              id="npm"
              type="text"
              placeholder="NIM / NPM"
              required
            ></Input>
          </div>

          <div class="mb-2 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nik">
              NIK
            </label>
            <Input
              v-model="form.nik"
              class="w-full"
              id="nik"
              type="text"
              placeholder="NIK"
            ></Input>
          </div>
        </div>

        <div class="flex sm:space-x-3 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nama">
              Nama <span class="text-red-500">*</span>
            </label>
            <Input
              v-model="form.name"
              class="w-full"
              id="nama"
              type="text"
              placeholder="Nama"
              required
            ></Input>
          </div>

          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="email">
              Email
            </label>
            <Input
              v-model="form.email"
              class="w-full"
              id="email"
              type="text"
              placeholder="Email"
            ></Input>
          </div>
        </div>


        <!-- Data konversi -->
        <!-- NPM ASAL, PT ASAL-->
        <div class="flex sm:space-x-3 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="npm_asal">
              NPM Asal
            </label>
            <Input
              v-model="form.npm_asal"
              class="w-full"
              id="npm_asal"
              type="text"
              placeholder="NPM Asal"
            ></Input>
          </div>

          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="perguruan_tinggi_asal">
              Perguruan Tinggi Asal
            </label>
            <Input
              v-model="form.perguruan_tinggi_asal"
              class="w-full"
              id="perguruan_tinggi_asal"
              type="text"
              placeholder="Perguruan Tinggi ssal"
            ></Input>
          </div>
        </div>


        <div class="mb-4">
          <Label for="nama"> Agama <span class="text-red-500">*</span> </Label>
          <select
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            name="agama"
            v-model="form.agama"
          >
            <option value="-" selected disabled>Pilih agama</option>
            <option value="Islam">Islam</option>
            <option value="Kristen">Kristen</option>
            <option value="Katolik">Katolik</option>
            <option value="Budha">Budha</option>
            <option value="Hindu">Hindu</option>
            <option value="Konghucu">Konghucu</option>
          </select>
        </div>

        <fieldset class="mb-4">
          <Label for="kps">Penerima KPS <i>(Kartu Perlindungan Sosial)</i></Label>
          <div class="inline-flex">
            <div>
              <input
                v-model="form.kps"
                type="radio"
                name="kps"
                value="1"
                class="checked:bg-teal-500 checked:focus:bg-teal-500 dark:checked:bg-teal-400 dark:checked:focus:bg-teal-400 focus:ring-0"
              />
              <span class="ml-2">Ya</span>
            </div>
            <div class="ml-4">
              <input
                v-model="form.kps"
                type="radio"
                name="kps"
                value="0"
                class="checked:bg-teal-500 checked:focus:bg-teal-500 dark:checked:bg-teal-400 dark:checked:focus:bg-teal-400 focus:ring-0"
              />
              <span class="ml-2">Tidak</span>
            </div>
          </div>
        </fieldset>

        <!-- TANGGAL MASUK -->
        <div class="mb-4">
          <Label for="tanggal_masuk">
            Tanggal Masuk <span class="text-red-500">*</span>
          </Label>
          <Input
            v-model="form.tanggal_masuk"
            class="w-full"
            name="tanggal_masuk"
            type="date"
            placeholder="Tanggal masuk"
            required
            :disabled="!route().current('master.mahasiswa-konversi.create')"
            :readonly="!route().current('master.mahasiswa-konversi.create')"
          ></Input>
        </div>

        <!-- NPM ASAL, KAMPUS ASAL-->
        <div class="flex sm:space-x-3 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="jurusan_asal">
              Jurusan Asal
            </label>
            <Input
              v-model="form.jurusan_asal"
              class="w-full"
              id="jurusan_asal"
              type="text"
              placeholder="Jurusan Asal"
            ></Input>
          </div>

          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="jenjang_pendidikan">
              Jenjang Pendidikan
            </label>
            <Input
              v-model="form.jenjang_pendidikan"
              class="w-full"
              id="jenjang_pendidikan"
              type="text"
              placeholder="Jenjang Pendidikan"
            ></Input>
          </div>
        </div>

        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="jurusan">
            Jurusan
          </label>
          <select
            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            id="jurusan"
            v-model="form.jurusan_id">
            <option value="-">-</option>
            <option v-for="jurusan in jurusans" :key="jurusan.id" :value="jurusan.id.toString()">{{jurusan.nama}} - {{jurusan.kode_jurusan}}</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="dosen">
            Dosen Wali
          </label>
          <select
            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            id="dosen"
            v-model="form.dosen_id">
            <option value="-">-</option>
            <option v-for="dosen in dosens" :key="dosen.id" :value="dosen.id.toString()">{{dosen.staff.user.name}}</option>
          </select>
        </div>



        <!-- TTL, Jenis Kelamin -->
        <div class="mb-3">
          <div class="flex space-x-2">
            <div>
              <label class="block text-gray-500 text-sm font-bold mb-2" for="tempat_lahir">
                Tempat Lahir
              </label>
              <Input
                v-model="form.tempat_lahir"
                class="w-full"
                id="tempat_lahir"
                type="text"
                placeholder="Tempat Lahir"
              ></Input>
            </div>
            <div>
              <label class="block text-gray-500 text-sm font-bold mb-2" for="tanggal_lahir">
                Tanggal Lahir
              </label>
              <Input
                v-model="form.tanggal_lahir"
                class="w-full"
                id="tanggal_lahir"
                type="date"
                placeholder="Tanggal Lahir"
              ></Input>
            </div>
            <div class="w-full">
              <label class="block text-gray-500 text-sm font-bold mb-2" for="jenis_kelamin">Jenis Kelamin</label>
              <select name="jenis_kelamin" class="w-full w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                v-model="form.jenis_kelamin">
                <option value="Laki-laki" selected>Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
          </div>
        </div>

        <!-- NISN, NPWP -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="npwp">
              NPWP
            </label>
            <Input
              v-model="form.npwp"
              class="w-full"
              id="npwp"
              type="text"
              placeholder="npwp"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nisn">
              NISN
            </label>
            <Input
              v-model="form.nisn"
              class="w-full"
              id="nisn"
              type="text"
              placeholder="nisn"
            ></Input>
          </div>
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

        <!-- nomor hp -->
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

        <!-- jenis tinggal, alat transportasi -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="jenis_tinggal">
              Jenis Tinggal
            </label>
            <Input
              v-model="form.jenis_tinggal"
              class="w-full"
              id="jenis_tinggal"
              type="text"
              placeholder="jenis_tinggal"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="alat_transportasi">
              Alat Transportasi
            </label>
            <Input
              v-model="form.alat_transportasi"
              class="w-full"
              id="alat_transportasi"
              type="text"
              placeholder="Alat Transportasi"
            ></Input>
          </div>
        </div>


        <!-- Data riwayat status kuliah -->
        <p class="mb-4 text-sm md:text-lg"
          v-if="currentRouteName == 'Edit'">
          <strong>Riwayat Status Kuliah</strong>
        </p>

        <div class="mb-4 w-full"
          v-if="currentRouteName == 'Edit'">
          <table class="table-auto w-full">
            <thead>
              <tr>
                <th>No</th>
                <th>Semester</th>
                <th>Status</th>
                <th>Hapus</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(ta, index) in form.tahun_ajaran" :key="ta.id">
                <th>{{index+1}}</th>
                <td>{{ta.tahun_ajaran}}</td>
                <td>
                  <select
                    class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
                    name="status_semester"
                    v-model="ta.pivot.status"
                  >
                    <option value="Aktif">Aktif</option>
                    <option value="Lulus">Lulus</option>
                    <option value="Mutasi">Mutasi</option>
                    <option value="Dikeluarkan">Dikeluarkan</option>
                    <option value="Mengundurkan Diri">Mengundurkan Diri</option>
                    <option value="Wafat">Wafat</option>
                    <option value="Hilang">Hilang</option>
                  </select>
                </td>
                <td class="text-sm text-gray-900 font-light py-3 whitespace-nowrap flex justify-center">
                  <Checkbox>

                  </Checkbox>
                </td>
              </tr>
            </tbody>
          </table>
        </div>



        <!-- DATA ORANG TUA -->

        <p class="mb-3 text-sm md:text-lg">
          <strong>Data Orang Tua</strong>
        </p>

        <!-- Ibu -->
        <p class="mb-3 text-xs md:text-sm">
          <strong>Ibu Kandung</strong>
        </p>

        <!-- NIK, NAMA -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nik_ibu">
              NIK Ibu Kandung
            </label>
            <Input
              v-model="form.nik_ibu"
              class="w-full"
              id="nik_ibu"
              type="text"
              placeholder="NIK Ibu Kandung"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nama_ibu">
              Nama Ibu Kandung
            </label>
            <Input
              v-model="form.nama_ibu"
              class="w-full"
              id="nama_ibu"
              type="text"
              placeholder="Nama Ibu Kandung"
            ></Input>
          </div>
        </div>

        <!-- TTL, pendidikan ibu -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="tempat_lahir_ibu">
              Tempat Lahir Ibu Kandung
            </label>
            <Input
              v-model="form.tempat_lahir_ibu"
              class="w-full"
              id="tempat_lahir_ibu"
              type="text"
              placeholder="Tempat Lahir Ibu Kandung"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="tanggal_lahir_ibu">
              Tanggal Lahir Ibu Kandung
            </label>
            <Input
              v-model="form.tanggal_lahir_ibu"
              class="w-full"
              id="tanggal_lahir_ibu"
              type="date"
              placeholder="Tanggal Lahir Ibu Kandung"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="pendidikan_ibu">
              Pendidikan Ibu Kandung
            </label>
            <Input
              v-model="form.pendidikan_ibu"
              class="w-full"
              id="pendidikan_ibu"
              type="text"
              placeholder="Pendidikan Ibu Kandung"
            ></Input>
          </div>
        </div>

        <!-- pekerjaan penghasilan ayah -->
        <div class="mb-3 flex space-x-2">

          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="pekerjaan_ibu">
              Pekerjaan Ibu Kandung
            </label>
            <Input
              v-model="form.pekerjaan_ibu"
              class="w-full"
              id="pekerjaan_ibu"
              type="number"
              placeholder="Pekerjaan Ibu Kandung"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="penghasilan_ibu">
              Penghasilan Ibu
            </label>
            <Input
              v-model="form.penghasilan_ibu"
              class="w-full"
              id="penghasilan_ibu"
              type="number"
              placeholder="Penghasilan Ibu"
            ></Input>
          </div>
        </div>



        <!-- Ayah -->
        <p class="mb-3 text-xs md:text-sm">
          <strong>Ayah</strong>
        </p>

        <!-- NIK, NAMA -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nik_ayah">
              NIK Ayah
            </label>
            <Input
              v-model="form.nik_ayah"
              class="w-full"
              id="nik_ayah"
              type="text"
              placeholder="NIK Ayah"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nama_ayah">
              Nama Ayah
            </label>
            <Input
              v-model="form.nama_ayah"
              class="w-full"
              id="nama_ayah"
              type="text"
              placeholder="Nama Ayah"
            ></Input>
          </div>
        </div>

        <!-- TTL, pendidikan ayah -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="tempat_lahir_ayah">
              Tempat Lahir Ayah
            </label>
            <Input
              v-model="form.tempat_lahir_ayah"
              class="w-full"
              id="tempat_lahir_ayah"
              type="text"
              placeholder="Tempat Lahir Ayah"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="tanggal_lahir_ayah">
              Tanggal Lahir Ayah
            </label>
            <Input
              v-model="form.tanggal_lahir_ayah"
              class="w-full"
              id="tanggal_lahir_ayah"
              type="date"
              placeholder="Tanggal Lahir Ayah"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="pendidikan_ayah">
              Pendidikan Ayah
            </label>
            <Input
              v-model="form.pendidikan_ayah"
              class="w-full"
              id="pendidikan_ayah"
              type="text"
              placeholder="Pendidikan Ayah"
            ></Input>
          </div>
        </div>

        <!-- pekerjaan penghasilan ayah -->
        <div class="mb-3 flex space-x-2">

          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="pekerjaan_ayah">
              Pekerjaan Ayah
            </label>
            <Input
              v-model="form.pekerjaan_ayah"
              class="w-full"
              id="pekerjaan_ayah"
              type="number"
              placeholder="Pekerjaan Ayah"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="penghasilan_ayah">
              Penghasilan Ayah
            </label>
            <Input
              v-model="form.penghasilan_ayah"
              class="w-full"
              id="penghasilan_ayah"
              type="number"
              placeholder="Penghasilan Ayah"
            ></Input>
          </div>
        </div>


        <div class="flex justify-between">
          <div>
            <Button class="px-10">Simpan</Button>

            <Link
              v-if="!route().current('master.mahasiswa-konversi.create')"
              :href="'/master/mahasiswa-konversi/'+mahasiswa.npm+'/matakuliah-konversi'"
              method="get"
              as="button"
              type="link"
              class="ml-1 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
              >
              Matakuliah Diakui
            </Link>
          </div>
          <Link
            v-if="!route().current('master.mahasiswa-konversi.create')"
            @click="remove()"
            class="text-red-500"
            >Hapus Data Mahasiswa Konversi</Link
          >
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App.vue"

import Input from "@components/Input.vue"
import Button from "@components/Button.vue"
import Checkbox from "@/Components/Checkbox.vue"
import ModalInput from "@/Components/ModalInput.vue"

import { Link } from "@inertiajs/inertia-vue3"

import { computed, reactive, ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
import Label from "@components/Label"

import {
  ChevronDoubleDownIcon,
  ChevronDoubleUpIcon
} from "@heroicons/vue/outline"

export default {
  components: {
    AppLayout,
    Link,
    Input,
    Button,
    ModalInput,
    Checkbox,
    Label,
    ChevronDoubleDownIcon,
    ChevronDoubleUpIcon,
  },
  props: {
    dosens: {
      type: Object,
      default: null,
    },
    jurusans: {
      type: Object,
      default: null,
    },
    mahasiswa: {
      type: Object,
      default: null,
    },
    matakuliahs: {
      type: Object,
      default: null,
    }

  },
  setup(props) {

    const showModalMatakuliah = ref(true)

    const form = reactive({
      // user data
      email: props.mahasiswa == null ? null : props.mahasiswa.user.email,
      name: props.mahasiswa == null ? null : props.mahasiswa.user.name,
      nik: props.mahasiswa == null ? null : props.mahasiswa.user.nik,
      jenis_kelamin: props.mahasiswa?.user.jenis_kelamin || "Laki-laki",
      agama: props.mahasiswa?.user.agama || null,
      nomor_hp: props.mahasiswa?.user.nomor_hp || null,
      tempat_lahir: props.mahasiswa?.user.tempat_lahir || null,
      tanggal_lahir: props.mahasiswa?.user.tanggal_lahir || null,
      jalan: props.mahasiswa?.user.jalan || null,
      kelurahan: props.mahasiswa?.user.kelurahan || null,
      kode_pos: props.mahasiswa?.user.kode_pos || null,
      kewarganegaraan: props.mahasiswa?.user.kewarganegaraan || 'WNI',

      // mahasiswa data
      npm: props.mahasiswa == null ? null : props.mahasiswa.npm,
      tanggal_masuk: props.mahasiswa?.tanggal_masuk,
      dosen_id: props.mahasiswa == null ? '-' : (props.mahasiswa.dosen == null ? '-' : props.mahasiswa.dosen.id),
      jurusan_id: props.mahasiswa == null ? '-' : (props.mahasiswa.jurusan == null ? '-' : props.mahasiswa .jurusan.id),
      nisn: props.mahasiswa?.nisn || null,
      jenis_tinggal: props.mahasiswa?.jenis_tinggal || null,
      alat_transportasi: props.mahasiswa?.alat_transportasi || null,
      npwp: props.mahasiswa?.npwp || null,
      kps: props.mahasiswa?.kps || 0,


      // data riwayat tahun ajaran
      tahun_ajaran: props.mahasiswa?.tahun_ajaran || null,


      // data ortu
      // ayah
      nik_ayah: props.mahasiswa?.nik_ayah || null,
      nama_ayah: props.mahasiswa?.nama_ayah || null,
      tempat_lahir_ayah: props.mahasiswa?.tempat_lahir_ayah || null,
      tanggal_lahir_ayah: props.mahasiswa?.tanggal_lahir_ayah || null,
      pendidikan_ayah: props.mahasiswa?.pendidikan_ayah || null,
      pekerjaan_ayah: props.mahasiswa?.pekerjaan_ayah || null,
      penghasilan_ayah: props.mahasiswa?.penghasilan_ayah || null,
      // ibu
      nik_ibu: props.mahasiswa?.nik_ibu || null,
      nama_ibu: props.mahasiswa?.nama_ibu || null,
      tempat_lahir_ibu: props.mahasiswa?.tempat_lahir_ibu || null,
      tanggal_lahir_ibu: props.mahasiswa?.tanggal_lahir_ibu || null,
      pendidikan_ibu: props.mahasiswa?.pendidikan_ibu || null,
      pekerjaan_ibu: props.mahasiswa?.pekerjaan_ibu || null,
      penghasilan_ibu: props.mahasiswa?.penghasilan_ibu || null,

      uang_semester: props.mahasiswa?.uang_semester || null,
      status_mahasiswa: props.mahasiswa?.status_mahasiswa || 'Aktif',

      // data konversi
      npm_asal: props.mahasiswa?.mahasiswa_konversi.npm_asal || null,
      perguruan_tinggi_asal: props.mahasiswa?.mahasiswa_konversi.perguruan_tinggi_asal || null,
      jurusan_asal: props.mahasiswa?.mahasiswa_konversi.jurusan_asal || null,
      jenjang_pendidikan: props.mahasiswa?.mahasiswa_konversi.jenjang_pendidikan || null,

    })

    const showMatakuliah = ref(false);

    function submit(curRoute) {
      if (curRoute === "master.mahasiswa-konversi.create") {
        // alert(util.isEmptyObject(props.staff))
        // alert(props.staff == null ? 'null bro' : 'ada bro')
        Inertia.post(route("master.mahasiswa-konversi.store"), form)
      } else {
        form.id = props.mahasiswa.user.id
        Inertia.put(route("master.mahasiswa-konversi.update", props.mahasiswa.npm), form)
      }
    }

    function remove() {
      // alert(props.staff.nip);
      Inertia.delete(route("master.mahasiswa-konversi.destroy", props.mahasiswa.npm))
    }

    const currentRouteName = computed(() =>
      route().current('master.mahasiswa-konversi.create') ? 'Tambah' : 'Edit'
    )

    return {
      showModalMatakuliah,
      form,
      submit,
      remove,
      showMatakuliah,
      currentRouteName,
    }
  },
}
</script>

<template>
  <AppLayout>
    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">
        Mahasiswa / Mahasiswa Konversi /
        <span
          v-if="route().current('master.mahasiswa-konversi.create')"
        >Tambah</span>
        <span v-else>Ubah</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong class="whitespace-nowrap capitalize text-sm md:text-lg content-middle">
            <span v-if="route().current('master.mahasiswa-konversi.create')">Tambah</span>
            <span v-else>Ubah</span>
            Mahasiswa Konversi
          </strong>
        </span>
      </div>

      <form @submit.prevent="submit(route().current())">
        <div class="flex sm:space-x-2 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="npm">
              NPM / NIM
              <span class="text-red-500">*</span>
            </label>
            <Input
              id="npm"
              v-model="form.npm"
              class="w-full"
              type="text"
              placeholder="NIM / NPM"
              required
            ></Input>
          </div>

          <div class="mb-2 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nik">NIK</label>
            <Input id="nik" v-model="form.nik" class="w-full" type="text" placeholder="NIK"></Input>
          </div>
        </div>

        <div class="flex sm:space-x-3 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nama">
              Nama
              <span class="text-red-500">*</span>
            </label>
            <Input
              id="nama"
              v-model="form.name"
              class="w-full"
              type="text"
              placeholder="Nama"
              required
            ></Input>
          </div>

          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="email">
              Email
              <span class="text-red-500">*</span>
            </label>
            <Input
              id="email"
              v-model="form.email"
              class="w-full"
              type="text"
              placeholder="Email"
              required
            ></Input>
          </div>
        </div>

        <!-- Data konversi -->
        <!-- NPM ASAL, T ASAL-->
        <div class="flex sm:space-x-3 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="npm_asal">NPM Asal</label>
            <Input
              id="npm_asal"
              v-model="form.npm_asal"
              class="w-full"
              type="text"
              placeholder="NPM Asal"
            ></Input>
          </div>

          <div class="mb-3 w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="perguruan_tinggi_asal"
            >Perguruan Tinggi Asal</label>
            <Input
              id="perguruan_tinggi_asal"
              v-model="form.perguruan_tinggi_asal"
              class="w-full"
              type="text"
              placeholder="Perguruan Tinggi ssal"
            ></Input>
          </div>
        </div>

        <div class="mb-4">
          <Label for="nama">
            Agama
            <span class="text-red-500">*</span>
          </Label>
          <select
            v-model="form.agama"
            class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
            name="agama"
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
          <Label for="kps">
            Penerima KPS
            <i>(Kartu Perlindungan Sosial)</i>
          </Label>
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
        <div class="mb-4 flex space-x-3">
          <div class="w-full">
            <Label for="tanggal_masuk">
              Tanggal Masuk
              <span class="text-red-500">*</span>
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
          <div class="w-full">
            <Label for="tanggal_selesai">
              Tanggal Selesai
              <i>(Kosongkan jika belum lulus)</i>
            </Label>
            <Input v-model="form.tanggal_selesai" class="w-full" name="tanggal_lahir" type="date"></Input>
          </div>
        </div>

        <!-- NPM ASAL, KAMPUS ASAL-->
        <div class="flex sm:space-x-3 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="jurusan_asal"
            >Jurusan Asal</label>
            <Input
              id="jurusan_asal"
              v-model="form.jurusan_asal"
              class="w-full"
              type="text"
              placeholder="Jurusan Asal"
            ></Input>
          </div>

          <div class="mb-3 w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="jenjang_pendidikan"
            >Jenjang Pendidikan</label>
            <Input
              id="jenjang_pendidikan"
              v-model="form.jenjang_pendidikan"
              class="w-full"
              type="text"
              placeholder="Jenjang Pendidikan"
            ></Input>
          </div>
        </div>

        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="jurusan">Jurusan</label>
          <select
            id="jurusan"
            v-model="form.jurusan_id"
            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          >
            <option value="-">-</option>
            <option
              v-for="jurusan in jurusans"
              :key="jurusan.id"
              :value="jurusan.id.toString()"
            >{{ jurusan.nama }} - {{ jurusan.kode_jurusan }}</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="dosen">Dosen Wali</label>
          <select
            id="dosen"
            v-model="form.dosen_id"
            class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
          >
            <option value="-">-</option>
            <option
              v-for="dosen in dosens"
              :key="dosen.id"
              :value="dosen.id.toString()"
            >{{ dosen.staff.user.name }}</option>
          </select>
        </div>

        <!-- TTL, Jenis Kelamin -->
        <div class="mb-3">
          <div class="flex space-x-2">
            <div>
              <label
                class="block text-gray-500 text-sm font-bold mb-2"
                for="tempat_lahir"
              >Tempat Lahir</label>
              <Input
                id="tempat_lahir"
                v-model="form.tempat_lahir"
                class="w-full"
                type="text"
                placeholder="Tempat Lahir"
              ></Input>
            </div>
            <div>
              <label
                class="block text-gray-500 text-sm font-bold mb-2"
                for="tanggal_lahir"
              >Tanggal Lahir</label>
              <Input
                id="tanggal_lahir"
                v-model="form.tanggal_lahir"
                class="w-full"
                type="date"
                placeholder="Tanggal Lahir"
              ></Input>
            </div>
            <div class="w-full">
              <label
                class="block text-gray-500 text-sm font-bold mb-2"
                for="jenis_kelamin"
              >Jenis Kelamin</label>
              <select
                v-model="form.jenis_kelamin"
                name="jenis_kelamin"
                class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
              >
                <option value="Laki-laki" selected>Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
          </div>
        </div>

        <!-- NISN, NPWP -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="npwp">NPWP</label>
            <Input id="npwp" v-model="form.npwp" class="w-full" type="text" placeholder="npwp"></Input>
          </div>
        </div>

        <!-- alamat jalan -->
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="jalan">Jalan</label>
          <Input id="jalan" v-model="form.jalan" class="w-full" type="text" placeholder="jalan"></Input>
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

        <!-- nomor hp -->
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

        <!-- jenis tinggal, alat transportasi -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="jenis_tinggal"
            >Jenis Tinggal</label>
            <Input
              id="jenis_tinggal"
              v-model="form.jenis_tinggal"
              class="w-full"
              type="text"
              placeholder="jenis_tinggal"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="alat_transportasi"
            >Alat Transportasi</label>
            <Input
              id="alat_transportasi"
              v-model="form.alat_transportasi"
              class="w-full"
              type="text"
              placeholder="Alat Transportasi"
            ></Input>
          </div>
        </div>

        <!-- SLTA -->

        <p v-if="currentRouteName == 'Edit'" class="mb-4 text-sm md:text-lg">
          <strong>SLTA</strong>
        </p>
        <div class="mb-4 w-full">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="nisn">NISN</label>
          <Input id="nisn" v-model="form.nisn" class="w-full" type="text" placeholder="NISN"></Input>
        </div>
        <div class="flex space-x-3 mb-4">
          <div class="w-full">
            <Label for="asal_slta">Asal SLTA</Label>
            <Input
              v-model="form.asal_slta"
              class="w-full"
              name="asal_slta"
              type="text"
              placeholder="Asal SLTA"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="tahun_lulus_slta">Tahun Lulus SLTA</Label>
            <Input
              v-model="form.tahun_lulus_slta"
              class="w-full"
              name="tahun_lulus_slta"
              type="number"
              min="1000"
              max="9999"
              placeholder="Tahun Lulus SLTA "
            ></Input>
          </div>
        </div>

        <!-- Data riwayat status kuliah -->
        <p v-if="currentRouteName == 'Edit'" class="mb-4 text-sm md:text-lg">
          <strong>Riwayat Status Kuliah</strong>
        </p>

        <div v-if="currentRouteName == 'Edit'" class="mb-4 w-full">
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
                <th>{{ index + 1 }}</th>
                <td>{{ ta.tahun_ajaran }}</td>
                <td>
                  <select
                    v-model="ta.pivot.status"
                    class="w-full bg-zinc-100 dark:bg-zinc-700 rounded-md border-none focus:ring-teal-500 dark:focus:ring-teal-600"
                    name="status_semester"
                  >
                    <option value="Aktif">Aktif</option>
                    <option value="Lulus">Lulus</option>
                    <option value="Mutasi">Mutasi</option>
                    <option value="Dikeluarkan">Dikeluarkan</option>
                    <option value="Mengundurkan Diri">Mengundurkan Diri</option>
                    <option value="Wafat">Wafat</option>
                    <option value="Hilang">Hilang</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                  </select>
                </td>
                <td
                  class="text-sm text-gray-900 font-light py-3 whitespace-nowrap flex justify-center"
                >
                  <Checkbox></Checkbox>
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
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nik_ibu">NIK Ibu Kandung</label>
            <Input
              id="nik_ibu"
              v-model="form.nik_ibu"
              class="w-full"
              type="text"
              placeholder="NIK Ibu Kandung"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="nama_ibu"
            >Nama Ibu Kandung</label>
            <Input
              id="nama_ibu"
              v-model="form.nama_ibu"
              class="w-full"
              type="text"
              placeholder="Nama Ibu Kandung"
            ></Input>
          </div>
        </div>

        <!-- TTL, pendidikan ibu -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="tempat_lahir_ibu"
            >Tempat Lahir Ibu Kandung</label>
            <Input
              id="tempat_lahir_ibu"
              v-model="form.tempat_lahir_ibu"
              class="w-full"
              type="text"
              placeholder="Tempat Lahir Ibu Kandung"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="tanggal_lahir_ibu"
            >Tanggal Lahir Ibu Kandung</label>
            <Input
              id="tanggal_lahir_ibu"
              v-model="form.tanggal_lahir_ibu"
              class="w-full"
              type="date"
              placeholder="Tanggal Lahir Ibu Kandung"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="pendidikan_ibu"
            >Pendidikan Ibu Kandung</label>
            <Input
              id="pendidikan_ibu"
              v-model="form.pendidikan_ibu"
              class="w-full"
              type="text"
              placeholder="Pendidikan Ibu Kandung"
            ></Input>
          </div>
        </div>

        <!-- pekerjaan penghasilan ayah -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="pekerjaan_ibu"
            >Pekerjaan Ibu Kandung</label>
            <Input
              id="pekerjaan_ibu"
              v-model="form.pekerjaan_ibu"
              class="w-full"
              type="number"
              placeholder="Pekerjaan Ibu Kandung"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="penghasilan_ibu"
            >Penghasilan Ibu</label>
            <Input
              id="penghasilan_ibu"
              v-model="form.penghasilan_ibu"
              class="w-full"
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
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nik_ayah">NIK Ayah</label>
            <Input
              id="nik_ayah"
              v-model="form.nik_ayah"
              class="w-full"
              type="text"
              placeholder="NIK Ayah"
            ></Input>
          </div>
          <div class="w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nama_ayah">Nama Ayah</label>
            <Input
              id="nama_ayah"
              v-model="form.nama_ayah"
              class="w-full"
              type="text"
              placeholder="Nama Ayah"
            ></Input>
          </div>
        </div>

        <!-- TTL, pendidikan ayah -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="tempat_lahir_ayah"
            >Tempat Lahir Ayah</label>
            <Input
              id="tempat_lahir_ayah"
              v-model="form.tempat_lahir_ayah"
              class="w-full"
              type="text"
              placeholder="Tempat Lahir Ayah"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="tanggal_lahir_ayah"
            >Tanggal Lahir Ayah</label>
            <Input
              id="tanggal_lahir_ayah"
              v-model="form.tanggal_lahir_ayah"
              class="w-full"
              type="date"
              placeholder="Tanggal Lahir Ayah"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="pendidikan_ayah"
            >Pendidikan Ayah</label>
            <Input
              id="pendidikan_ayah"
              v-model="form.pendidikan_ayah"
              class="w-full"
              type="text"
              placeholder="Pendidikan Ayah"
            ></Input>
          </div>
        </div>

        <!-- pekerjaan penghasilan ayah -->
        <div class="mb-3 flex space-x-2">
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="pekerjaan_ayah"
            >Pekerjaan Ayah</label>
            <Input
              id="pekerjaan_ayah"
              v-model="form.pekerjaan_ayah"
              class="w-full"
              type="number"
              placeholder="Pekerjaan Ayah"
            ></Input>
          </div>
          <div class="w-full">
            <label
              class="block text-gray-500 text-sm font-bold mb-2"
              for="penghasilan_ayah"
            >Penghasilan Ayah</label>
            <Input
              id="penghasilan_ayah"
              v-model="form.penghasilan_ayah"
              class="w-full"
              type="number"
              placeholder="Penghasilan Ayah"
            ></Input>
          </div>
        </div>

        <div class="flex justify-between">
          <div>
            <Button class="px-8">Simpan</Button>

            <LinkButton
              v-if="!route().current('master.mahasiswa-konversi.create')"
              :href="'/master/mahasiswa-konversi/' + mahasiswa.npm + '/matakuliah-konversi'"
              class="bg-gray-800 hover:bg-gray-700 active:bg-gray-900 focus:border-gray-900 focus:shadow-outline-gray ml-4"
            >Matakuliah Diakui</LinkButton>
          </div>
          <Link
            v-if="!route().current('master.mahasiswa-konversi.create')"
            class="text-red-500"
            @click="remove()"
          >Hapus Data Mahasiswa Konversi</Link>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App.vue"

import Input from "@components/Input.vue"
import Checkbox from "@/Components/Checkbox.vue"
import ModalInput from "@/Components/ModalInput.vue"
import Select from "@/Components/Select.vue"
import Button from "@/Components/Button.vue"
import LinkButton from "@/Components/LinkButton.vue"

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
    Select,
    Link,
    Input,
    Button,
    ModalInput,
    Checkbox,
    Label,
    ChevronDoubleDownIcon,
    ChevronDoubleUpIcon,
    LinkButton
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
      kecamatan: props.mahasiswa?.user.kecamatan || null,
      kode_pos: props.mahasiswa?.user.kode_pos || null,
      kewarganegaraan: props.mahasiswa?.user.kewarganegaraan || 'WNI',
      provinsi: props.mahasiswa?.user.provinsi || null,
      kota: props.mahasiswa?.user.kota || null,

      // mahasiswa data
      npm: props.mahasiswa == null ? null : props.mahasiswa.npm,
      tanggal_masuk: props.mahasiswa?.tanggal_masuk,
      dosen_id: props.mahasiswa == null ? '-' : (props.mahasiswa.dosen == null ? '-' : props.mahasiswa.dosen.id),
      jurusan_id: props.mahasiswa == null ? '-' : (props.mahasiswa.jurusan == null ? '-' : props.mahasiswa.jurusan.id),
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

    const showMatakuliah = ref(false)

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


    const kotas = ['Tarakan']

    const provinsis = ['Kalimantan Utara']


    return {
      kotas,
      provinsis,
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

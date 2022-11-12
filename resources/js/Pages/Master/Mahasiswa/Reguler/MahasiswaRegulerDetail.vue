<template>
  <AppLayout>
    <div
      class="container mx-auto overflow-auto rounded-md bg-white p-6 dark:bg-zinc-800"
    >
      <p class="text-xs text-slate-500 md:text-sm">
        Mahasiswa / Mahasiswa Reguler /
        <span v-if="route().current('master.mahasiswa-reguler.create')"
          >Tambah</span
        >
        <span v-else>Ubah</span>
      </p>

      <div class="item-center my-3 flex justify-between">
        <span class="align-mnamedle">
          <strong
            class="content-mnamedle whitespace-nowrap text-sm capitalize md:text-lg"
          >
            <span v-if="route().current('master.mahasiswa-reguler.create')"
              >Tambah</span
            >
            <span v-else>Ubah</span>
            Mahasiswa Reguler
          </strong>
        </span>
      </div>

      <form @submit.prevent="submit(route().current())">
        <div class="mb-4 flex space-x-4">
          <div class="w-full">
            <Label for="npm">
              NPM / NIM
              <span class="text-red-500">*</span>
            </Label>
            <Input
              v-model="form.npm"
              class="w-full"
              name="npm"
              type="text"
              placeholder="NIM / NPM"
              required
            ></Input>
          </div>

          <div class="w-full">
            <Label for="nik">NIK</Label>
            <Input
              v-model="form.nik"
              class="w-full"
              name="nik"
              type="text"
              placeholder="NIK"
            ></Input>
          </div>
        </div>

        <div class="mb-4">
          <Label for="nama">
            Nama
            <span class="text-red-500">*</span>
          </Label>
          <Input
            v-model="form.name"
            class="w-full"
            name="nama"
            type="text"
            placeholder="Nama"
            required
          ></Input>
        </div>

        <div class="mb-4">
          <Label for="nama">
            Agama
            <span class="text-red-500">*</span>
          </Label>
          <select
            v-model="form.agama"
            class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
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
                class="checked:bg-teal-500 focus:ring-0 checked:focus:bg-teal-500 dark:checked:bg-teal-400 dark:checked:focus:bg-teal-400"
              />
              <span class="ml-2">Ya</span>
            </div>
            <div class="ml-4">
              <input
                v-model="form.kps"
                type="radio"
                name="kps"
                value="0"
                class="checked:bg-teal-500 focus:ring-0 checked:focus:bg-teal-500 dark:checked:bg-teal-400 dark:checked:focus:bg-teal-400"
              />
              <span class="ml-2">Tidak</span>
            </div>
          </div>
        </fieldset>

        <!--  tahun masuk -->
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
              :readonly="!route().current('master.mahasiswa-reguler.create')"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="tanggal_selesai">
              Tanggal Selesai
              <i>(Kosongkan jika belum lulus)</i>
            </Label>
            <Input
              v-model="form.tanggal_selesai"
              class="w-full"
              name="tanggal_lahir"
              type="date"
            ></Input>
          </div>
        </div>

        <div class="mb-4">
          <Label for="email">Email</Label>
          <Input
            v-model="form.email"
            class="w-full"
            name="email"
            type="text"
            placeholder="Email"
          ></Input>
        </div>

        <div class="mb-4">
          <Label for="jurusan">Jurusan</Label>
          <select
            v-model="form.jurusan_id"
            class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            name="jurusan"
          >
            <option value="-">-</option>
            <option
              v-for="jurusan in jurusans"
              :key="jurusan.id"
              :value="jurusan.id"
            >
              {{ jurusan.nama }} - {{ jurusan.kode_jurusan }}
            </option>
          </select>
        </div>

        <div class="mb-4">
          <Label for="dosen">Dosen Wali</Label>
          <select
            v-model="form.dosen_id"
            class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            name="dosen"
          >
            <option value="-">-</option>
            <option
              v-for="dosen in dosens"
              :key="dosen.name"
              :value="dosen.id"
            >
              {{ dosen.staff.user.name }}
            </option>
          </select>
        </div>

        <!-- TTL, Jenis Kelamin -->
        <div class="mb-4">
          <div class="flex space-x-4">
            <div class="flex-1">
              <Label for="tempat_lahir">Tempat Lahir</Label>
              <Input
                v-model="form.tempat_lahir"
                class="w-full"
                name="tempat_lahir"
                type="text"
                placeholder="Tempat lahir"
              ></Input>
            </div>
            <div>
              <Label for="tanggal_lahir">Tanggal Lahir</Label>
              <Input
                v-model="form.tanggal_lahir"
                class="w-full"
                name="tanggal_lahir"
                type="date"
                placeholder="tanggal lahir"
              ></Input>
            </div>
            <div class="flex-1">
              <Label for="jenis_kelamin">Jenis Kelamin</Label>
              <select
                v-model="form.jenis_kelamin"
                class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
                name="jenis_kelamin"
              >
                <option value="Laki-laki" selected>Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
              </select>
            </div>
          </div>
        </div>

        <!-- NISN, NPWP -->
        <div class="mb-4 flex space-x-4">
          <div class="w-full">
            <Label for="npwp">NPWP</Label>
            <Input
              v-model="form.npwp"
              class="w-full"
              name="npwp"
              type="text"
              placeholder="NPWP"
            ></Input>
          </div>
        </div>

        <!-- alamat jalan -->
        <div class="mb-4">
          <Label for="jalan">Jalan</Label>
          <Input
            v-model="form.jalan"
            class="w-full"
            name="jalan"
            type="text"
            placeholder="Jalan"
          ></Input>
        </div>

        <!-- kelurahan, kecamatan, kode pos -->
        <div class="mb-4 flex space-x-4">
          <div class="w-full">
            <Label for="kelurahan">Kelurahan</Label>
            <Input
              v-model="form.kelurahan"
              class="w-full"
              name="kelurahan"
              type="text"
              placeholder="Kelurahan"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="kecamatan">Kecamatan</Label>
            <Input
              v-model="form.kecamatan"
              class="w-full"
              name="kecamatan"
              type="text"
              placeholder="Kecamatan"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="kode_pos">Kode Pos</Label>
            <Input
              v-model="form.kode_pos"
              class="w-full"
              name="kode_pos"
              type="text"
              placeholder="Kode pos"
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
            >
              <template #option="option">
                <option :value="option.data.id">{{ option.data.nama }}</option>
              </template>
            </Select>
            <!-- <InputError class="mt-2" :message="form.errors.ruangan_id" /> -->
          </div>
        </div>

        <!-- nomor hp -->
        <div class="mb-4">
          <Label for="nomor_hp">Nomor HP</Label>
          <Input
            v-model="form.nomor_hp"
            class="w-full"
            name="nomor_hp"
            type="text"
            placeholder="Nomor HP"
          ></Input>
        </div>

        <!-- jenis tinggal, alat transportasi -->
        <div class="mb-4 flex space-x-4">
          <div class="w-full">
            <Label for="jenis_tinggal">Jenis Tinggal</Label>
            <select
              v-model="form.jenis_tinggal"
              class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            >
              <option selected disabled value="-">Pilih jenis tinggal</option>
              <option value="Bersama Orang Tua">Bersama Orang Tua</option>
              <option value="Wali">Wali</option>
              <option value="Kos">Kos</option>
              <option value="Asrama">Asrama</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
          <div class="w-full">
            <Label for="alat_transportasi">Alat Transportasi</Label>
            <select
              v-model="form.alat_transportasi"
              class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
            >
              <option selected disabled value="-">
                Pilih alat transportasi
              </option>
              <option value="Sepeda">Sepeda</option>
              <option value="Sepeda Motor">Sepeda Motor</option>
              <option value="Mobil Pribadi">Mobil Pribadi</option>
              <option value="Angkutan Umum">Angkutan Umum</option>
              <option value="Ojek">Ojek</option>
              <option value="Jalan Kaki">Jalan Kaki</option>
              <option value="Lainnya">Lainnya</option>
            </select>
          </div>
        </div>

        <p v-if="currentRouteName == 'Edit'" class="mb-4 text-sm md:text-lg">
          <strong>SLTA</strong>
        </p>

        <!-- SLTA -->
        <div class="mb-4 w-full">
          <Label for="nisn">NISN</Label>
          <Input
            v-model="form.nisn"
            class="w-full"
            name="nisn"
            type="text"
            placeholder="NISN"
          ></Input>
        </div>
        <div class="mb-4 flex space-x-3">
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

        <p v-if="currentRouteName == 'Edit'" class="mb-4 text-sm md:text-lg">
          <strong>Riwayat Status Kuliah</strong>
        </p>

        <!-- Data riwayat status kuliah -->
        <div v-if="currentRouteName == 'Edit'" class="mb-4 w-full">
          <table class="w-full table-auto">
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
                    class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
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
                  class="flex justify-center whitespace-nowrap py-3 text-sm font-light text-gray-900"
                >
                  <Checkbox></Checkbox>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- DATA ORANG TUA -->

        <p class="mb-4 text-sm md:text-lg">
          <strong>Data Orang Tua</strong>
        </p>

        <!-- Ibu Kandung-->
        <p class="mb-4 text-xs md:text-sm">
          <strong>Ibu Kandung</strong>
        </p>

        <!-- NIK, NAMA -->
        <div class="mb-4 flex space-x-4">
          <div class="w-full">
            <Label for="nik_ibu">NIK Ibu Kandung</Label>
            <Input
              v-model="form.nik_ibu"
              class="w-full"
              name="nik_ibu"
              type="text"
              placeholder="NIK ibu kandung"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="nama_ibu">Nama Ibu Kandung</Label>
            <Input
              v-model="form.nama_ibu"
              class="w-full"
              name="nama_ibu"
              type="text"
              placeholder="Nama ibu kandung"
            ></Input>
          </div>
        </div>

        <!-- TTL, pendnameikan ibu -->
        <div class="mb-4 flex space-x-4">
          <div class="w-full">
            <Label for="tempat_lahir_ibu">Tempat Lahir Ibu Kandung</Label>
            <Input
              v-model="form.tempat_lahir_ibu"
              class="w-full"
              name="tempat_lahir_ibu"
              type="text"
              placeholder="Tempat lahir ibu kandung"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="tanggal_lahir_ibu">Tanggal lahir ibu Kandung</Label>
            <Input
              v-model="form.tanggal_lahir_ibu"
              class="w-full"
              name="tanggal_lahir_ibu"
              type="date"
              placeholder="Tanggal lahir ibu kandung"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="pendnameikan_ibu">Pendidikan Ibu</Label>
            <Input
              v-model="form.pendnameikan_ibu"
              class="w-full"
              name="pendnameikan_ibu"
              type="text"
              placeholder="Pendidikan ibu"
            ></Input>
          </div>
        </div>

        <!-- pekerjaan penghasilan ayah -->
        <div class="mb-4 flex space-x-4">
          <div class="w-full">
            <Label for="pekerjaan_ibu">Pekerjaan Ibu Kandung</Label>
            <Input
              v-model="form.pekerjaan_ibu"
              class="w-full"
              name="pekerjaan_ibu"
              type="text"
              placeholder="Pekerjaan ibu kandung"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="penghasilan_ibu">Penghasilan Ibu Kandung</Label>
            <select
              v-model="form.penghasilan_ibu"
              class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
              name="penghasilan_ibu"
            >
              <option selected disabled value="-">
                Pilih penghasilan ibu kandung
              </option>
              <option value="< Rp 500.000">&lt; Rp 500.000</option>
              <option value="Rp 500.000 - Rp 999.999">
                Rp 500.000 - Rp 999.999
              </option>
              <option value="Rp 1.000.000 - Rp 1.999.999">
                Rp 1.000.000 - Rp 1.999.999
              </option>
              <option value="Rp 2.000.000 - Rp 4.999.999">
                Rp 2.000.000 - Rp 4.999.999
              </option>
              <option value="Rp 5.000.000 - Rp 20.000.000">
                Rp 5.000.000 - Rp 20.000.000
              </option>
              <option value="> Rp 20.000.000">&gt; Rp 20.000.000</option>
            </select>
          </div>
        </div>

        <!-- Ayah -->
        <p class="mb-4 text-xs md:text-sm">
          <strong>Ayah</strong>
        </p>

        <!-- NIK, NAMA -->
        <div class="mb-4 flex space-x-4">
          <div class="w-full">
            <Label for="nik_ayah">NIK Ayah</Label>
            <Input
              v-model="form.nik_ayah"
              class="w-full"
              name="nik_ayah"
              type="text"
              placeholder="NIK ayah"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="nama_ayah">Nama Ayah</Label>
            <Input
              v-model="form.nama_ayah"
              class="w-full"
              name="nama_ayah"
              type="text"
              placeholder="Nama ayah"
            ></Input>
          </div>
        </div>

        <!-- TTL, pendnameikan ayah -->
        <div class="mb-4 flex space-x-4">
          <div class="w-full">
            <Label for="tempat_lahir_ayah">Tempat Lahir Ayah</Label>
            <Input
              v-model="form.tempat_lahir_ayah"
              class="w-full"
              name="tempat_lahir_ayah"
              type="text"
              placeholder="Tempat lahir ayah"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="tanggal_lahir_ayah">Tanggal Lahir Ayah</Label>
            <Input
              v-model="form.tanggal_lahir_ayah"
              class="w-full"
              name="tanggal_lahir_ayah"
              type="date"
              placeholder="Tanggal lahir ayah"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="pendidikan_ayah">Pendidikan Ayah</Label>
            <Input
              v-model="form.pendidikan_ayah"
              class="w-full"
              name="pendidikan_ayah"
              type="text"
              placeholder="Pendidikan ayah"
            ></Input>
          </div>
        </div>

        <!-- pekerjaan penghasilan ayah -->
        <div class="mb-4 flex space-x-4">
          <div class="w-full">
            <Label for="pekerjaan_ayah">Pekerjaan Ayah</Label>
            <Input
              v-model="form.pekerjaan_ayah"
              class="w-full"
              name="pekerjaan_ayah"
              type="text"
              placeholder="Pekerjaan ayah"
            ></Input>
          </div>
          <div class="w-full">
            <Label for="penghasilan_ayah">Penghasilan Ayah</Label>
            <select
              v-model="form.penghasilan_ayah"
              class="w-full rounded-md border-none bg-zinc-100 focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
              name="penghasilan_ayah"
            >
              <option selected disabled value="-">
                Pilih penghasilan ayah
              </option>
              <option value="< Rp 500.000">&lt; Rp 500.000</option>
              <option value="Rp 500.000 - Rp 999.999">
                Rp 500.000 - Rp 999.999
              </option>
              <option value="Rp 1.000.000 - Rp 1.999.999">
                Rp 1.000.000 - Rp 1.999.999
              </option>
              <option value="Rp 2.000.000 - Rp 4.999.999">
                Rp 2.000.000 - Rp 4.999.999
              </option>
              <option value="Rp 5.000.000 - Rp 20.000.000">
                Rp 5.000.000 - Rp 20.000.000
              </option>
              <option value="> Rp 20.000.000">&gt; Rp 20.000.000</option>
            </select>
          </div>
        </div>

        <div class="flex justify-between">
          <Button class="px-10">Simpan</Button>
          <Link
            v-if="!route().current('master.mahasiswa-reguler.create')"
            class="text-red-500"
            @click="remove()"
            >Hapus Data Mahasiswa Reguler</Link
          >
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script>
import AppLayout from "@layouts/App"

import Input from "@components/Input"
import Button from "@components/Button"
import Label from "@components/Label"
import NavLink from "@/Components/NavLink"
import Checkbox from "@/Components/Checkbox.vue"
import Select from "@/Components/Select.vue"

import { Link } from "@inertiajs/inertia-vue3"

import { computed, ref, reactive, onMounted } from "vue"
import { Inertia } from "@inertiajs/inertia"
// import route from 'vendor/tightenco/ziggy/src/js'
export default {
  components: {
    AppLayout,
    Select,
    Link,
    Checkbox,
    NavLink,
    Label,
    Input,
    Button,
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
    tahun_ajaran: Object,
    // provinsis: Array,
    // kotas: Array
  },
  setup(props) {
    const form = reactive({
      // name: props.mahasiswa?.user.name || null,
      id: props.mahasiswa?.user?.id || null,
      email: props.mahasiswa?.user?.email || null,
      name: props.mahasiswa?.user?.name || null,
      nik: props.mahasiswa == null ? null : props.mahasiswa.user.nik,
      jenis_kelamin: props.mahasiswa?.user.jenis_kelamin || "Laki-laki",
      agama: props.mahasiswa?.user.agama || null,
      nomor_hp: props.mahasiswa?.user.nomor_hp || null,
      tempat_lahir: props.mahasiswa?.user.tempat_lahir || null,
      tanggal_lahir: props.mahasiswa?.user.tanggal_lahir || null,
      jalan: props.mahasiswa?.user.jalan || null,
      kelurahan: props.mahasiswa?.user.kelurahan || null,
      provinsi: props.mahasiswa?.user.provinsi || null,
      kota: props.mahasiswa?.user.kota || null,
      kode_pos: props.mahasiswa?.user.kode_pos || null,
      kewarganegaraan: props.mahasiswa?.user.kewarganegaraan || "WNI",

      // mahasiswa data
      npm: props.mahasiswa == null ? null : props.mahasiswa.npm,
      tanggal_masuk: props.mahasiswa?.tanggal_masuk,
      tanggal_selesai: props.mahasiswa?.tanggal_selesai,
      dosen_id:
        props.mahasiswa == null
          ? "-"
          : props.mahasiswa.dosen == null
          ? "-"
          : props.mahasiswa.dosen.id,
      jurusan_id:
        props.mahasiswa == null
          ? "-"
          : props.mahasiswa.jurusan == null
          ? "-"
          : props.mahasiswa.jurusan.id,
      nisn: props.mahasiswa?.nisn || null,
      jenis_tinggal: props.mahasiswa?.jenis_tinggal || null,
      alat_transportasi: props.mahasiswa?.alat_transportasi || null,
      npwp: props.mahasiswa?.npwp || null,
      kps: props.mahasiswa?.kps || 0,
      daerah_asal: props.mahasiswa?.daerah_asal || null,
      asal_slta: props.mahasiswa?.asal_slta || null,
      tahun_lulus_slta: props.mahasiswa?.tahun_lulus_slta || null,

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
      pendidikan_ibu: props.mahasiswa?.pendnameikan_ibu || null,
      pekerjaan_ibu: props.mahasiswa?.pekerjaan_ibu || null,
      penghasilan_ibu: props.mahasiswa?.penghasilan_ibu || null,

      uang_semester: props.mahasiswa?.uang_semester || null,
      status_mahasiswa: props.mahasiswa?.status_mahasiswa || "Aktif",
    })

    const kotas = ref([])
    const provinsis = ref([])

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

    function submit(curRoute) {
      if (curRoute === "master.mahasiswa-reguler.create") {
        // alert(util.isEmptyObject(props.staff))
        // alert(props.staff == null ? 'null bro' : 'ada bro')
        Inertia.post(route("master.mahasiswa-reguler.store"), form)
      } else {
        // form.name = props.mahasiswa?.user.name || null
        Inertia.put(
          route("master.mahasiswa-reguler.update", props.mahasiswa.npm),
          form
        )
      }
    }

    function remove() {
      // alert(props.staff.nip);
      Inertia.delete(
        route("master.mahasiswa-reguler.destroy", props.mahasiswa.npm)
      )
    }

    const currentRouteName = computed(() =>
      route().current("master.mahasiswa-reguler.create") ? "Tambah" : "Edit"
    )


    return {
      form,
      kotas,
      provinsis,
      getKabupatenKota,
      submit,
      remove,
      currentRouteName,
    }
  },
}
</script>

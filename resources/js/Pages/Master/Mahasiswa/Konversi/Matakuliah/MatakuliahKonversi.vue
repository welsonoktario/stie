<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs text-slate-500 md:text-sm">
        Mahasiswa / Mahasiswa Konversi / Matakuliah Diakui
        <!-- <span v-if="route().current('master.mahasiswa-konversi.create')">Tambah</span>
        <span v-else>Ubah</span>-->
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
          >
            <!-- <span v-if="route().current('master.mahasiswa-konversi.create')">Tambah</span>
            <span v-else>Ubah</span>-->
            Data Mahasiswa
          </strong>
        </span>
      </div>

      <form>
        <div class="flex flex-col sm:flex-row sm:space-x-3">
          <div class="mb-3 w-full">
            <label class="mb-2 block text-sm font-bold text-gray-500" for="npm"
              >NPM / NIM</label
            >
            <Input
              id="npm"
              v-model="form.npm"
              class="w-full"
              type="text"
              placeholder="NIM / NPM"
              disabled
            ></Input>
          </div>

          <div class="mb-3 w-full">
            <label class="mb-2 block text-sm font-bold text-gray-500" for="nik"
              >NIK</label
            >
            <Input
              id="nik"
              v-model="form.nik"
              class="w-full"
              type="text"
              placeholder="NIK"
              disabled
            ></Input>
          </div>
        </div>

        <div class="flex flex-col sm:flex-row sm:space-x-3">
          <div class="mb-3 w-full">
            <label class="mb-2 block text-sm font-bold text-gray-500" for="nama"
              >Nama</label
            >
            <Input
              id="nama"
              v-model="form.name"
              class="w-full"
              type="text"
              placeholder="Nama"
              disabled
            ></Input>
          </div>

          <div class="mb-3 w-full">
            <label class="mb-2 block text-sm font-bold text-gray-500" for="ip"
              >IP Konversi</label
            >
            <Input
              id="ip"
              v-model="ip"
              class="w-full"
              type="text"
              placeholder="IP"
              disabled
            ></Input>
          </div>
        </div>


        <div class="flex flex-col sm:flex-row sm:space-x-3">
          <div class="mb-3 w-full">
            <label class="mb-2 block text-sm font-bold text-gray-500" for="nama"
              >SKS diakui</label
            >
            <Input
              id="nama"
              class="w-full"
              v-model="sksDiakui"
              type="text"
              placeholder="Nama"
              disabled
            ></Input>
          </div>
        </div>
      </form>

      <!-- list matakuliah konversi -->
      <div v-show="showMatakuliah">
        <div class="my-3 flex items-center justify-between sm:gap-2 md:gap-0">
          <span>
            <strong class="whitespace-nowrap text-xs capitalize md:text-lg"
              >Matakuliah Diakui</strong
            >
          </span>

          <LinkButton
            v-if="!route().current('master.mahasiswa-konversi.create')"
            :href="
              route('master.mahasiswa-konversi.matakuliah.create', {
                mahasiswa_konversi_id: mahasiswa.npm
              })"
            >Tambah Matakuliah Diakui</LinkButton
          >
        </div>
        <div
          class="mt-2 w-full rounded-md shadow-md dark:bg-zinc-700 dark:text-zinc-100"
        >
          <table class="w-full table-auto">
            <thead>
              <tr>
                <th scope="col" class="py-2 px-4 text-left font-semibold">
                  No
                </th>
                <th scope="col" class="py-2 px-4 text-left font-semibold">
                  Kode MK Lama
                </th>
                <th scope="col" class="py-2 px-4 text-left font-semibold">
                  Nama MK Lama
                </th>
                <th scope="col" class="py-2 px-4 text-left font-semibold">
                  SKS
                </th>
                <th scope="col" class="py-2 px-4 text-left font-semibold">
                  Kode MK Baru
                </th>
                <th scope="col" class="py-2 px-4 text-left font-semibold">
                  Nama MK Baru
                </th>
                <th scope="col" class="py-2 px-4 text-left font-semibold">
                  SKS
                </th>
                <th scope="col" class="py-2 px-4 text-left font-semibold">
                  Nilai
                </th>
                <th scope="col" class="py-2 px-4 text-left font-semibold">
                  <!-- <span class="sr-only">Edit</span>
                  --+-->
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="(matakuliah, index) in matakuliahs" :key="matakuliah.id">
                <td
                  class="border-y py-2 px-4 text-sm font-semibold dark:border-zinc-600 dark:text-zinc-200"
                >
                  {{ index+1 }}
                </td>
                <td
                  class="border-y py-2 px-4 text-sm font-normal dark:border-zinc-600 dark:text-zinc-200"
                >
                  {{ matakuliah.kode_matakuliah }}
                </td>

                <td
                  class="border-y py-2 px-4 text-sm font-normal dark:border-zinc-600 dark:text-zinc-200"
                >
                  {{ matakuliah.nama_matakuliah }}
                </td>
                <td
                  class="border-y py-2 px-4 text-sm font-normal dark:border-zinc-600 dark:text-zinc-200"
                >
                  {{ matakuliah.sks_matakuliah }}
                </td>
                <td
                  class="border-y py-2 px-4 text-sm font-normal dark:border-zinc-600 dark:text-zinc-200"
                >
                  {{ matakuliah.matakuliah.kode_matakuliah }}
                </td>
                <td
                  class="border-y py-2 px-4 text-sm font-normal dark:border-zinc-600 dark:text-zinc-200"
                >
                  {{ matakuliah.matakuliah.nama_matakuliah }}
                </td>
                <td
                  class="border-y py-2 px-4 text-sm font-normal dark:border-zinc-600 dark:text-zinc-200"
                >
                  {{ matakuliah.matakuliah.sks }}
                </td>
                <td
                  class="border-y py-2 px-4 text-sm font-normal dark:border-zinc-600 dark:text-zinc-200"
                >
                  {{ matakuliah.nilai_matakuliah }}
                </td>
                <td
                  class="border-y py-2 px-4 text-sm font-normal dark:border-zinc-600 dark:text-zinc-200"
                >
                  <Link
                    :href="
                      route('master.mahasiswa-konversi.matakuliah.show', {
                        mahasiswa_konversi_id: mahasiswa.npm,
                        matakuliah_konversi_id: matakuliah.id
                      })"
                    class="text-indigo-600 hover:text-indigo-900"
                    >Edit</Link
                  >
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="mt-5 flex justify-end w-full">
        <LinkButton
            class="bg-white text-slate-800 hover:bg-slate-100"

              v-if="!route().current('master.mahasiswa-konversi.create')"
              :href="
              route('master.mahasiswa-konversi.index')"
            >Kembali</LinkButton
          >
      </div>
    </div>

  </AppLayout>
</template>

<script>
import { reactive, ref, computed } from "vue"
import { Inertia } from "@inertiajs/inertia"
import { Link } from "@inertiajs/inertia-vue3"
import {
  ChevronDoubleDownIcon,
  ChevronDoubleUpIcon,
} from "@heroicons/vue/outline"
import AppLayout from "@layouts/App"
import Input from "@components/Input"
import ModalInput from "@/Components/ModalInput"
import LinkButton from "@/Components/LinkButton"

export default {
  components: {
    AppLayout,
    Link,
    Input,
    ModalInput,
    ChevronDoubleDownIcon,
    ChevronDoubleUpIcon,
    LinkButton,
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
    },
    ip: String,
  },
  setup(props) {
    const showModalMatakuliah = ref(true)

    const form = reactive({
      // user data
      email: props.mahasiswa == null ? null : props.mahasiswa.user.email,
      name: props.mahasiswa == null ? null : props.mahasiswa.user.name,
      nik: props.mahasiswa == null ? null : props.mahasiswa.user.nik,

      // mahasiswa data
      npm: props.mahasiswa == null ? null : props.mahasiswa.npm,
      dosen:
        props.mahasiswa == null
          ? "-"
          : props.mahasiswa.dosen == null
          ? "-"
          : props.mahasiswa.dosen.id,
      jurusan:
        props.mahasiswa == null
          ? "-"
          : props.mahasiswa.jurusan == null
          ? "-"
          : props.mahasiswa.jurusan.id,
    })

    const showMatakuliah = ref(true)

    const sksDiakui = computed (()=> {
        let sksTotal = 0
        props.matakuliahs.forEach(mk => {
          sksTotal += mk.matakuliah.sks
        });
        return sksTotal
    })


    return {
      sksDiakui,
      showModalMatakuliah,
      form,
      showMatakuliah,
    }
  },
}
</script>

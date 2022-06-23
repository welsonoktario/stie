<template>
  <AppLayout>
    <div class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
      <p class="text-xs md:text-sm text-slate-500">
        Mahasiswa / Mahasiswa Konversi / Matakuliah Diakui
        <!-- <span v-if="route().current('master.mahasiswa-konversi.create')">Tambah</span>
        <span v-else>Ubah</span>-->
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong class="whitespace-nowrap capitalize text-sm md:text-lg content-middle">
            <!-- <span v-if="route().current('master.mahasiswa-konversi.create')">Tambah</span>
            <span v-else>Ubah</span>-->
            Data Mahasiswa
          </strong>
        </span>
      </div>

      <form @submit.prevent="submit(route().current())">
        <div class="flex sm:space-x-3 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="npm">NPM / NIM</label>
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
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nik">NIK</label>
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

        <div class="flex sm:space-x-3 sm:flex-row flex-col">
          <div class="mb-3 w-full">
            <label class="block text-gray-500 text-sm font-bold mb-2" for="nama">Nama</label>
            <Input
              id="nama"
              v-model="form.name"
              class="w-full"
              type="text"
              placeholder="Nama"
              disabled
            ></Input>
          </div>
        </div>
      </form>

      <!-- list matakuliah konversi -->

      <!-- <div class="w-full bg-slate-100 my-3 flex justify-center p-2 hover:bg-slate-200 rounded-md" @click="showMatakuliah = !showMatakuliah">
        <ChevronDoubleDownIcon v-if="!showMatakuliah" class="h-5 w-5 text-slate-500"></ChevronDoubleDownIcon>
        <ChevronDoubleUpIcon v-if="showMatakuliah" class="h-5 w-5 text-slate-500"></ChevronDoubleUpIcon>
      </div>-->
      <div v-show="showMatakuliah">
        <div class="flex justify-between my-3 sm:gap-2 md:gap-0 items-center">
          <span>
            <strong class="whitespace-nowrap capitalize text-xs md:text-lg">Matakuliah Diakui</strong>
          </span>

          <LinkButton
            v-if="!route().current('master.mahasiswa-konversi.create')"
            :href="`/master/mahasiswa-konversi/${mahasiswa.npm}/matakuliah-konversi/create`"
          >Tambah Matakuliah Diakui</LinkButton>
        </div>
        <div class="w-full rounded-md shadow-md mt-2 dark:bg-zinc-700 dark:text-zinc-100">
          <table class="table-auto w-full">
            <thead>
              <tr>
                <th scope="col" class="font-semibold text-left py-2 px-4">Kode MK Lama</th>
                <th scope="col" class="font-semibold text-left py-2 px-4">Nama MK Lama</th>
                <th scope="col" class="font-semibold text-left py-2 px-4">SKS</th>
                <th scope="col" class="font-semibold text-left py-2 px-4">Kode MK Baru</th>
                <th scope="col" class="font-semibold text-left py-2 px-4">Nama MK Baru</th>
                <th scope="col" class="font-semibold text-left py-2 px-4">SKS</th>
                <th scope="col" class="font-semibold text-left py-2 px-4">Nilai</th>
                <th scope="col" class="font-semibold text-left py-2 px-4">
                  <!-- <span class="sr-only">Edit</span>
                  --+-->
                </th>
              </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
              <tr v-for="matakuliah in matakuliahs" :key="matakuliah.id">
                <td
                  class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal"
                >{{ matakuliah.kode_matakuliah }}</td>

                <td
                  class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal"
                >{{ matakuliah.nama_matakuliah }}</td>
                <td
                  class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal"
                >{{ matakuliah.sks_matakuliah }}</td>
                <td
                  class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal"
                >{{ matakuliah.matakuliah.kode_matakuliah }}</td>
                <td
                  class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal"
                >{{ matakuliah.matakuliah.nama_matakuliah }}</td>
                <td
                  class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal"
                >{{ matakuliah.matakuliah.sks }}</td>
                <td
                  class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal"
                >{{ matakuliah.nilai_matakuliah }}</td>
                <td class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal">
                  <Link
                    :href="'/master/mahasiswa-konversi/' + mahasiswa.npm + '/matakuliah-konversi/' + matakuliah.id"
                    class="text-indigo-600 hover:text-indigo-900"
                  >Edit</Link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script>
import { reactive, ref } from "vue"
import { Inertia } from "@inertiajs/inertia"
import { Link } from "@inertiajs/inertia-vue3"
import {
  ChevronDoubleDownIcon,
  ChevronDoubleUpIcon
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

      // mahasiswa data
      npm: props.mahasiswa == null ? null : props.mahasiswa.npm,
      dosen: props.mahasiswa == null ? '-' : (props.mahasiswa.dosen == null ? '-' : props.mahasiswa.dosen.id),
      jurusan: props.mahasiswa == null ? '-' : (props.mahasiswa.jurusan == null ? '-' : props.mahasiswa.jurusan.id),

    })

    const showMatakuliah = ref(true)

    function submit(curRoute) {
      if (curRoute === "master.mahasiswa-konversi.create") {
        // alert(util.isEmptyObject(props.staff))
        // alert(props.staff == null ? 'null bro' : 'ada bro')
        Inertia.post(route("master.mahasiswa-konversi.store"), form)
      } else {
        Inertia.put(route("master.mahasiswa-konversi.update", props.mahasiswa.npm), form)
      }
    }

    function remove() {
      // alert(props.staff.nip);
      Inertia.delete(route("master.mahasiswa-konversi.destroy", props.mahasiswa.npm))
    }

    return {
      showModalMatakuliah,
      form,
      submit,
      remove,
      showMatakuliah
    }
  },
}
</script>

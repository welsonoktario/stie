<template>
  <DashboardLayout>
    <div
      class="bg-white dark:bg-zinc-800 overflow-hidden shadow-sm sm:rounded-lg p-6"
    >
      <!-- <div class="p-6">Karyawan / Karyawan</div> -->
      <p class="text-xs md:text-sm text-slate-500">Karyawan / Karyawan /
          <span v-if="route().current('karyawan.create')">Tambah</span>
          <span v-else>Ubah</span>
      </p>

      <!-- <p>{{route().current()}}</p> -->
      <div class="flex justify-between my-3 item-center">
        <span class="align-middle">
          <strong class="whitespace-nowrap capitalize text-sm md:text-lg content-middle">
              <span v-if="route().current('karyawan.create')">Tambah</span>
              <span v-else>Ubah</span>
               Karyawan</strong>
        </span>
      </div>
      <form @submit.prevent='submit(route().current())'>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="id"> ID <i> (Nomor Induk Karyawan)</i> </label>
          <Input v-model='form.id' class="w-full" id="id" type="text" placeholder="ID"></Input>
        </div>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="nitk"> NITK <i> (Tenaga Kependidikan - Opsional)</i> </label>
          <Input v-model='form.id' class="w-full" id="nitk" type="text" placeholder="NITK (Opsional)"></Input>
        </div>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="nama"> Nama </label>
          <Input v-model='form.name' class="w-full" id="nama" type="text" placeholder="Nama"></Input>
        </div>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="nik"> NIK </label>
          <Input v-model='form.nik' class="w-full" id="nik" type="text" placeholder="NIK"></Input>
        </div>
        <div class="mb-3">
          <label class="block text-gray-500 text-sm font-bold mb-2" for="email"> Email </label>
          <Input v-model='form.email' class="w-full" id="email" type="text" placeholder="Email"></Input>
        </div>
        <div class="flex justify-between">
        	<Button class="px-10">Simpan</Button>
					<Link @click='remove()' class="text-red-500">Hapus Data Karyawan</Link>
        </div>
      </form>

    </div>
  </DashboardLayout>
</template>

<script>
import DashboardLayout from "@layouts/Dashboard.vue"

import Input from "@components/Input.vue"
import Button from '@components/Button.vue'

import { Link } from "@inertiajs/inertia-vue3"


import util from "@/util"

import { reactive, ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
export default {
  components: {
    DashboardLayout,
    Link,
    Input,
    Button
  },
  props: {
      staff: {
          type: Object,
					default: null
      }
  },
  setup(props){
    const form = reactive({
      email: props.staff == null ? null : props.staff.user.email,
      name: props.staff == null ? null : props.staff.user.name,
      nik: props.staff == null ? null : props.staff.user.nik,
      id: props.staff == null ? null : props.staff.id,
    });

    function submit(curRoute) {
      if(curRoute === 'karyawan.create'){
				// alert(util.isEmptyObject(props.staff))
				// alert(props.staff == null ? 'null bro' : 'ada bro')
      	Inertia.post('/master/karyawan', form)
			} else {
				Inertia.put(route('karyawan.update', props.staff.id), form)
			}
    }

		function remove(){
			// alert(props.staff.nip);
			Inertia.delete(route('karyawan.destroy', props.staff.id))
			
		}
    return {
      form,
      submit,
			remove
    }
  }

}
</script>

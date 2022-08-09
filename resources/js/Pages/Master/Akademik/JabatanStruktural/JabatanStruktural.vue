<template>
  <AppLayout>
    <div
      class="overflow-hidden bg-white p-6 shadow-sm dark:bg-zinc-800 sm:rounded-lg"
    >
      <p class="text-xs md:text-sm">Akademik / Jabatan Struktural</p>
      <div class="item-center my-3 flex justify-between">
        <span class="align-middle">
          <strong
            class="content-middle whitespace-nowrap text-sm capitalize md:text-lg"
            >Daftar Jabatan Struktural</strong
          >
        </span>

        <!-- <Button type="button">
          <Link :href="route('master.tahun-ajaran.create')">
            Tambah Tahun Akademik
          </Link>
        </Button>-->
      </div>

      <DataTable :columns="columns" :data="jabatans">
        <template #actions="row">
          <NavLink>Edit</NavLink>
        </template>

        <!-- <template #row(name)="row">

        </template>-->
        <template #row(name)="row">
          <p v-if="!row.data.name">-</p>
          <!-- <p v-if="row.data.gelar_belakang || row.data.gelar_depan">{{row.data.gelar_depan}} {{row.data.name}}{{", " + row.data.gelar_belakang}}</p> -->
          <p v-else>
            {{ row.data.gelar_depan }} {{ row.data.name
            }}{{ ", " + row.data.gelar_belakang }}
          </p>
          <!-- <p v-else>{{row.data.name}}</p> -->
          <!-- <p v-else>{{row.data.name}}</p> -->
        </template>
      </DataTable>
    </div>
  </AppLayout>
</template>

<script>
import { Link } from "@inertiajs/inertia-vue3"
import AppLayout from "@layouts/App"
import Button from "@components/Button"
import DataTable from "@/Components/DataTable"
import NavLink from "@/Components/NavLink"

export default {
  components: {
    AppLayout,
    DataTable,
    Button,
    NavLink,
    Link,
  },
  props: {
    jabatans: Object,
  },
  setup(props) {
    const columns = [
      {
        key: "nama_jabatan",
        label: "Jabatan",
      },
      {
        key: "name",
        label: "Pemangku Jabatan",
      },
    ]

    return {
      columns,
    }
  },
}
</script>

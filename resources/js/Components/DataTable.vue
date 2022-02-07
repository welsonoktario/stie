<template>
  <div class="w-full rounded-md shadow">
    <table class="table-auto w-full">
      <thead>
        <tr>
          <th
            v-for="column in columns"
            :key="column.key"
            class="font-semibold text-left py-1 px-2"
          >
            {{ column.label }}
          </th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(row, index) in data.data" :key="index" class="border-y">
          <td
            v-for="column in columns"
            :key="rowKey(column.key, index)"
            class="py-1 px-2"
          >
            {{ row[column.key] }}
          </td>
          <td>
            <Link as="button" :href="route('master.matakuliah.edit', row.id)">Edit</Link>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="inline-flex items-center justify-between px-2 py-4 w-full">
      <p class="flex-1 text-sm">
        Menampilkan <span class="font-semibold">{{ data.per_page }}</span> data
        dari total <span class="font-semibold">{{ data.total }}</span> data
      </p>
      <select name="per_page" class="form-select rounded-md py-1 bg-zinc-50 border-none focus:ring-teal-500 focus:ring-2">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
      </select>
      <div class="inline-flex justify-end">
        <div
          v-for="link in data.links"
          class="mx-2"
          :class="{ 'text-teal-500': link.active }"
        >
          <Link
            v-if="link.url"
            :href="link.url"
            as="button"
            :disabled="link.active"
          >
            <span v-html="link.label"></span>
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from "@inertiajs/inertia-vue3"

defineProps({
  columns: Array,
  data: Object,
})

const rowKey = (col, index) => `${col}-${index}`
</script>

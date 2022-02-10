<template>
  <div class="inline-flex items-center justify-between w-full">
    <div class="inline-flex items-center text-sm">
      <label for="per_page">Data per halaman</label>
      <select
        name="per_page"
        class="form-select rounded-md ml-2 text-sm bg-zinc-100 dark:bg-zinc-700 border-none focus:ring-teal-500 focus:ring-2"
        v-model="filter.perPage"
        @change="search"
      >
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
      </select>
    </div>

    <label
      class="relative rounded-md text-sm bg-zinc-100 dark:bg-zinc-700 border-none focus-within:ring-teal-500 focus:ring-2"
    >
      <SearchIcon
        class="w-4 h-4 absolute top-1/2 transform -translate-y-1/2 left-3 text-zinc-500 focus-within:text-zinc-900 pointer-events-none"
      />
      <input
        type="text"
        name="query"
        class="form-input border-none mr-1 ml-5 text-sm bg-zinc-100 dark:bg-zinc-700 focus:ring-0 placeholder:text-zinc-500"
        placeholder="Cari data"
        autocomplete="off"
        v-model="filter.query"
        @input="search"
      />
    </label>
  </div>
  <div
    class="w-full rounded-md shadow-md mt-2 dark:bg-zinc-700 dark:text-zinc-100"
  >
    <table class="table-auto w-full">
      <thead>
        <tr>
          <th
            v-for="(column, index) in columns"
            :key="column.key"
            class="font-semibold text-left py-2 px-4"
          >
            <div
              class="inline-flex justify-between items-center w-full tracking-wider"
              :class="{ 'cursor-pointer': column.sortable }"
              @click="sortCol(column.key, index)"
            >
              <slot :name="`col(${column.key})`" :data="column" :index="index">
                {{ column.label }}
              </slot>
              <template v-if="column.sortable && filter.orderBy == column.key">
                <SortAscendingIcon
                  v-if="filter.orderType == 'ASC'"
                  class="w-4 h-4 ml-2"
                />
                <SortDescendingIcon
                  v-if="filter.orderType == 'DESC'"
                  class="w-4 h-4 ml-2"
                />
              </template>
            </div>
          </th>
          <th v-if="this.$slots.actions"></th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="(row, index) in data.data"
          :key="index"
          class="border-y dark:border-zinc-600 text-sm dark:text-zinc-200 font-normal"
        >
          <td
            v-for="column in columns"
            :key="rowKey(column.key, index)"
            class="px-4 py-2"
          >
            <slot :name="`row(${column.key})`" :data="row" :index="index">{{
              row[column.key]
            }}</slot>
          </td>
          <td v-if="this.$slots.actions">
            <slot name="actions" :data="row" :index="index"></slot>
          </td>
        </tr>
      </tbody>
    </table>
    <div class="inline-flex items-center justify-between px-4 py-2 w-full">
      <p class="text-sm flex-1">
        <span class="font-semibold">{{ data.from }}</span> -
        <span class="font-semibold">{{ data.to }}</span> dari
        <span class="font-semibold">{{ data.total }}</span>
      </p>
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
            preserve-state
            preserve-scroll
          >
            <span v-html="link.label"></span>
          </Link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {
  SearchIcon,
  SortAscendingIcon,
  SortDescendingIcon,
} from "@heroicons/vue/solid"
import { Inertia } from "@inertiajs/inertia"
import { Link } from "@inertiajs/inertia-vue3"
import { reactive } from "vue"
import { debounce, get } from "@/util"

export default {
  props: {
    columns: Array,
    data: Object,
  },
  components: {
    Link,
    SearchIcon,
    SortAscendingIcon,
    SortDescendingIcon,
  },
  setup(props) {
    const filter = reactive({
      query: "",
      orderBy: "",
      orderType: "",
      perPage: 10,
    })

    const rowKey = (col, index) => `${col}-${index}`

    const sortCol = (col, index) => {
      // if (!columns[index][col].sortable) return

      if (filter.orderBy != col) {
        filter.orderType = ""
        filter.orderBy = col
      }

      switch (filter.orderType) {
        case "":
          filter.orderType = "ASC"
          break
        case "ASC":
          filter.orderType = "DESC"
          break
        case "DESC":
          filter.orderBy = ""
          filter.orderType = ""
          break
        default:
          break
      }

      search()
    }

    const search = debounce(() => {
      const current = route().current()
      Inertia.get(route(current), filter, {
        preserveScroll: true,
        preserveState: true,
      })
    }, 250)

    return {
      filter,
      get,
      rowKey,
      search,
      sortCol,
    }
  },
}
</script>

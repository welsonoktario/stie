<template>
  <div class="inline-flex w-full items-center justify-between">
    <div class="inline-flex items-center text-sm">
      <label for="per_page">Data per halaman</label>
      <select
        v-model="filter.perPage"
        name="per_page"
        class="ml-2 rounded-md border-none bg-zinc-100 pl-2 pr-6 text-sm focus:ring-teal-500 dark:bg-zinc-700 dark:focus:ring-teal-600"
        @change="search"
      >
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
      </select>
    </div>

    <label
      class="relative rounded-md border-none bg-zinc-100 text-sm focus-within:ring-teal-500 focus:ring-2 dark:bg-zinc-700"
    >
      <SearchIcon
        class="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 transform text-zinc-500 focus-within:text-zinc-900"
      />
      <input
        v-model="filter.query"
        type="text"
        name="query"
        class="form-input mr-1 ml-5 border-none bg-zinc-100 text-sm placeholder:text-zinc-500 focus:ring-0 dark:bg-zinc-700"
        placeholder="Cari data"
        autocomplete="off"
        @input="search"
      />
    </label>
  </div>
  <div
    class="mt-2 w-full rounded-md shadow-md dark:bg-zinc-700 dark:text-zinc-100 overflow-auto"
  >
    <template v-if="data.data.length">
      <table class="w-full table-auto">
        <thead>
          <tr>
            <th
              v-for="(column, index) in columns"
              :key="column.key"
              class="py-2 px-4 text-left font-semibold"
            >
              <div
                class="inline-flex w-full items-center justify-between tracking-wider"
                :class="{ 'cursor-pointer': column.sortable }"
                @click="sortCol(column.key, index)"
              >
                <slot
                  :name="`col(${column.key})`"
                  :data="column"
                  :index="index"
                  >{{ column.label }}</slot
                >
                <template
                  v-if="column.sortable && filter.orderBy == column.key"
                >
                  <SortAscendingIcon
                    v-if="filter.orderType == 'ASC'"
                    class="ml-2 h-4 w-4"
                  />
                  <SortDescendingIcon
                    v-if="filter.orderType == 'DESC'"
                    class="ml-2 h-4 w-4"
                  />
                </template>
              </div>
            </th>
            <th
              v-if="$slots.actions"
              class="py-2 px-4 text-left font-semibold"
            />
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(row, index) in data.data"
            :key="index"
            class="border-y text-sm font-normal dark:border-zinc-600 dark:text-zinc-200"
          >
            <td
              v-for="column in columns"
              :key="rowKey(column.key, index)"
              class="px-4 py-2"
            >
              <slot :name="`row(${column.key})`" :data="row" :index="index">
                {{ row[column.key] }}
              </slot>
            </td>
            <td v-if="$slots.actions" class="px-4 py-2 text-center">
              <slot name="actions" :data="row" :index="index"></slot>
            </td>
          </tr>
        </tbody>
      </table>
      <div class="inline-flex w-full items-center justify-between px-4 py-2">
        <p class="flex-1 text-sm">
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
    </template>

    <div
      v-else
      class="my-4 flex h-32 w-full flex-col items-center justify-center rounded-lg bg-zinc-100 dark:bg-zinc-700"
    >
      <h1 class="text-lg">Belum ada data</h1>
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
  components: {
    Link,
    SearchIcon,
    SortAscendingIcon,
    SortDescendingIcon,
  },
  props: {
    columns: Array,
    data: Object,
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
      if (!props.columns[index].sortable) return

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
      const params = route().params
      const filterProps = Object.getOwnPropertyNames(filter)
      // foreach {
      //   alert(p)
      //   break
      // }

      filterProps.forEach((p) => {
        params[p] = filter[p]
      })

      const current = route().current()
      const newFilter = { ...filter, ...route().params }
      newFilter.query = filter.query
      newFilter.orderBy = filter.orderBy
      newFilter.orderType = filter.orderType
      newFilter.perPage = filter.perPage

      Inertia.get(route(current, params), newFilter, {
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

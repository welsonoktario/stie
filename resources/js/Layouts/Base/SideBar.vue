<template>
  <!-- sidebar -->
  <aside
    id="sideBar"
    class="z-30 h-full dark:text-zinc-100 md:top-0 md:z-30 md:flex md:flex-none"
    :class="{
      hidden: !isSidebarOpen,
      fixed: isSidebarOpen,
      'w-screen': isSidebarOpen,
    }"
  >
    <div class="flex h-full w-full flex-row">
      <!-- sidebar content -->
      <div
        class="flex w-72 flex-col divide-y border-r border-zinc-300 bg-white p-6 dark:divide-zinc-600 dark:border-zinc-700 dark:bg-zinc-800 md:shadow-xl"
      >
        <!-- menu master data -->
        <div v-for="(master, index) in masterMenu" :key="master.name">
          <p
            class="mb-4 text-sm font-bold uppercase tracking-wider text-zinc-600 dark:text-zinc-400"
            :class="{ 'pt-4': index != 0 }"
          >
            {{ master.label }}
          </p>

          <!-- link -->
          <div
            v-for="menu in master.menus"
            :key="menu.name"
            class="mb-4 flex flex-col"
          >
            <button
              v-if="menu.subMenus.length"
              class="inline-flex items-center px-1 pt-1 text-base font-medium leading-5 transition duration-150 ease-in-out focus:outline-none dark:text-zinc-100"
              :class="{
                'text-teal-600 dark:text-teal-500': activeMenu(menu.name),
              }"
              @click="toggleSubMenu(menu.name)"
            >
              <component :is="menu.icon" class="h-5 w-5" />
              <p class="ml-4 flex-1 text-left">{{ menu.label }}</p>
              <ChevronRightIcon
                v-if="!isSubMenuOpen(menu.name)"
                class="h-5 w-5"
              />
              <ChevronDownIcon v-else class="h-5 w-5" />
            </button>
            <NavLink
              v-else
              :active="activeMenu(menu.name)"
              :href="
                menu.route
                  ? menu.params
                    ? route(menu.route, menu.params)
                    : route(menu.route)
                  : '#'
              "
              class="text-base"
              as="button"
            >
              <component :is="menu.icon" class="h-5 w-5" />
              <p class="ml-4 flex-1 text-left">{{ menu.label }}</p>
            </NavLink>
            <div
              v-if="menu.subMenus.length"
              v-show="isSubMenuOpen(menu.name)"
              class="mt-2 flex flex-col rounded-lg bg-zinc-100 dark:bg-zinc-700"
            >
              <div
                v-for="subMenu in menu.subMenus"
                :key="subMenu.name"
                class="rounded-md px-3 py-1 hover:bg-teal-100 hover:bg-opacity-30 dark:hover:bg-opacity-10"
                :class="{
                  'bg-teal-100 bg-opacity-30 dark:bg-opacity-10':
                    route().current(subMenu.name),
                }"
              >
                <NavLink
                  as="button"
                  :href="
                    subMenu.route
                      ? subMenu.params
                        ? route(subMenu.route, subMenu.params)
                        : route(subMenu.route)
                      : '#'
                  "
                  :active="
                    subMenu.params
                      ? route().current(subMenu.route, subMenu.params)
                      : route().current(subMenu.route)
                  "
                  class="h-full w-full"
                  >{{ subMenu.label }}</NavLink
                >
              </div>
            </div>
          </div>
          <!-- end link -->
        </div>
        <!-- end menu master data -->
      </div>
      <!-- end sidebar content -->
      <div class="w-full flex-1" @click="isSidebarOpen = !isSidebarOpen"></div>
    </div>
  </aside>
  <!-- end sidebar -->
</template>

<script>
import eventBus from "@/eventBus"
import { onMounted, reactive, ref } from "vue"
import {
  AcademicCapIcon,
  BookOpenIcon,
  CalendarIcon,
  ChevronDownIcon,
  ChevronRightIcon,
  ClipboardListIcon,
  CollectionIcon,
  CreditCardIcon,
  UserGroupIcon,
  UsersIcon,
} from "@heroicons/vue/outline"
import NavLink from "@components/NavLink"

export default {
  components: {
    AcademicCapIcon,
    BookOpenIcon,
    CalendarIcon,
    ChevronDownIcon,
    ChevronRightIcon,
    ClipboardListIcon,
    CollectionIcon,
    CreditCardIcon,
    UserGroupIcon,
    UsersIcon,
    NavLink,
  },
  setup() {
    const isSidebarOpen = ref(false)
    const activeSubMenu = reactive({
      current: "",
      menus: [],
    })

    const masterMenu = [
      {
        label: "Master Data",
        name: "master",
        menus: [
          {
            icon: UserGroupIcon,
            label: "Karyawan",
            name: "master-karyawan",
            subMenus: [
              {
                name: "karyawan-semua",
                label: "Semua",
                route: "login",
              },
              {
                name: "karyawan-karyawan",
                label: "Karyawan",
                route: "master.karyawan.index",
              },
              {
                name: "karyawan-dosen",
                label: "Dosen",
                route: "master.dosen.index",
              },
            ],
          },
          {
            icon: AcademicCapIcon,
            label: "Akademik",
            name: "master-akademik",
            subMenus: [
              {
                name: "akademik-jurusan",
                label: "Program Studi/Departemen",
                route: "master.jurusan.index",
              },
              {
                name: "akademik-jabatan",
                label: "Jabatan Struktural",
                route: "master.jabatan-struktural.index",
              },
              {
                name: "akademik-tahun-ajaran",
                label: "Tahun Akademik",
                route: "master.tahun-ajaran.index",
              },
              {
                name: "akademik-ruangan",
                label: "Ruangan",
                route: "master.ruangan.index",
              },
              {
                name: "akademik-kurikulum",
                label: "Kurikulum",
                route: "master.kurikulum.index",
              },
              {
                name: "akademik-matakuliah",
                label: "Matakuliah",
                route: "master.matakuliah.index",
              },
            ],
          },
          {
            icon: UsersIcon,
            label: "Mahasiswa",
            name: "master-mahasiswa",
            subMenus: [
              {
                name: "mahasiswa-semua",
                label: "Semua",
                route: "login",
              },
              {
                name: "mahasiswa-reguler",
                label: "Reguler",
                route: "master.mahasiswa-reguler.index",
              },
              {
                name: "mahasiswa-konversi",
                label: "Konversi",
                route: "master.mahasiswa-konversi.index",
              },
            ],
          },
        ],
      },
      {
        label: "Akademik",
        name: "akademik",
        menus: [
          {
            icon: CalendarIcon,
            label: "Jadwal",
            name: "akademik-jadwal",
            route: "transaksi.jadwal.index",
            subMenus: [],
          },
          {
            icon: CreditCardIcon,
            label: "Keuangan",
            name: "akademik-keuangan",
            route: "transaksi.keuangan.index",
            subMenus: [],
          },
          {
            icon: CollectionIcon,
            label: "KRS",
            name: "akademik-krs",
            route: "transaksi.krs.index",
            subMenus: [],
          },
          {
            icon: ClipboardListIcon,
            label: "Kartu Ujian",
            name: "akademik-ujian",
            subMenus: [
              {
                name: "ujian-uts",
                label: "UTS",
                route: "transaksi.ujian.index",
                params: { tipe: "UTS" },
              },
              {
                name: "ujian-uas",
                label: "UAS",
                route: "transaksi.ujian.index",
                params: { tipe: "UAS" },
              },
            ],
          },
          {
            icon: BookOpenIcon,
            label: "Nilai / Transkrip",
            name: "akademik-nilai",
            route: "transaksi.nilai.index",
            subMenus: [],
          },
        ],
      },
    ]

    onMounted(() =>
      eventBus.$on(
        "sidebar-toggle",
        () => (isSidebarOpen.value = !isSidebarOpen.value)
      )
    )

    const activeMenu = (menu) => activeSubMenu.current == menu

    const isSubMenuOpen = (menu) =>
      activeSubMenu.menus.some(
        (subMenu) => subMenu.menu == menu && subMenu.isOpen
      )

    const toggleSubMenu = (menu) => {
      activeSubMenu.current = menu
      const index = activeSubMenu.menus.findIndex(
        (subMenu) => subMenu.menu == activeSubMenu.current
      )

      if (index > -1) {
        activeSubMenu.menus[index].isOpen = !activeSubMenu.menus[index].isOpen
      } else {
        activeSubMenu.menus.push({
          menu,
          isOpen: true,
        })
      }
    }

    return {
      isSidebarOpen,
      activeSubMenu,
      masterMenu,
      activeMenu,
      isSubMenuOpen,
      toggleSubMenu,
    }
  },
}
</script>

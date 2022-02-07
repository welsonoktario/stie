<template>
  <!-- sidebar -->
  <aside
    id="sideBar"
    class="md:flex md:flex-none h-full md:top-0 md:z-30 z-11 dark:text-zinc-100"
    :class="{
      hidden: !isSidebarOpen,
      fixed: isSidebarOpen,
      'w-screen': isSidebarOpen,
    }"
  >
    <div class="flex flex-row h-full w-full">
      <!-- sidebar content -->
      <div
        class="flex flex-col divide-y dark:divide-zinc-600 bg-white dark:bg-zinc-800 border-r border-zinc-300 dark:border-zinc-700 p-6 w-72 md:shadow-xl"
      >
        <!-- menu master data -->
        <div v-for="(master, index) in masterMenu" :key="master.name">
          <p
            class="text-sm uppercase font-bold text-zinc-600 dark:text-zinc-400 mb-4 tracking-wider"
            :class="{ 'pt-4': index != 0 }"
          >
            {{ master.label }}
          </p>

          <!-- link -->
          <div
            v-for="menu in master.menus"
            :key="menu.name"
            class="flex flex-col mb-4"
          >
            <button
              v-if="menu.subMenus.length"
              class="font-medium text-sm hover:text-teal-400 hover:dark:text-teal-400 transition ease-in-out duration-250 inline-flex items-center mb-2"
              :class="{
                'text-teal-500 dark:text-teal-400': activeMenu(menu.name),
              }"
              @click="toggleSubMenu(menu.name)"
            >
              <component :is="menu.icon" class="w-5 h-5" />
              <p class="ml-4 flex-1 text-base text-left">{{ menu.label }}</p>
              <ChevronRightIcon
                v-if="!isSubMenuOpen(menu.name)"
                class="w-5 h-5"
              />
              <ChevronDownIcon v-else class="w-5 h-5" />
            </button>
            <Link
              v-else
              href="#"
              as="button"
              class="font-medium text-sm hover:text-teal-400 hover:dark:text-teal-400 transition ease-in-out duration-250 inline-flex items-center mb-2"
              :class="{
                'text-teal-500 dark:text-teal-400': activeMenu(menu.name),
              }"
            >
              <component :is="menu.icon" class="w-5 h-5" />
              <p class="ml-4 flex-1 text-base text-left">{{ menu.label }}</p>
            </Link>
            <div
              v-if="menu.subMenus.length"
              v-show="isSubMenuOpen(menu.name)"
              class="flex flex-col rounded-lg bg-zinc-100 dark:bg-zinc-700"
            >
              <Link
                v-for="subMenu in menu.subMenus"
                :key="subMenu.name"
                :href="route(subMenu.route)"
                class="py-2 px-4 text-sm rounded-lg hover:text-teal-400 hover:bg-teal-200/25 transition ease-in-out duration-250"
                >{{ subMenu.label }}</Link
              >
            </div>
          </div>
          <!-- end link -->
        </div>
        <!-- end menu master data -->
      </div>
      <!-- end sidebar content -->
      <div class="flex-1 w-full" @click="isSidebarOpen = !isSidebarOpen"></div>
    </div>
  </aside>
  <!-- end sidebar -->
</template>

<script>
import eventBus from "@/eventBus"
import { onMounted, reactive, ref } from "vue"
import { Link } from "@inertiajs/inertia-vue3"
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
    Link,
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
                route: "login"
              },
              {
                name: "karyawan-karyawan",
                label: "Karyawan",
                route: "master.karyawan.index"
              },
              {
                name: "karyawan-dosen",
                label: "Dosen",
                route: "master.dosen.index"
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
                label: "Jurusan / Program Studi",
                route: "master.jurusan.index"
              },
              {
                name: "akademik-tahun-ajaran",
                label: "Tahun Ajaran",
                route: "master.tahun_ajaran.index"
              },
              {
                name: "akademik-ruangan",
                label: "Ruangan",
                route: "master.ruangan.index"
              },
              {
                name: "akademik-kurikulum",
                label: "Kurikulum",
                route: "master.kurikulum.index"
              },
              {
                name: "akademik-matakuliah",
                label: "Matakuliah",
                route: "master.matakuliah.index"
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
                route: "login"
              },
              {
                name: "mahasiswa-reguler",
                label: "Reguler",
                route: "login"
              },
              {
                name: "mahasiswa-konversi",
                label: "Konversi",
                route: "login"
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
            subMenus: [],
          },
          {
            icon: CreditCardIcon,
            label: "Keuangan",
            name: "akademik-keuangan",
            subMenus: [],
          },
          {
            icon: CollectionIcon,
            label: "KRS",
            name: "akademik-krs",
            subMenus: [],
          },
          {
            icon: ClipboardListIcon,
            label: "Ujian",
            name: "akademik-ujian",
            subMenus: [
              {
                name: "ujian-uts",
                label: "UTS",
                route: "login"
              },
              {
                name: "ujian-uas",
                label: "UAS",
                route: "login"
              },
            ],
          },
          {
            icon: BookOpenIcon,
            label: "Nilai",
            name: "akademik-nilai",
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

<template>
  <aside
    :class="[
      'fixed top-0 left-0 h-full bg-white dark:bg-gray-900 border-r border-gray-200 transition-all duration-300 z-50 flex flex-col',
      {
        'w-[280px]': isExpanded || isMobileOpen || isHovered,
        'w-[80px]': !isExpanded && !isHovered,
        'translate-x-0': isMobileOpen,
        '-translate-x-full lg:translate-x-0': !isMobileOpen,
      },
    ]"
    @mouseenter="!isExpanded && (isHovered = true)"
    @mouseleave="isHovered = false"
  >
    <!-- HEADER / LOGO -->
    <div
      class="h-16 flex items-center px-4 border-b border-gray-200"
      :class="!isExpanded && !isHovered ? 'justify-center' : 'justify-start'"
    >
      <router-link to="/">
        <img
          v-if="isExpanded || isHovered || isMobileOpen"
          src="/images/logo/logo.svg"
          class="h-8"
        />
        <img
          v-else
          src="/images/logo/logo-icon.svg"
          class="h-8"
        />
      </router-link>
    </div>

    <!-- MENU -->
    <div class="flex-1 overflow-y-auto p-4 space-y-6">

      <div v-for="(menuGroup, groupIndex) in menuGroups" :key="groupIndex">

        <!-- TITLE -->
        <h2
          class="text-xs uppercase text-gray-400 mb-2"
          :class="!isExpanded && !isHovered ? 'text-center' : ''"
        >
          <span v-if="isExpanded || isHovered || isMobileOpen">
            {{ menuGroup.title }}
          </span>
          <HorizontalDots v-else />
        </h2>

        <!-- ITEMS -->
        <ul class="space-y-2">
          <li v-for="(item, index) in menuGroup.items" :key="item.name">

            <!-- SUBMENU BUTTON -->
            <button
              v-if="item.subItems"
              @click="toggleSubmenu(groupIndex, index)"
              class="flex items-center w-full px-3 py-2 rounded-lg hover:bg-gray-100"
            >
              <component :is="item.icon" class="w-5 h-5" />

              <span
                v-if="isExpanded || isHovered || isMobileOpen"
                class="ml-3"
              >
                {{ item.name }}
              </span>
            </button>

            <!-- LINK -->
            <router-link
              v-else
              :to="item.path"
              class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100"
              :class="isActive(item.path) ? 'bg-gray-200 font-semibold' : ''"
            >
              <component :is="item.icon" class="w-5 h-5" />

              <span
                v-if="isExpanded || isHovered || isMobileOpen"
                class="ml-3"
              >
                {{ item.name }}
              </span>
            </router-link>

            <!-- SUBMENU -->
            <div
              v-show="isSubmenuOpen(groupIndex, index)"
              class="ml-6 mt-1 space-y-1"
            >
              <router-link
                v-for="sub in item.subItems"
                :key="sub.name"
                :to="sub.path"
                class="block px-2 py-1 text-sm rounded hover:bg-gray-100"
              >
                {{ sub.name }}
              </router-link>
            </div>

          </li>
        </ul>

      </div>

    </div>

  </aside>
</template>

<script setup>
import { ref, computed } from "vue";
import { useRoute } from "vue-router";

import {
  GridIcon,
  CalenderIcon,
  UserCircleIcon,
  ChatIcon,
  MailIcon,
  DocsIcon,
  PieChartIcon,
  ChevronDownIcon,
  HorizontalDots,
  PageIcon,
  TableIcon,
  ListIcon,
  PlugInIcon,
} from "../../icons";
import SidebarWidget from "./SidebarWidget.vue";
import BoxCubeIcon from "../../icons/BoxCubeIcon.vue";
import { useSidebar } from "../../composables/useSidebar";

const route = useRoute();

const { isExpanded, isMobileOpen, isHovered, openSubmenu } = useSidebar();

const menuGroups = [
  {
    title: "Menu",
    items: [
      {
        icon: GridIcon,
        name: "Dashboard",
        path:"/admin/dashboard",
      },
      {
        icon: CalenderIcon,
        name: "Doctor",
        path: "/admin/doctors",
      },
      {
        icon: UserCircleIcon,
        name: "User Profile",
        path: "/profile",
      },

      {
        name: "Forms",
        icon: ListIcon,
        subItems: [
          { name: "Form Elements", path: "/form-elements", pro: false },
        ],
      },
      {
        name: "Tables",
        icon: TableIcon,
        subItems: [{ name: "Basic Tables", path: "/basic-tables", pro: false }],
      },
      {
        name: "Pages",
        icon: PageIcon,
        subItems: [
          { name: "Black Page", path: "/blank", pro: false },
          { name: "404 Page", path: "/error-404", pro: false },
        ],
      },
    ],
  },
  {
    title: "Others",
    items: [
      {
        icon: PieChartIcon,
        name: "Charts",
        subItems: [
          { name: "Line Chart", path: "/line-chart", pro: false },
          { name: "Bar Chart", path: "/bar-chart", pro: false },
        ],
      },
      {
        icon: BoxCubeIcon,
        name: "Ui Elements",
        subItems: [
          { name: "Alerts", path: "/alerts", pro: false },
          { name: "Avatars", path: "/avatars", pro: false },
          { name: "Badge", path: "/badge", pro: false },
          { name: "Buttons", path: "/buttons", pro: false },
          { name: "Images", path: "/images", pro: false },
          { name: "Videos", path: "/videos", pro: false },
        ],
      },
      {
        icon: PlugInIcon,
        name: "Authentication",
        subItems: [
          { name: "Signin", path: "/signin", pro: false },
          { name: "Signup", path: "/signup", pro: false },
        ],
      },
      // ... Add other menu items here
    ],
  },
];

const isActive = (path) => route.path === path;

const toggleSubmenu = (groupIndex, itemIndex) => {
  const key = `${groupIndex}-${itemIndex}`;
  openSubmenu.value = openSubmenu.value === key ? null : key;
};

const isAnySubmenuRouteActive = computed(() => {
  return menuGroups.some((group) =>
    group.items.some(
      (item) =>
        item.subItems && item.subItems.some((subItem) => isActive(subItem.path))
    )
  );
});

const isSubmenuOpen = (groupIndex, itemIndex) => {
  const key = `${groupIndex}-${itemIndex}`;
  return (
    openSubmenu.value === key ||
    (isAnySubmenuRouteActive.value &&
      menuGroups[groupIndex].items[itemIndex].subItems?.some((subItem) =>
        isActive(subItem.path)
      ))
  );
};

const startTransition = (el) => {
  el.style.height = "auto";
  const height = el.scrollHeight;
  el.style.height = "0px";
  el.offsetHeight; // force reflow
  el.style.height = height + "px";
};

const endTransition = (el) => {
  el.style.height = "";
};
</script>

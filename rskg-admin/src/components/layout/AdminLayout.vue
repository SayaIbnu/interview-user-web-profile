<template>
  <div class="min-h-screen flex bg-gray-100">

    <!-- SIDEBAR -->
    <AppSidebar />

    <!-- BACKDROP (mobile only) -->
    <Backdrop />

    <!-- MAIN CONTENT -->
    <div
      class="flex flex-col flex-1 transition-all duration-300"
      :class="[
        isExpanded || isHovered
          ? 'lg:ml-[280px]'
          : 'lg:ml-[80px]'
      ]"
    >
      <!-- HEADER -->
      <AppHeader />

      <!-- CONTENT -->
      <main class="flex-1 p-4 md:p-6">
        <div class="mx-auto max-w-7xl">
          <router-view />
        </div>
      </main>
    </div>

  </div>
</template>
<script setup>
import AppSidebar from './AppSidebar.vue'
import AppHeader from './AppHeader.vue'
import Backdrop from './Backdrop.vue'
import { useSidebar, useSidebarProvider } from '../../composables/useSidebar'

useSidebarProvider()
const { isExpanded, isHovered } = useSidebar()
</script>
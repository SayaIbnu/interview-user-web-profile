<script setup>
import { ref } from 'vue'
import { useSidebar } from '../../composables/useSidebar'
import { useAuthStore } from '../../store/auth'

const { toggleSidebar, toggleMobileSidebar } = useSidebar()
const auth = useAuthStore()

const handleToggle = () => {
  if (window.innerWidth >= 1024) {
    toggleSidebar()
  } else {
    toggleMobileSidebar()
  }
}

const dropdownOpen = ref(false)

const toggleDropdown = () => {
  dropdownOpen.value = !dropdownOpen.value
}
</script>

<template>
  <header
    class="sticky top-0 z-30 flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200 shadow-sm"
  >
    <!-- LEFT -->
    <div class="flex items-center gap-3">

      <!-- TOGGLE BUTTON -->
      <button
        @click="handleToggle"
        class="p-2 rounded-lg hover:bg-gray-100"
      >
        ☰
      </button>

      <!-- TITLE -->
      <h1 class="text-lg font-semibold hidden sm:block">
        Admin Dashboard
      </h1>

    </div>

    <!-- RIGHT -->
    <div class="flex items-center gap-4">

      <!-- THEME -->
      <ThemeToggler />

      <!-- USER -->
      <div class="relative">

        <button
          @click="toggleDropdown"
          class="flex items-center gap-2"
        >
          <span class="text-sm">{{ auth.user?.name }}</span>
          <img
            src="https://i.pravatar.cc/30"
            class="w-8 h-8 rounded-full"
          />
        </button>

        <!-- DROPDOWN -->
        <div
          v-if="dropdownOpen"
          class="absolute right-0 mt-2 w-40 bg-white border rounded-lg shadow-md z-50"
        >
          <button
            class="w-full text-left px-4 py-2 hover:bg-gray-100"
          >
            Profile
          </button>

          <button
            @click="auth.logout"
            class="w-full text-left px-4 py-2 text-red-500 hover:bg-gray-100"
          >
            Logout
          </button>
        </div>

      </div>

    </div>
  </header>
</template>
<template>
  <router-view />
</template>

<script setup>
import { useSidebarProvider } from '../src/composables/useSidebar'

useSidebarProvider()
</script>

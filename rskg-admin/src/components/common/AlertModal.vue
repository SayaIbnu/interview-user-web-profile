<script setup>
defineProps({
  message: String
})

const emit = defineEmits(['close'])
</script>

<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded w-full max-w-sm text-center">
      <h3 class="text-lg font-semibold mb-3">Peringatan</h3>

      <p class="text-gray-600 mb-4">
        {{ message }}
      </p>

      <button
        @click="$emit('close')"
        class="px-4 py-2 bg-blue-600 text-white rounded"
      >
        OK
      </button>
    </div>

  </div>
</template>
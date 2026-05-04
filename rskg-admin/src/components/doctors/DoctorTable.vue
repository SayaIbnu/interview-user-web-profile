
<script setup>
defineProps(['data', 'loading'])
defineEmits(['edit', 'delete'])
</script>

<template>
  <div class="bg-white rounded shadow p-4">
    <table class="w-full text-left">
      <thead>
        <tr class="border-b">
          <th>Nama</th>
          <th>Spesialis</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
        <tr v-if="loading">
          <td colspan="3">Loading...</td>
        </tr>

        <tr v-for="doc in data" :key="doc.id" class="border-b">
          <td>{{ doc.name }}</td>
          <td>{{ doc.specialist }}</td>

          <td class="space-x-2">
            <button
              @click="$emit('edit', doc)"
              class="text-blue-500"
            >
              Edit
            </button>

            <button
              @click="$emit('delete', doc)"
              class="text-red-500"
            >
              Hapus
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
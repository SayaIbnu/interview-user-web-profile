<script setup>
  import { ref, onMounted } from 'vue'
  import api from '../../services/api'

  const loading = ref(false)
  const error = ref('')
  const dashboard = ref({
    total_users: 0,
    total_doctors: 0,
    total_news: 0,
    total_videos: 0,
    total_promotions: 0
  })

  const fetchDashboard = async () => {
    loading.value = true
    error.value = ''

    try {
      const res = await api.get('/admin/dashboard')
      dashboard.value = res.data.data
    } catch (err) {
      error.value = err.response?.data?.message || 'Gagal ambil data'
    } finally {
      loading.value = false
    }
  }

  onMounted(() => {
    fetchDashboard()
  })
</script>

<template>
  <div>
    <h2 class="text-xl font-bold mb-4">Dashboard</h2>

    <!-- LOADING -->
    <div v-if="loading">Loading...</div>

    <!-- ERROR -->
    <div v-if="error" class="text-red-500">{{ error }}</div>

    <!-- DATA -->
    <div v-if="!loading" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">

      <div class="p-4 bg-white rounded shadow">
        <p class="text-sm text-gray-500">Users</p>
        <p class="text-2xl font-bold">{{ dashboard.total_users }}</p>
      </div>

      <div class="p-4 bg-white rounded shadow">
        <p class="text-sm text-gray-500">Doctors</p>
        <p class="text-2xl font-bold">{{ dashboard.total_doctors }}</p>
      </div>

      <div class="p-4 bg-white rounded shadow">
        <p class="text-sm text-gray-500">News</p>
        <p class="text-2xl font-bold">{{ dashboard.total_news }}</p>
      </div>

      <div class="p-4 bg-white rounded shadow">
        <p class="text-sm text-gray-500">Videos</p>
        <p class="text-2xl font-bold">{{ dashboard.total_videos }}</p>
      </div>

      <div class="p-4 bg-white rounded shadow">
        <p class="text-sm text-gray-500">Promotions</p>
        <p class="text-2xl font-bold">{{ dashboard.total_promotions }}</p>
      </div>

    </div>
  </div>
</template>
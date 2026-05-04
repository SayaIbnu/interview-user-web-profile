<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'

import api from '../../../services/api'

import DoctorTable from '../../../components/doctors/DoctorTable.vue'


const doctors = ref([])
const loading = ref(false)


const router = useRouter()

const fetchDoctors = async () => {
  loading.value = true
  const res = await api.get('/admin/doctors')
  doctors.value = res.data.data
  loading.value = false
}

const handleAdd = () => {
  router.push('/admin/doctors/create')
}

const handleEdit = (doctor) => {
  router.push(`/admin/doctors/${doctor.id}/edit`)
}

const handleDetail = (doctor)=> {
  router.push(`/admin/doctors/${doctor.id}/edit`)
}

const handleDelete = async (doctor) => {
  if (!confirm('Yakin hapus data?')) return

  await api.delete(`/admin/doctors/${doctor.id}`)
  fetchDoctors()
}

onMounted(fetchDoctors)
</script>

<template>
  <div>
    <div class="flex justify-between mb-4">
      <h2 class="text-xl font-bold">Data Dokter</h2>

      <button
        @click="handleAdd"
        class="bg-blue-600 text-white px-4 py-2 rounded"
      >
        + Tambah Dokter
      </button>
    </div>

    <DoctorTable
      :data="doctors"
      :loading="loading"
      @edit="handleEdit"
      @detail="handleDetail"
      @delete="handleDelete"
    />

    <DoctorModal
      v-if="showModal"
      :doctor="selectedDoctor"
      @close="showModal = false"
      @success="fetchDoctors"
    />
  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '../../../services/api'

// import ScheduleModal from '../../../components/doctors/ScheduleModal.vue'

const route = useRoute()

const doctor = ref(null)
const schedules = ref([])

const showScheduleModal = ref(false)

const fetchDoctor = async () => {
  const res = await api.get(`/admin/doctors/${route.params.id}`)
  doctor.value = res.data.data
}

// const fetchSchedules = async () => {
//   const res = await api.get(`/admin/doctors/${route.params.id}/schedules`)
//   schedules.value = res.data.data
// }

// const handleSuccess = () => {
//   showScheduleModal.value = false
//   fetchSchedules()
// }

onMounted(() => {
  fetchDoctor()
//   fetchSchedules()
})
</script>

<template>
  <div v-if="doctor">

    <!-- HEADER -->
    <div class="flex items-center gap-4 mb-6">
      <img
        :src="doctor.photo_url"
        class="w-24 h-24 object-cover rounded"
      />

      <div>
        <h2 class="text-2xl font-bold">{{ doctor.name }}</h2>
        <p class="text-gray-500">{{ doctor.specialist }}</p>
      </div>
    </div>

    <!-- DESCRIPTION -->
    <div class="mb-6">
      <h3 class="font-semibold mb-2">Deskripsi</h3>
      <p class="text-gray-600">{{ doctor.description }}</p>
    </div>

    <!-- SCHEDULE -->
    <!-- <div class="bg-white p-4 rounded shadow">

      <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold">Jadwal Praktek</h3>

        <button
          @click="showScheduleModal = true"
          class="px-3 py-2 bg-blue-600 text-white rounded"
        >
          + Tambah Jadwal
        </button>
      </div>

      <table class="w-full border">
        <thead>
          <tr class="bg-gray-100">
            <th class="p-2">Hari</th>
            <th class="p-2">Jam Mulai</th>
            <th class="p-2">Jam Selesai</th>
          </tr>
        </thead>

        <tbody>
          <tr v-for="sch in schedules" :key="sch.id">
            <td class="p-2">{{ sch.day }}</td>
            <td class="p-2">{{ sch.start_time }}</td>
            <td class="p-2">{{ sch.end_time }}</td>
          </tr>
        </tbody>
      </table>

    </div> -->

    <!-- MODAL -->
    <!-- <ScheduleModal
      v-if="showScheduleModal"
      :doctorId="route.params.id"
      @close="showScheduleModal = false"
      @success="handleSuccess"
    /> -->

  </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import api from '../../../services/api'
import AlertModal from '../../../components/common/AlertModal.vue'

const route = useRoute()
const router = useRouter()

const isEdit = ref(false)
const loading = ref(false)

const form = ref({
  name: '',
  specialist: '',
  description: '',
  photo: null
})

const preview = ref(null)

const showAlert = ref(false)
const alertMessage = ref('')

// 🔥 cek mode edit
onMounted(async () => {
  if (route.params.id) {
    isEdit.value = true
    await fetchDoctor()
  }
})

// 🔥 ambil data dokter (edit)
const fetchDoctor = async () => {
  loading.value = true

  try {
    const res = await api.get(`/admin/doctors/${route.params.id}`)
    const data = res.data.data

    form.value.name = data.name
    form.value.specialist = data.specialist
    form.value.description = data.description
    preview.value = data.photo_url
  } catch (err) {
    alertMessage.value = 'Gagal ambil data dokter'
    showAlert.value = true
  } finally {
    loading.value = false
  }
}

// 🔥 handle file
const handleFile = (e) => { 
  const file = e.target.files[0]
  if (!file) return

  if (!file.type.startsWith('image/')) {
    alertMessage.value = 'File harus gambar'
    showAlert.value = true
    return
  }

  if (file.size > 2 * 1024 * 1024) {
    alertMessage.value = 'Max ukuran 2MB'
    showAlert.value = true
    return
  }

  form.value.photo = file
  preview.value = URL.createObjectURL(file)
}

// 🔥 validasi
const validate = () => {
  if (!form.value.name) {
    alertMessage.value = 'Nama wajib diisi'
    showAlert.value = true
    return false
  }

  if (!form.value.specialist) {
    alertMessage.value = 'Spesialis wajib diisi'
    showAlert.value = true
    return false
  }

  if (!form.value.description) {
    alertMessage.value = 'deskripsi wajib diisi'
    showAlert.value = true
    return false
  }

  return true
}

// 🔥 submit
const submit = async () => {
  if (!validate()) return

  loading.value = true

  try {
    const formData = new FormData()
    formData.append('name', form.value.name)
    formData.append('specialist', form.value.specialist)
    formData.append('description', form.value.description)

    if (form.value.photo) {
      formData.append('photo', form.value.photo)
    }

    if (isEdit.value) {
      await api.post(`/admin/doctors/${route.params.id}?_method=PUT`, formData)
    } else {
      await api.post('/admin/doctors', formData)
    }

    router.push('/admin/doctors')

  } catch (err) {
    alertMessage.value = err.response?.data?.message || 'Gagal simpan data'
    showAlert.value = true
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div>
    <h2 class="text-xl font-bold mb-4">
      {{ isEdit ? 'Edit Dokter' : 'Tambah Dokter' }}
    </h2>

    <div class="bg-white p-6 rounded shadow max-w-lg">

      <!-- NAME -->
      <input
        v-model="form.name"
        placeholder="Nama Dokter"
        class="w-full border p-2 mb-3"
      />

      <!-- SPECIALIST -->
      <input
        v-model="form.specialist"
        placeholder="Spesialis"
        class="w-full border p-2 mb-3"
      />

      <!-- deskripsi -->
      <input
        v-model="form.description"
        placeholder="deskripsi"
        class="w-full border p-2 mb-3"
      />

      <!-- FOTO -->
      <input type="file" @change="handleFile" class="mb-3" />

      <!-- PREVIEW -->
      <div v-if="preview" class="mb-3">
        <img
          :src="preview"
          class="w-32 h-32 object-cover rounded border"
        />
      </div>

      <!-- ACTION -->
      <div class="flex gap-2">
        <button
          @click="router.push('/admin/doctors')"
          class="px-4 py-2 border"
        >
          Batal
        </button>

        <button
          @click="submit"
          :disabled="loading"
          class="px-4 py-2 bg-blue-600 text-white"
        >
          {{ loading ? 'Saving...' : 'Simpan' }}
        </button>
      </div>

    </div>

    <!-- ALERT -->
    <AlertModal
      v-if="showAlert"
      :message="alertMessage"
      @close="showAlert = false"
    />
  </div>
</template>
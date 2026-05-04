<script setup>
import { ref, watch } from 'vue'
import api from '../../services/api'
import AlertModal from '../common/AlertModal.vue'

const props = defineProps(['doctor'])
const emit = defineEmits(['close', 'success'])

const form = ref({
  name: '',
  specialist: ''
})

const showAlert = ref(false)
const alertMessage = ref('')

watch(() => props.doctor, (val) => {
  if (val) {
    form.value = { ...val }
  } else {
    form.value = {
      name: '',
      specialist: ''
    }
  }
}, { immediate: true })

const validate = () => {
  if (!form.value.name) {
    alertMessage.value = 'Nama dokter wajib diisi'
    showAlert.value = true
    return false
  }

  if (!form.value.specialist) {
    alertMessage.value = 'Spesialis wajib diisi'
    showAlert.value = true
    return false
  }

  return true
}

const save = async () => {
  if (!validate()) return

  if (props.doctor) {
    await api.put(`/admin/doctors/${props.doctor.id}`, form.value)
  } else {
    await api.post('/admin/doctors', form.value)
  }

  emit('success')
  emit('close')
}
</script>

<template>
  <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">

    <div class="bg-white p-6 rounded w-full max-w-md">

      <h3 class="text-lg font-bold mb-4">
        {{ doctor ? 'Edit Dokter' : 'Tambah Dokter' }}
      </h3>

      <input
        v-model="form.name"
        placeholder="Nama Dokter"
        class="w-full border p-2 mb-3"
      />

      <input
        v-model="form.specialist"
        placeholder="Spesialis"
        class="w-full border p-2 mb-3"
      />

      <div class="flex justify-end gap-2">
        <button @click="$emit('close')" class="px-3 py-2 border">
          Batal
        </button>

        <button
          @click="save"
          class="px-3 py-2 bg-blue-600 text-white"
        >
          Simpan
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
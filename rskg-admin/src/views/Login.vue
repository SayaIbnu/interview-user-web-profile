<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '../store/auth'

const auth = useAuthStore()
// layout & component
import CommonGridShape from '../../src/components/common/CommonGridShape.vue'
import FullScreenLayout from '../../src/components/layout/Fullscreenlayout.vue'

const router = useRouter()

const email = ref('')
const password = ref('')
const showPassword = ref(false)
const keepLoggedIn = ref(false)

const loading = ref(false)
const error = ref('')

const togglePasswordVisibility = () => {
  showPassword.value = !showPassword.value
}

const handleSubmit = async () => {
  loading.value = true
  error.value = ''

  try {
    await auth.login({
      email: email.value,
      password: password.value
    })

    router.push('/admin/dashboard')

  } catch (err) {
    error.value = err || 'Login gagal'
  } finally {
    loading.value = false
  }
}

</script>

<template>
  <FullScreenLayout>
    <div class="relative p-6 bg-white dark:bg-gray-900 sm:p-0">
      <div class="flex flex-col lg:flex-row h-screen">

        <!-- LEFT -->
        <div class="flex flex-col flex-1 justify-center w-full lg:w-1/2">
          <div class="w-full max-w-md mx-auto">

            <h1 class="mb-2 text-xl font-semibold">Sign In</h1>
            <p class="mb-6 text-sm text-gray-500">
              Masuk ke dashboard admin
            </p>

            <form @submit.prevent="handleSubmit" class="space-y-4">

              <!-- EMAIL -->
              <input
                v-model="email"
                type="email"
                placeholder="Email"
                class="w-full border p-3 rounded-lg"
                required
              />

              <!-- PASSWORD -->
              <div class="relative">
                <input
                  v-model="password"
                  :type="showPassword ? 'text' : 'password'"
                  placeholder="Password"
                  class="w-full border p-3 rounded-lg"
                  required
                />
                <span
                  @click="togglePasswordVisibility"
                  class="absolute right-3 top-3 cursor-pointer text-sm"
                >
                  {{ showPassword ? 'Hide' : 'Show' }}
                </span>
              </div>

              <!-- ERROR -->
              <p v-if="error" class="text-red-500 text-sm">
                {{ error }}
              </p>

              <!-- BUTTON -->
              <button
                type="submit"
                :disabled="loading"
                class="w-full bg-blue-600 text-white p-3 rounded-lg disabled:opacity-50"
              >
                {{ loading ? 'Loading...' : 'Sign In' }}
              </button>

            </form>
          </div>
        </div>

        <!-- RIGHT -->
        <div class="hidden lg:flex w-1/2 items-center justify-center bg-gray-900">
          <div class="text-center text-white">
            <CommonGridShape />
            <h2 class="text-xl mt-4">Admin Panel RSKG</h2>
          </div>
        </div>

      </div>
    </div>
  </FullScreenLayout>
</template>
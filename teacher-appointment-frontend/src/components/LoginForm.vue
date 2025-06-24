<script setup>
import { reactive } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'

// Emit event to parent after successful login
const emit = defineEmits(['login-success'])
const toast = useToast();

const formData = reactive({
  email: '',
  password: '',
})

const login = async () => {
  try {
    const response = await axios.post('http://localhost:8000/api/login', {
      email: formData.email,
      password: formData.password,
    },{ withCredentials: false })

    localStorage.setItem('token', response.data.access_token)
    localStorage.setItem('user', JSON.stringify(response.data.user))

  toast.success('Login successful!');

    emit('login-success', response.data)
  } catch (error) {
    console.error(error)
    toast.error('Login failed. Please check your credentials.')
  }
}
</script>


<template>
  <div class="min-h-screen flex items-center justify-center bg-gray-50">
    <div class="w-full max-w-md p-6 bg-bg-light rounded shadow-md border border-gray-200">
      <h2 class="text-2xl font-bold text-primary mb-6">Login</h2>

      <!-- Email -->
      <label class="block mb-2 text-secondary font-semibold" for="email">Email</label>
      <input
        id="email"
        type="email"
        placeholder="example@mail.com"
        v-model="formData.email"
        class="w-full mb-4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
      />

      <!-- Password -->
      <label class="block mb-2 text-secondary font-semibold" for="password">Password</label>
      <input
        id="password"
        type="password"
        placeholder="********"
        v-model="formData.password"
        class="w-full mb-6 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
      />

      <!-- Login Button -->
      <button
        @click.prevent="login"
        class="w-full bg-primary text-white py-3 rounded font-semibold hover:bg-blue-700 transition"
      >
        Login
      </button>

      <div class="text-right mt-4">
  <router-link
    to="/signup"
    class="text-sm text-blue-600 hover:underline"
  >
    Don't have an account? Sign Up
  </router-link>
</div>
    </div>
  </div>
</template>

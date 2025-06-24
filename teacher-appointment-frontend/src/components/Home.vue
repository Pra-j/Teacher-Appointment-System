<template>
  <div>
    <!-- Header -->
    <div
      v-if="isLoggedIn"
      class="w-full flex justify-between items-center px-6 py-4 bg-primary text-white shadow"
    >
    <div>Welcome, {{ user?.name }}</div>
      <button @click="logout" class="font-semibold hover:underline">Logout</button>
    </div>

    <!-- Views -->
    <LoginForm v-if="!isLoggedIn" @login-success="handleLoginSuccess" />
    <StudentView v-else-if="user?.role === 'student'" />
    <TeacherView v-else-if="user?.role === 'teacher'" />
    <AdminView v-else-if="user?.role === 'admin'" />
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import LoginForm from './LoginForm.vue'
import StudentView from './StudentView.vue'
import TeacherView from './TeacherView.vue'
import AdminView from './AdminView.vue'

const isLoggedIn = ref(false)
const user = ref(null)

onMounted(() => {
  const token = localStorage.getItem('token')
  const userData = localStorage.getItem('user')
  if (token && userData) {
    isLoggedIn.value = true
    user.value = JSON.parse(userData)
  }
})

function handleLoginSuccess(data) {
  isLoggedIn.value = true
  user.value = data.user
}

function logout() {
  localStorage.removeItem('token')
  localStorage.removeItem('user')
  isLoggedIn.value = false
  user.value = null
}
</script>

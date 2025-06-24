<script setup>
import { ref, reactive, watch } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import { useRouter } from 'vue-router'

const router = useRouter()
const toast = useToast()

const roles = ['student', 'teacher']
const departments = ['Computer Science', 'Mathematics', 'Physics', 'Chemistry', 'Biology', 'English']

const role = ref('')
const imageFile = ref(null) // Image file input

// Reactive form data
const formData = reactive({
  name: '',
  email: '',
  phone_number: '',
  password: '',
  role: '',

  student: {
    department: '',
    roll_number: '',
    year: '',
    section: '',
  },

  teacher: {
    department: '',
    available_days: '',
    from_time: '',
    to_time: '',
  },
})

// Sync role with formData
watch(role, (newRole) => {
  formData.role = newRole
})

// Submit Form
const submitForm = async () => {
  try {
    const payload = new FormData()

    payload.append('name', formData.name)
    payload.append('email', formData.email)
    payload.append('phone_number', formData.phone_number)
    payload.append('password', formData.password)
    payload.append('role', formData.role)

    if (formData.role === 'student') {
      payload.append('department', formData.student.department)
      payload.append('roll_number', formData.student.roll_number)
      payload.append('year', formData.student.year)
      payload.append('section', formData.student.section)
    } else if (formData.role === 'teacher') {
      payload.append('department', formData.teacher.department)
      payload.append('available_days', formData.teacher.available_days)
      payload.append('from_time', formData.teacher.from_time)
      payload.append('to_time', formData.teacher.to_time)
    }

    if (imageFile.value) {
      payload.append('image', imageFile.value)
    }
    await axios.post('http://127.0.0.1:8000/api/register', payload, {
      headers: {
        'Content-Type': 'multipart/form-data',
      },
    })

    toast.success('Registration successful!')
    router.push('/')
  } catch (error) {
    console.error(error)
    const message = error.response?.data?.message || error.response?.data?.error || 'Registration failed.'
    toast.error(message)
  }
}
</script>


<template>
  <div class="max-w-md mx-auto mt-10 p-6 bg-bg-light rounded shadow-md">
    <h2 class="text-2xl font-bold text-primary mb-6">Sign Up</h2>
    
    <!-- Name -->
    <label class="block mb-2 text-secondary font-semibold" for="name">Name</label>
    <input
      id="name"
      type="text"
      placeholder="Your full name"
      v-model="formData.name"
      class="w-full mb-4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
    />
    
    <!-- Email -->
    <label class="block mb-2 text-secondary font-semibold" for="email">Email</label>
    <input
      id="email"
      type="email"
      placeholder="example@mail.com"
      v-model="formData.email"
      class="w-full mb-4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
    />
    
    <!-- Phone Number -->
    <label class="block mb-2 text-secondary font-semibold" for="phone">Phone Number</label>
    <input
      id="phone"
      type="tel"
      placeholder="+1234567890"
      v-model="formData.phone_number"
      class="w-full mb-4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
    />
    
    <!-- Password -->
    <label class="block mb-2 text-secondary font-semibold" for="password">Password</label>
    <input
      id="password"
      type="password"
      placeholder="********"
      v-model="formData.password"
      class="w-full mb-4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
    />
    
    <!-- Profile Image -->
<!-- <label class="block mb-2 text-secondary font-semibold" for="image">Profile Image</label>
<input
  id="image"
  type="file"
  accept="image/*"
  @change="e => imageFile.value = e.target.files[0]"
  class="w-full mb-6 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
/> -->


    <!-- Role Select -->
    <label class="block mb-2 text-secondary font-semibold" for="role">Role</label>
    <select
      id="role"
      v-model="role"
      class="w-full mb-6 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
    >
      <option value="" disabled>Select role</option>
      <option v-for="r in roles" :key="r" :value="r">{{ r }}</option>
    </select>
    
    <!-- Student Fields -->
    <div v-if="role === 'student'">
      <label class="block mb-2 text-secondary font-semibold" for="department-student">Department</label>
      <select
        id="department-student"
        v-model="formData.student.department"
        class="w-full mb-4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
      >
        <option value="" disabled>Select department</option>
        <option v-for="d in departments" :key="d" :value="d">{{ d }}</option>
      </select>

      <label class="block mb-2 text-secondary font-semibold" for="roll-number">Roll Number</label>
      <input
        id="roll-number"
        type="text"
        placeholder="Roll Number"
        v-model="formData.student.roll_number"
        class="w-full mb-4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
      />

      <label class="block mb-2 text-secondary font-semibold" for="year">Year</label>
      <input
        id="year"
        type="text"
        placeholder="Year"
        v-model="formData.student.year"
        class="w-full mb-4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
      />

      <label class="block mb-2 text-secondary font-semibold" for="section">Section</label>
      <input
        id="section"
        type="text"
        placeholder="Section"
        v-model="formData.student.section"
        class="w-full mb-6 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
      />
    </div>

    <!-- Teacher Fields -->
    <div v-if="role === 'teacher'">
      <label class="block mb-2 text-secondary font-semibold" for="department-teacher">Department</label>
      <select
        id="department-teacher"
        v-model="formData.teacher.department"
        class="w-full mb-4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
      >
        <option value="" disabled>Select department</option>
        <option v-for="d in departments" :key="d" :value="d">{{ d }}</option>
      </select>

      <label class="block mb-2 text-secondary font-semibold" for="available-days">Available Days</label>
      <input
        id="available-days"
        type="text"
        placeholder="E.g. Monday, Wednesday"
        v-model="formData.teacher.available_days"
        class="w-full mb-4 px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
      />

      <div class="flex space-x-4">
        <div class="flex-1">
          <label class="block mb-2 text-secondary font-semibold" for="from-time">From Time</label>
          <input
            id="from-time"
            type="time"
            v-model="formData.teacher.from_time"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
          />
        </div>
        <div class="flex-1">
          <label class="block mb-2 text-secondary font-semibold" for="to-time">To Time</label>
          <input
            id="to-time"
            type="time"
            v-model="formData.teacher.to_time"
            class="w-full px-3 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-primary"
          />
        </div>
      </div>
    </div>

    <!-- Submit Button -->
    <button
      @click.prevent="submitForm"
      class="mt-8 w-full bg-primary text-white py-3 rounded font-semibold hover:bg-blue-700 transition"
    >
      Sign Up
    </button>
  </div>
</template>

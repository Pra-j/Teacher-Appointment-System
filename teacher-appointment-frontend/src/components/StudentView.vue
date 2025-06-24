<template>
  <div class="p-6">
    <h2 class="text-2xl font-bold mb-4 text-primary">Your Appointments</h2>

    <div v-if="appointments.length === 0" class="text-secondary">
      You don't have any upcoming appointments.
    </div>

    <div v-else>
      <table class="min-w-full border border-gray-300 text-sm text-left">
        <thead class="bg-primary text-white">
          <tr>
            <th class="p-3 border">Teacher Name</th>
            <th class="p-3 border">Date</th>
            <th class="p-3 border">Time</th>
            <th class="p-3 border">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="appointment in appointments" :key="appointment.id" class="bg-bg-light even:bg-white">
            <td class="p-3 border">{{ appointment.teacher_name }}</td>
            <td class="p-3 border">{{ appointment.date }}</td>
            <td class="p-3 border">{{ appointment.time }}</td>
            <td class="p-3 border">{{ appointment.status }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Book Appointment Button -->
    <div class="mt-6">
      <button
        @click="bookAppointment"
        class="bg-primary text-white px-5 py-3 rounded hover:bg-blue-700 transition"
      >
        Book Appointment
      </button>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const appointments = ref([])

onMounted(async () => {
  const token = localStorage.getItem('token')

  try {
    const response = await axios.get('http://localhost:8000/api/appointments', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })

    appointments.value = response.data
  } catch (error) {
    console.error('Error fetching appointments:', error)
  }
})

function bookAppointment() {
  router.push({name: 'BookAppointment'})
}
</script>

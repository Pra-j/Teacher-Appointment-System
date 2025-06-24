<template>
  <div class="p-6">
    <h2 class="text-2xl font-bold mb-4 text-primary">Your Appointments</h2>

    <div v-if="appointments.length === 0" class="text-secondary">
      You don't have any appointments.
    </div>

    <div v-else>
      <table class="min-w-full border border-gray-300 text-sm text-left">
        <thead class="bg-primary text-white">
          <tr>
            <th class="p-3 border">Student Name</th>
            <th class="p-3 border">Date</th>
            <th class="p-3 border">Time</th>
            <th class="p-3 border">Status</th>
            <th class="p-3 border">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="appointment in appointments"
            :key="appointment.id"
            class="bg-bg-light even:bg-white"
          >
            <td class="p-3 border">{{ appointment.student_name }}</td>
            <td class="p-3 border">{{ appointment.date }}</td>
            <td class="p-3 border">{{ appointment.time }}</td>
            <td class="p-3 border capitalize">{{ appointment.status }}</td>
            <td class="p-3 border space-x-2">
              <button
                v-if="appointment.status === 'pending'"
                @click="updateStatus(appointment.id, 'approved')"
                class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700"
              >
                Approve
              </button>
              <button
                v-if="appointment.status === 'pending'"
                @click="updateStatus(appointment.id, 'rejected')"
                class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
              >
                Reject
              </button>
              <span v-else class="italic text-gray-600">No actions</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const appointments = ref([])

const token = localStorage.getItem('token')

const fetchAppointments = async () => {
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
}

const updateStatus = async (appointmentId, status) => {
  try {
  await axios.post(
  `http://localhost:8000/api/appointments/${appointmentId}/status`,
  {status},
  {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  }
)

    // Update local list without full reload
    const idx = appointments.value.findIndex(a => a.id === appointmentId)
    if (idx !== -1) {
      appointments.value[idx].status = status
    }
  } catch (error) {
    console.error('Failed to update status:', error)
  }
}

onMounted(fetchAppointments)
</script>

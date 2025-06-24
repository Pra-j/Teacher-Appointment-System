<template>
  <div class="p-6">
    <BackButton/>
    <h2 class="text-2xl font-bold mb-4 text-primary">Available Schedules</h2>

    <table class="min-w-full border border-gray-300 text-sm text-left">
      <thead class="bg-primary text-white">
        <tr>
          <th class="p-3 border">Teacher Name</th>
          <th class="p-3 border">Department</th>
          <th class="p-3 border">Available Days</th>
          <th class="p-3 border">From Time</th>
          <th class="p-3 border">To Time</th>
          <th class="p-3 border">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="schedule in schedules"
          :key="schedule.id"
          class="bg-bg-light even:bg-white"
        >
          <td class="p-3 border">{{ schedule.teacher_name }}</td>
          <td class="p-3 border">{{ schedule.department }}</td>
          <td class="p-3 border">{{ schedule.day }}</td>
          <td class="p-3 border">{{ schedule.from_time }}</td>
          <td class="p-3 border">{{ schedule.to_time }}</td>
          <td class="p-3 border">
            <button
              @click="openBookingModal(schedule)"
              class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700 transition"
            >
              Book
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Booking Modal -->
    <div
      v-if="showModal"
      class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50"
    >
      <div class="bg-white rounded shadow-lg max-w-md w-full p-6 relative">
        <h3 class="text-xl font-bold mb-4 text-primary">Book Appointment</h3>

        <form @submit.prevent="submitBooking">
          <!-- Teacher Name (readonly) -->
          <label class="block mb-1 font-semibold text-secondary" for="teacherName"
            >Teacher Name</label
          >
          <input
            id="teacherName"
            type="text"
            :value="selectedSchedule?.teacher_name"
            readonly
            class="w-full mb-4 px-3 py-2 border border-gray-300 rounded bg-gray-100"
          />

          <!-- Department (readonly) -->
          <label class="block mb-1 font-semibold text-secondary" for="department"
            >Department</label
          >
          <input
            id="department"
            type="text"
            :value="selectedSchedule?.department"
            readonly
            class="w-full mb-4 px-3 py-2 border border-gray-300 rounded bg-gray-100"
          />

          <!-- Date -->
          <label class="block mb-1 font-semibold text-secondary" for="date"
            >Date</label
          >
          <input
            id="date"
            type="date"
            v-model="bookingForm.date"
            required
            class="w-full mb-4 px-3 py-2 border border-gray-300 rounded"
          />

          <!-- Time -->
          <label class="block mb-1 font-semibold text-secondary" for="time"
            >Time</label
          >
          <input
            id="time"
            type="time"
            v-model="bookingForm.time"
            required
            class="w-full mb-4 px-3 py-2 border border-gray-300 rounded"
          />

          <!-- Buttons -->
          <div class="flex justify-between">
            <button
              type="button"
              @click="closeModal"
              class="px-4 py-2 border rounded hover:bg-gray-200 transition"
            >
              Cancel
            </button>
            <button
              type="submit"
              class="bg-primary text-white px-4 py-2 rounded hover:bg-blue-700 transition"
            >
              Book Now
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'
import BackButton from './BackButton.vue'


const schedules = ref([])
const showModal = ref(false)
const selectedSchedule = ref(null)

const toast = useToast()

const bookingForm = ref({
  date: '',
  time: '',
})

onMounted(async () => {
  const token = localStorage.getItem('token')

  try {
    const response = await axios.get('http://localhost:8000/api/schedules', {
      headers: {
        Authorization: `Bearer ${token}`,
      },
    })
    schedules.value = response.data
    console.log(schedules.value);
  } catch (error) {
    console.error('Error fetching schedules:', error)
  }
})

function openBookingModal(schedule) {
  selectedSchedule.value = schedule
  bookingForm.value.date = ''
  bookingForm.value.time = ''
  showModal.value = true
}

function closeModal() {
  showModal.value = false
  selectedSchedule.value = null
  bookingForm.value.date = ''
  bookingForm.value.time = ''
}

async function submitBooking() {
  const token = localStorage.getItem('token')

  if (!bookingForm.value.date || !bookingForm.value.time) {
    alert('Please fill in both date and time')
    return
  }

  try {
    const payload = {
      teachers_id: selectedSchedule.value.teacher_id,
      student_id: JSON.parse(localStorage.getItem('user')).student.id,
      appointment_date: bookingForm.value.date,
      appointment_time: bookingForm.value.time,
      status: 'pending',
    }

    const response = await axios.post(
      'http://localhost:8000/api/appointments',
      payload,
      {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      }
    )

    toast.success('Appointment booked successfully!')
    closeModal()
  } catch (error) {
    toast.error('Failed to book appointment')
  }
}
</script>


<template>
  <div class="p-6 space-y-10">
    <!-- Students Table -->
    <div>
      <h2 class="text-xl font-bold mb-4 text-primary">Students</h2>
      <table class="min-w-full border border-gray-300 text-sm text-left">
        <thead class="bg-primary text-white">
          <tr>
            <th class="p-3 border">ID</th>
            <th class="p-3 border">Name</th>
            <th class="p-3 border">Email</th>
            <th class="p-3 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in students" :key="student.id" class="even:bg-gray-100">
            <td class="p-3 border">{{ student.id }}</td>
            <td class="p-3 border">{{ student.name }}</td>
            <td class="p-3 border">{{ student.email }}</td>
            <td class="p-3 border space-x-2">
              <button @click="showDetails(student, 'student')" class="bg-blue-500 text-white px-3 py-1 rounded">Show Details</button>
              <button @click="removeUser(student.id, 'student')" class="bg-red-600 text-white px-3 py-1 rounded">Remove</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Teachers Table -->
    <div>
      <h2 class="text-xl font-bold mb-4 text-primary">Teachers</h2>
      <table class="min-w-full border border-gray-300 text-sm text-left">
        <thead class="bg-primary text-white">
          <tr>
            <th class="p-3 border">ID</th>
            <th class="p-3 border">Name</th>
            <th class="p-3 border">Department</th>
            <th class="p-3 border">Email</th>
            <th class="p-3 border">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="teacher in teachers" :key="teacher.id" class="even:bg-gray-100">
            <td class="p-3 border">{{ teacher.id }}</td>
            <td class="p-3 border">{{ teacher.name }}</td>
            <td class="p-3 border">{{ teacher.department }}</td>
            <td class="p-3 border">{{ teacher.email }}</td>
            <td class="p-3 border space-x-2">
              <button @click="showDetails(teacher, 'teacher')" class="bg-blue-500 text-white px-3 py-1 rounded">Show Details</button>
              <button @click="removeUser(teacher.id, 'teacher')" class="bg-red-600 text-white px-3 py-1 rounded">Remove</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Details Modal -->
    <div v-if="selectedUser" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white p-6 rounded shadow-lg w-[400px]">
        <h3 class="text-lg font-semibold mb-4">User Details</h3>
<div class="text-sm space-y-2">
  <p><strong>Name:</strong> {{ selectedUser.user.name }}</p>
  <p><strong>Email:</strong> {{ selectedUser.user.email }}</p>

  <div v-if="selectedUser.department">
    <p><strong>Department:</strong> {{ selectedUser.department }}</p>
  </div>

  <div>
    <p class="font-semibold">Appointments:</p>
   <div v-if="!selectedUser.appointments || selectedUser.appointments.length === 0" class="text-gray-600">
    No appointments found.
  </div>

  <table v-else class="min-w-full border border-gray-300 text-sm text-left mt-4">
  <thead class="bg-gray-200">
    <tr>
      <th class="p-2 border">With</th>
      <th class="p-2 border">Role</th>
      <th class="p-2 border">Status</th>
      <th class="p-2 border">Date</th>
    </tr>
  </thead>
  <tbody>
    <tr v-for="a in selectedUser.appointments" :key="a.id" class="even:bg-gray-100">
      <td class="p-2 border">
        {{ a.student ? a.student.user.name : (a.teacher ? a.teacher.user.name : 'N/A') }}
      </td>
      <td class="p-2 border">
        {{ a.student ? 'Student' : (a.teacher ? 'Teacher' : 'Unknown') }}
      </td>
      <td class="p-2 border">{{ a.status }}</td>
      <td class="p-2 border">{{ a.appointment_date }}</td>
    </tr>
  </tbody>
</table>

  </div>
</div>
        <div class="mt-4 text-right">
          <button @click="selectedUser = null" class="bg-gray-600 text-white px-4 py-2 rounded">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import { useToast } from 'vue-toastification'


const students = ref([])
const teachers = ref([])
const selectedUser = ref(null)
const token = localStorage.getItem('token')
const toast = useToast()

// Fetch data
onMounted(async () => {
  try {
    const [studentRes, teacherRes] = await Promise.all([
      axios.get('http://localhost:8000/api/students', {
        headers: { Authorization: `Bearer ${token}` },
      }),
      axios.get('http://localhost:8000/api/teachers', {
        headers: { Authorization: `Bearer ${token}` },
      }),
    ])
    students.value = studentRes.data
    teachers.value = teacherRes.data
  } catch (err) {
    console.error('Error fetching users:', err)
  }
})

// Show details in modal
async function showDetails(user, type) {
  try {
    const res = await axios.get(`http://localhost:8000/api/${type}s/${user.id}`, {
      headers: { Authorization: `Bearer ${token}` },
    })
    selectedUser.value = res.data
  } catch (err) {
    console.error(`Error fetching ${type} details:`, err)
    toast.error('Failed to load details.')
  }
}


// Remove user
async function removeUser(id, type) {
  const confirmed = confirm(`Are you sure you want to remove this ${type}?`)
  if (!confirmed) return

  try {
    await axios.delete(`http://localhost:8000/api/${type}s/${id}`, {
      headers: { Authorization: `Bearer ${token}` },
    })

    if (type === 'student') {
      students.value = students.value.filter(s => s.id !== id)
    } else {
      teachers.value = teachers.value.filter(t => t.id !== id)
    }

    toast.success(`${type} removed successfully`)
  } catch (error) {
    console.error(`Error deleting ${type}:`, error)
    toast.error('Failed to delete.')
  }
}
</script>

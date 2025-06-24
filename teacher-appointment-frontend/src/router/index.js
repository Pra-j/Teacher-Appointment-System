import { createRouter, createWebHistory } from 'vue-router'
import SignupForm from '../components/SignupForm.vue'  // adjust path
import Home from  '../components/Home.vue'  // adjust path
import BookAppointment from '../components/BookAppointment.vue'  // adjust path

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home,
  },
  {
    path: '/signup',
    name: 'Signup',
    component: SignupForm
  },
  {
    path: '/book-appointment',
    name: 'BookAppointment',
    component: BookAppointment
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router

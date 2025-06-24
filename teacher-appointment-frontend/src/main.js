import { createApp } from 'vue'
import App from './App.vue'
import './assets/tailwind.css'
import router from './router'
import Toast, { POSITION } from 'vue-toastification'
import 'vue-toastification/dist/index.css'

const app = createApp(App)
app.use(router)  // important: register the router

app.use(Toast, {
  position: POSITION.TOP_RIGHT,
  timeout: 3000,
})

app.mount('#app')

import { createApp } from 'vue'
import App from './App.vue'
import './main.css'
import AOS from 'aos'
import 'aos/dist/aos.css'

// Inicializar AOS
AOS.init({
  duration: 1000,
  once: true,
})

const app = createApp(App)
app.mount('#app')


import './bootstrap';
import { createApp } from 'vue'
import router from './router.js'

//aqui se importan componentes
import app from './components/app.vue'
import navbar from './components/navbar.vue'
import heroSection from './components/login.vue'

createApp (app).use(router).mount('#app')
Vue.component('login-component', require('./components/Login.vue').default);

//revisar welcome.blade.php en la carpeta views dentro de resources, alli llamamos este archivo
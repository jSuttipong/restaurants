import {createApp} from 'vue'

import App from './Pages/App.vue'

const app = createApp({})
import 'bootstrap/dist/css/bootstrap.css'
import "bootstrap-icons/font/bootstrap-icons.css";
import '../assets/css/app.css'

createApp(App).mount("#app")
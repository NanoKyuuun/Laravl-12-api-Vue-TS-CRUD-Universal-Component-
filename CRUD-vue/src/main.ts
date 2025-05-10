import { createApp } from 'vue'
import './style.css'
import App from './App.vue'
import router from "./router";

const app = createApp(App);

app.use(router); // Gunakan router dalam aplikasi Vue

app.mount("#app");

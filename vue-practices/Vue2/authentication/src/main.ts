import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";
import { initializeApp } from "firebase/app";
import VueCookies from "vue-cookies";
import VueSession from "vue-session";

const firebaseConfig = {
  apiKey: "AIzaSyBxZ3DxLggtSFm3ibkUGPt4DNRn0IL--eQ",
  authDomain: "curso-vue-940b6.firebaseapp.com",
  projectId: "curso-vue-940b6",
  storageBucket: "curso-vue-940b6.firebasestorage.app",
  messagingSenderId: "793189540031",
  appId: "1:793189540031:web:82ad27a2acedf7bb78a60a",
};

initializeApp(firebaseConfig);

const app = createApp(App);

app.use(router).use(VueCookies, { expires: "id" }).use(VueSession).mount("#app");

// $cookies.set('auth', 1000)
// $cookies.get('auth')
// $cookies.remove('auth')
// $cookies.isKey('auth')
// $cookies.keys()

// $session.start()
// $session.set('auth', 1000)
// $session.get('auth')
// $session.id()
// $session.renew()
// $session.destroy()
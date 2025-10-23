import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";
import { initializeApp } from "firebase/app";

const firebaseConfig = {
  apiKey: "AIzaSyBxZ3DxLggtSFm3ibkUGPt4DNRn0IL--eQ",
  authDomain: "curso-vue-940b6.firebaseapp.com",
  projectId: "curso-vue-940b6",
  storageBucket: "curso-vue-940b6.firebasestorage.app",
  messagingSenderId: "793189540031",
  appId: "1:793189540031:web:82ad27a2acedf7bb78a60a",
};

initializeApp(firebaseConfig);
createApp(App).use(router).mount("#app");

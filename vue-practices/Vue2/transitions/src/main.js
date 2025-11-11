import { createApp } from 'vue'
import App from './App.vue'
import { OhVueIcon, addIcons } from "oh-vue-icons";
import { AiConversation } from "oh-vue-icons/icons";

addIcons(AiConversation);

const app = createApp(App)

app.component("v-icon", OhVueIcon);
app.mount('#app')
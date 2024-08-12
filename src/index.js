import { createApp, Vue } from "vue";
import { createPinia } from "pinia";
$ = jQuery;

import App from "./App.vue";

createApp(App).use(createPinia()).mount("#pushwork-dash");
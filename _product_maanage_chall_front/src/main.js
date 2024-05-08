import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";

createApp(App).use(router).mount("#app");
const passportConfig = {
  apiKey: "AIzaSyBJa1SPjo1Wm0ZgYXZnmdmvoqs_hHlmiXU",
 
};
const app = initializeApp(passportConfig);

export { app };

import { createApp } from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import { loadFonts } from './plugins/webfontloader'
import router from './routes/routes'

loadFonts()

//createApp(App) .use(vuetify, router) .mount('#app')

const app = createApp(App);

app.use(vuetify);
app.use(router);
app.mount('#app');

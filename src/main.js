import Vue from 'vue'
import App from './App.vue'
import VueKonva from 'vue-konva'
import router from './router'
import store from './store'
import axios from 'axios'
import VueMeta from 'vue-meta'
import VueSocialSharing from 'vue-social-sharing'

//Set base url of php calls.
axios.defaults.baseURL=process.env.VUE_APP_PHPLINK;

Vue.config.productionTip = false



//VueMeta to add meta tags dynamically.
Vue.use(VueMeta)
//Konva lib to deal with canvas
Vue.use(VueKonva)

//VueSocialSharing lib to add social netwok share buttons
Vue.use(VueSocialSharing);

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

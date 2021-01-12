import Vue from 'vue'
import App from './App.vue'
import VueKonva from 'vue-konva'
import router from './router'
import store from './store'
import axios from 'axios'

axios.defaults.baseURL="http://yannbaizid.fr/yann/lizellba/php/"

Vue.config.productionTip = false
Vue.use(VueKonva)

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')

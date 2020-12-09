import Vue from 'vue'
import App from './App.vue'
import VueKonva from 'vue-konva'
import router from './router'

Vue.config.productionTip = false
Vue.use(VueKonva)

new Vue({
  router,
  render: h => h(App)
}).$mount('#app')

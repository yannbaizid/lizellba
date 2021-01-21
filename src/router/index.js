import Vue from 'vue'
import VueRouter from 'vue-router'
import Index from '../Index/Index'
import Game from '../game/Game'
import TestModal from '../views/TestModal'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Index
  },
  {
    path: '/game',
    name: 'Game',
    component: Game
  },
  
  {
    path: '/test',
    name: 'test',
    component: TestModal
  },
  {
    path: '/gallery/photo/:photoId',
    name: 'ExpoPhoto',
    component: Index,
  },
  {
    path: '/gallery/:page/photo/:photoId',
    name: 'ExpoPhoto',
    component: Index,
  },

  {
    path: '/about',
    name: 'About',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  routes
})

export default router

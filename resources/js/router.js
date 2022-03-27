import Vue  from "vue"
import VueRouter from "vue-router"
import Login from "./views/Login"
import Admin from "./views/Admin"
import Waiting from "./views/Waiting"
import Store from "./store"
import store from "./store"
Vue.use(VueRouter)

const routes = [
  {
    path: '/app/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/app/admin',
    name: 'admin',
    component: Admin,
    meta: { requiresAuth: true }
  },
  {
    path: '/app/waiting',
    name: 'waiting',
    component: Waiting
  },
]

const router = new VueRouter(
  {
    mode: 'history',
    base: process.env.BASE_URL,
    routes
  }
)

router.beforeEach((to, from, next) =>{
  if (to.matched.some(record => record.name === 'login')) {
    Store.dispatch('commitInitLoginCheck')
  }
  if (to.matched.some(record => record.meta.requiresAuth) && !Store.getters['isLogin']) {
    next({
      path: '/app/login',
      query: { redirect: to.fullPath }
    })
  }else if (to.matched.some(record => record.name === 'login') && Store.getters['isLogin']) {
    next({
      path: '/app/admin',
      query: { redirect: to.fullPath }
    })
  }else{
    next();
  }
})

export default router


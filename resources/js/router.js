import Vue  from "vue"
import VueRouter from "vue-router"
import Login from "./views/Login"
import Admin from "./views/Admin"
import Display from "./views/ShopDisplay"
import Waiting from "./views/Waiting"
import Store from "./store"

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
    meta: { requiresAuth: true },
  },
  {
    path: '/app/display',
    name: 'display',
    component: Display,
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

router.beforeEach(async (to, from, next) =>{
  await Store.dispatch('apiCallLoginCheck')
  if (to.matched.some(record => record.meta.requiresAuth) && !Store.getters['isLogin']) {
    next({path: '/app/login'})
  }else if(to.name === 'login' && Store.getters['isLogin']){
    next({path: '/app/admin'})
  }else{
    next();
  }
})

export default router


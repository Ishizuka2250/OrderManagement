import Vue  from "vue"
import VueRouter from "vue-router"
import Login from "./views/Login"
import Admin from "./views/Admin"
import Waiting from "./views/Waiting"
Vue.use(VueRouter)

const router = new VueRouter(
  {
    mode: 'history',
    base: process.env.BASE_URL,
    routes: [
      {
        path: '/app/login',
        name: 'login',
        component: Login
      },
      {
        path: '/app/admin',
        name: 'admin',
        component: Admin
      },
      {
        path: '/app/waiting',
        name: 'waiting',
        component: Waiting
      },
    ]
  }
)

export default router


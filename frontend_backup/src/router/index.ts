import { createRouter, createWebHistory, RouteRecordRaw } from 'vue-router'
import { store } from '@/store'
import LandingView from '../views/LandingView.vue'
import LandingLayout from '@/layouts/LandingLayout.vue'
import AdminLayout from '@/layouts/AdminLayout.vue'
import DashboardView from '@/views/DashboardView.vue'

const routes: Array<RouteRecordRaw> = [
  {
    path: '/',
    component: LandingLayout,
    children: [
      {
        path: '/',
        name: 'landing',
        component: LandingView
      }
    ]
  },
  {
    path: '/admin',
    redirect: '/admin/dashboard',
    component: AdminLayout,
    children: [
      {
        path: '/admin/dashboard',
        name: 'dashboard',
        component: DashboardView
      }
    ]
  }
  // {
  //   path: '/about',
  //   name: 'about',
  //   route level code-splitting
  //   this generates a separate chunk (about.[hash].js) for this route
  //   which is lazy-loaded when the route is visited.
  //   component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue')
  // }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

router.beforeEach((to, from, next) => {
  const publicPages = ['/']
  const authRequired = !publicPages.includes(to.path)
  const loggedIn = store.getters.isUserAuthenticated

  if (authRequired && !loggedIn) {
    store.commit('openLoginModal')
    next('/')
  } else {
    next()
  }
})

export default router

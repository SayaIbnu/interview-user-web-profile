import { createRouter, createWebHistory } from 'vue-router'
import { useAuthStore } from '../store/auth'

// views
import Login from '../views/Login.vue'
import AdminLayout from '../components/layout/AdminLayout.vue'

// admin pages
import Dashboard from '../views/admin/Dashboard.vue'
import Doctors from '../views/admin/doctors/Doctors.vue'
import DoctorForm from '../views/admin/doctors/DoctorForm.vue'
import DoctorDetail from '../views/admin/doctors/DoctorDetail.vue'

const routes = [
  {
    path: '/login',
    component: Login,
    meta: { guestOnly: true }
  },

  {
    path: '/admin',
    component: AdminLayout,
    meta: { requiresAuth: true },
    children: [
      {
        path: 'dashboard',
        component: Dashboard,
        meta: { title: 'Dashboard' }
      },

      
      {
        path: 'doctors',
        meta: { title: 'Data Dokter' },
        children: [
          {
            path: '',
            name: 'DoctorList',
            component: Doctors
          },
          {
            path: 'create',
            name: 'DoctorCreate',
            component: DoctorForm
          },
          {
            path: ':id',
            name: 'DoctorDetail',
            component: DoctorDetail,
            props: true
          },
          {
            path: ':id/edit',
            name: 'DoctorEdit',
            component: DoctorForm,
            props: true
          }
        ]
      }
    ]
  },

  {
    path: '/',
    redirect: '/admin/dashboard'
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})


// 🔥 GUARD (SUDAH BENAR)
router.beforeEach((to) => {
  const auth = useAuthStore()

  if (to.meta.requiresAuth && !auth.isAuthenticated) {
    return '/login'
  }

  if (to.meta.guestOnly && auth.isAuthenticated) {
    return '/admin/dashboard'
  }

  return true
})

export default router
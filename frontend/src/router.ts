import Login from '@/views/Auth/Login.vue'
import Dashboard from '@/views/Dashboard.vue'
import MainLayout from '@/layouts/MainLayout.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'
import Register from './views/Auth/Register.vue'
import ForgotPassword from './views/Auth/ForgotPassword.vue'

import { createRouter, createWebHistory } from 'vue-router'
import { useUser } from './stores/useUser'
import ResetPassword from './views/Auth/ResetPassword.vue'
import Client from './views/Catalogs/Client.vue'
import Unit from './views/Catalogs/Unit.vue'
import Measure from './views/Catalogs/Measure.vue'
import { useSidebar } from './stores/useSidebar'
import Index from './views/Works/Index.vue'
import Create from './views/Works/Create.vue'

const routes = [
  {
    path: '/auth',
    component: AuthLayout,
    children: [
      {
        path: '/ingresar',
        name: 'Login',
        component: Login,
        meta: {
          title: 'Iniciar sesión',
          icon: 'user',
          guest: true
        }
      },
      {
        path: '/registro',
        name: 'Register',
        component: Register,
        meta: {
          title: 'Registro',
          icon: 'user',
          guest: true
        }
      },
      {
        path: '/olvide_mis_credenciales',
        name: 'ForgotPassword',
        component: ForgotPassword,
        meta: {
          title: 'Olvide mi contraseña',
          guest: true
        }
      },
      {
        path: '/actualizacion_de_credenciales',
        name: 'ResetPassword',
        component: ResetPassword,
        meta: {
          title: 'Actualización de credenciales',
          guest: true
        }
      },
    ]
  },
  {
    path: '/',
    component: MainLayout,
    children: [
      {
        path: '/',
        redirect: '/dashboard'
      },

      {
        path: '/dashboard',
        name: 'Home',
        component: Dashboard,
        meta: {
          title: 'Dashboard',
          icon: 'chart-simple',
          auth: true
        }
      },
      {
        path: '/catalogos/clientes',
        name: 'Clientes',
        component: Client,
        meta: {
          title: 'Clientes',
          icon: 'user-group',
          auth: true
        }
      },
      {
        path: '/catalogos/unidades',
        name: 'Unidades de medida',
        component: Unit,
        meta: {
          title: 'Unidades de medida',
          icon: 'ruler-horizontal',
          auth: true
        }
      },
      {
        path: '/catalogos/medidas/:client_id',
        name: 'Medidas',
        component: Measure,
        meta: {
          title: 'Medidas del cliente',
          icon: 'ruler-combined',
          auth: true
        }
      },
      {
        path: '/trabajos',
        name: 'Trabajos',
        component: Index,
        meta: {
          title: 'Trabajos',
          icon: 'list',
          auth: true
        }
      },
      {
        path: '/trabajos/nuevo',
        name: 'NuevoTrabajo',
        component: Create,
        meta: {
          title: 'Nuevo Trabajo',
          icon: 'list',
          auth: true
        }
      },
    ]
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return savedPosition || { left: 0, top: 0 }
  }
})

router.beforeEach((to, from, next) => {
  useSidebar().setTabName(null);
  document.title = `${to.meta.title}` || import.meta.env.APP_NAME;
  const token = useUser().user.token;
  if (to.meta.guest && token) {
    return next('/tablero');
  }
  if (to.meta.auth && !token) {
    return next('/ingresar');
  }
  next();
});


export default router

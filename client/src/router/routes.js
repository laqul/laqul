
import authenticationPages from './authentication'
import dashboardPages from './dashboard'

export default [
  {
    path: '/',
    caseSensitive: true,
    pathToRegexOptions: { strict: true, sensitive: true },
    component: () => import('layouts/Authentication'),
    meta: { requiresAuth: false },
    children: authenticationPages
  },

  {
    path: '/Panel',
    caseSensitive: true,
    pathToRegexOptions: { strict: true, sensitive: true },
    component: () => import('layouts/Dashboard'),
    meta: { requiresAuth: true },
    children: dashboardPages
  },

  { // Always leave this as last one
    name: 'pages.errors.e404',
    path: '*',
    component: () => import('pages/404')
  }
]

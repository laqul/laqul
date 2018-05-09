export default [
  {
    name: 'pages.dashboard.home',
    path: '',
    caseSensitive: true,
    pathToRegexOptions: { strict: true, sensitive: true },
    component: () => import('pages/dashboard/home')
  },
  {
    path: 'User',
    caseSensitive: true,
    pathToRegexOptions: { strict: true, sensitive: true },
    component: () => import('layouts/dashboard/User'),
    children: [
      {
        name: 'pages.dashboard.user_avatar',
        path: 'Avatar',
        alias: '',
        caseSensitive: true,
        pathToRegexOptions: { strict: true, sensitive: true },
        component: () => import('pages/dashboard/user-avatar')
      },
      {
        name: 'pages.dashboard.user_info',
        path: 'Info',
        caseSensitive: true,
        pathToRegexOptions: { strict: true, sensitive: true },
        component: () => import('pages/dashboard/user-info')
      },
      {
        name: 'pages.dashboard.user_password',
        path: 'Password',
        caseSensitive: true,
        pathToRegexOptions: { strict: true, sensitive: true },
        component: () => import('pages/dashboard/user-password')
      }
    ]
  }
]

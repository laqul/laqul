export default [
  {
    name: 'pages.authentication.login',
    path: '',
    caseSensitive: true,
    pathToRegexOptions: { strict: true, sensitive: true },
    component: () => import('pages/authentication/login')
  },
  {
    name: 'pages.authentication.email_verification',
    path: 'EmailVerification',
    caseSensitive: true,
    pathToRegexOptions: { strict: true, sensitive: true },
    component: () => import('pages/authentication/email-verification')
  },
  {
    name: 'pages.authentication.registration',
    path: 'Registration/:code',
    caseSensitive: true,
    pathToRegexOptions: { strict: true, sensitive: true },
    component: () => import('pages/authentication/registration')
  },
  {
    name: 'pages.authentication.forgot_password',
    path: 'ForgotPassword',
    caseSensitive: true,
    pathToRegexOptions: { strict: true, sensitive: true },
    component: () => import('pages/authentication/forgot-password')
  },
  {
    name: 'pages.authentication.reset_password',
    path: 'ResetPassword/:token',
    caseSensitive: true,
    pathToRegexOptions: { strict: true, sensitive: true },
    component: () => import('pages/authentication/reset-password')
  },
  {
    name: 'pages.authentication.social_login',
    path: 'SocialLogin',
    caseSensitive: true,
    pathToRegexOptions: { strict: true, sensitive: true },
    component: () => import('pages/authentication/social-login')
  }
]

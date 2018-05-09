// Este store solo debe incluir parametros que deban ser reiniciados al momento
// que el usuario cierra sesion, toda la informacion que se requiera almacenar durante una sesion
// de usuario debe estar aqui
export default {
  cloudMessaging: {
    message: null,
    notificationPromptShowed: true,
    notificationsBlocked: false
  },
  userSession: {
    accessToken: null
  },
  userInfo: {
    id: 0,
    name: '',
    email: '',
    avatar: '',
    timezone: ''
  },
  userNotifications: []
}

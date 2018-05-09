import store from '../store'
import { i18n } from '../plugins/i18n'
import { Notify } from 'quasar'

export default (error) => {
  switch (error.code) {
    case 'messaging/notifications-blocked':
    case 'messaging/permission-blocked':
      store.commit('session/fcmNotificationPromptShowed', true)
      store.commit('session/fcmNotificationsBlocked', true)
      break
    case 'messaging/token-unsubscribe-failed':
      Notify.create({
        message: i18n.t('errors.firebase.try_again'),
        position: 'center'
      })
      break
    default:
      console.error(error)
      break
  }
}

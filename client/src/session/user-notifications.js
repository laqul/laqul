import { apolloProvider } from '../boot/apollo-init'
import USER_NOTIFICATIONS from '../graphql/querys/userNotifications.gql'
import config from '../config'
import store from '../store'

export const _getUserNotifications = () => {
  return apolloProvider.defaultClient.query({ query: USER_NOTIFICATIONS, variables: { limit: config.firebase.fcm.maxNotifications }, fetchPolicy: 'network-only' })
    .then(response => {
      store.commit('session/setUserNotifications', response.data.userNotifications)
      return Promise.resolve(response)
    })
}

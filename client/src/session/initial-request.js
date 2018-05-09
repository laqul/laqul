import { apolloProvider } from '../boot/apollo-init'
import INITIAL_INFO from '../graphql/querys/initialInfo.gql'
import config from '../config'
import store from '../store'

export const _initialRequest = () => {
  return apolloProvider.defaultClient.query({ query: INITIAL_INFO, variables: { limit: config.firebase.fcm.maxNotifications } })
    .then(response => {
      store.commit('session/setUserInfo', JSON.parse(JSON.stringify(response.data.userInfo[0])))
      store.commit('session/setUserNotifications', response.data.userNotifications)
      return Promise.resolve(response.data)
    })
}

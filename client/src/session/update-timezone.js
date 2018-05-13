import { apolloProvider } from '../boot/apollo-init'
import UPDATE_TIMEZONE from '../graphql/mutations/updateTimezone.gql'
import store from '../store'
import moment from 'moment-timezone'

export const _updateTimezone = (initialInfo) => {
  let timezone = moment.tz.guess()
  if (timezone !== initialInfo.userInfo[0].timezone) {
    return apolloProvider.defaultClient.mutate({
      mutation: UPDATE_TIMEZONE,
      variables: {
        timezone
      }
    }).then(response => {
      store.commit('session/setUserTimezone', response.data.updateUserInfo[0].timezone)
      return Promise.resolve(response.data.updateUserInfo[0].timezone)
    })
  }
  return Promise.resolve(initialInfo.userInfo[0].timezone)
}

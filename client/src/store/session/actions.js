import { _passwordLogin, _socialLogin } from '../../session/login'
import { _getUserNotifications } from '../../session/user-notifications'
import { _initialRequest } from '../../session/initial-request'
import { _updateTimezone } from '../../session/update-timezone'

export const passwordLogin = (state, { username, password }) => {
  return _passwordLogin(username, password)
}

export const socialLogin = (state, { code, platform, timezone }) => {
  return _socialLogin(code, platform, timezone)
}

export const initialRequest = (state) => {
  return _initialRequest()
}

export const updateTimezone = (state, initialInfo) => {
  return _updateTimezone(initialInfo)
}

export const getUserNotifications = (state) => {
  return _getUserNotifications()
}

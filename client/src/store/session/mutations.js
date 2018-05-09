export const setAccessToken = (state, payload) => {
  state.userSession.accessToken = payload
}

export const fcmNotificationPromptShowed = (state, payload) => {
  state.cloudMessaging.notificationPromptShowed = payload
}

export const fcmNotificationsBlocked = (state, payload) => {
  state.cloudMessaging.notificationsBlocked = payload
}

export const fcmMessage = (state, payload) => {
  state.cloudMessaging.message = payload
}

export const setUserNotifications = (state, payload) => {
  state.userNotifications = payload
}

export const setUserInfo = (state, payload) => {
  payload.avatar = payload.avatar + '?v=' + new Date().getTime()
  state.userInfo = payload
}

export const setUserAvatar = (state, payload) => {
  payload = payload + '?v=' + new Date().getTime()
  state.userInfo.avatar = payload
}

export const setUserName = (state, payload) => {
  state.userInfo.name = payload
}

export const setUserTimezone = (state, payload) => {
  state.userInfo.timezone = payload
}

export const clear = (state) => {
  state.cloudMessaging = {
    message: null,
    notificationPromptShowed: true,
    notificationsBlocked: false
  }
  state.userSession = {
    accessToken: null
  }
  state.userInfo = {
    id: 0,
    name: '',
    email: '',
    avatar: '',
    timezone: ''
  }
  state.userNotifications = []
}

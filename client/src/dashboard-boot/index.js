import firebaseCM, { askForPermission } from './firebase-cm'
import initialRequest from './initial-request'
import updateTimezone from './update-timezone'

export const fcmAskForPermission = () => {
  return askForPermission()
}

export default () => {
  return initialRequest()
    .then(initialInfo => updateTimezone(initialInfo))
    .then(timeZone => firebaseCM())
}

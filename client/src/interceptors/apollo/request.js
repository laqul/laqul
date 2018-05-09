import Queue from './tasks/queue'
import xRequestedWithHeader from './tasks/x-requested-with-header'
import { refreshTokenBefore } from '../../session/refresh-tokens'
import authorizationHeader from './tasks/authorization-header'

export const req = (operation) => {
  let config = {
    headers: {}
  }
  return xRequestedWithHeader(config)
    .then(config => Queue())
    .then(success => refreshTokenBefore())
    .then(success => authorizationHeader(config))
}

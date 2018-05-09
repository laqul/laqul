import moment from 'moment-timezone'

export default ({ Vue }) => {
  Vue.prototype.$moment = moment
}

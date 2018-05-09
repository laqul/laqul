import store from '../store'
export default (initialInfo) => {
  return store.dispatch('session/updateTimezone', initialInfo)
}

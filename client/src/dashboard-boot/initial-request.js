import store from '../store'
export default () => {
  return store.dispatch('session/initialRequest')
}

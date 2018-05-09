import setUrl from './tasks/set-url'

export const req = (config) => {
  return setUrl(config)
}

export const reqError = (error) => {
  return Promise.reject(error)
}

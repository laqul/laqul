import _config from '../../../config'

export default (config) => {
  const backendCallRegex = /^\/backend\//i
  config._origin = 'Other'
  if (backendCallRegex.test(config.url)) {
    config._origin = 'Backend'
    config.url = config.url.replace('/backend/', _config.backendUrl + '/?command=')
  }
  return Promise.resolve(config)
}

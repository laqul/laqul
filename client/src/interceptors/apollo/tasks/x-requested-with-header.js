export default (config) => {
  config.headers['X-Requested-With'] = 'XMLHttpRequest'
  return Promise.resolve(config)
}

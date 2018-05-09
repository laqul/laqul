import axios from 'axios'

export default () => {
  return axios.get('/backend/xsrf')
}

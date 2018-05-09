import axios from 'axios'
import { req, reqError } from './request'
import { res, resError } from './response'

const requestInterceptor = () => {
  axios.interceptors.request.use(config => req(config), error => reqError(error))
}

const responseInterceptor = () => {
  axios.interceptors.response.use(response => res(response), error => resError(error))
}

export const axiosInterceptors = () => {
  requestInterceptor()
  responseInterceptor()
  return Promise.resolve(true)
}

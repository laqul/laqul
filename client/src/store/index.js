import Vue from 'vue'
import Vuex from 'vuex'

import app from './app'
import session from './session'

Vue.use(Vuex)

const store = new Vuex.Store({
  modules: {
    app,
    session
  }
})

export default store

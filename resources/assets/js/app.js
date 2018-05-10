import Vue from 'vue'
import Vuetify from 'vuetify'
import Vuex from 'vuex'
import VueRouter from 'vue-router'

import store from './store'
import router from './routes'

require('./bootstrap');

Vue.use(Vuetify)
Vue.use(Vuex)
Vue.use(VueRouter)

const app = new Vue({
  el: '#app',
  router,
  store,
  created () {
    axios.get('/api/user').then(response => {
      store.commit('SET_USER', response.data)
    }).catch(err => {})
  }
});

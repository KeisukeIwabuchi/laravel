import Vue from 'vue'
import Vuetify from 'vuetify'

require('./bootstrap');

Vue.use(Vuetify)

const app = new Vue({
  el: '#app',
  components: {
    'auth-login': require('./components/auth/Login'),
    'auth-register': require('./components/auth/Register'),
    'auth-passwords-email': require('./components/auth/passwords/Email'),
    'auth-passwords-reset': require('./components/auth/passwords/Reset'),
  },
  methods: {
    Redirect (url) {
      window.location.href = url
    }
  }
});

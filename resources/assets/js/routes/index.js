import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

export default new VueRouter({
  mode: 'history',

  routes: [
    {
      path: '/home',
      component: require('./../pages/Home'),
      children: [
        { path: '/', component: require('./../components/Home/Dashboard') },
        { path: 'dashboard', component: require('./../components/Home/Dashboard') },
        { path: 'setting', component: require('./../components/Home/Setting') }
      ]
    }
  ]
})

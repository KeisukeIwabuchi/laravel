const state = {
  id: 0,
  name: '',
  email: ''
}

const mutations = {
  SET_USER (state, payload) {
    state.id = payload.id
    state.name = payload.name
    state.email = payload.email
  }
}

export default {
  state,
  mutations
}

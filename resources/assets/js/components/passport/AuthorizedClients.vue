<template lang="pug">
  div
    div(v-if="tokens.length > 0")
      .card.card-default
        .card-header Authorized Applications
        .card-body
        table.table.table-borderless.mb-0
          thead
            tr
              th Name
              th Scopes
              th
          tbody
            tr(v-for="token in tokens")
              td(style="vertical-align: middle;") {{ token.client.name }}
              td(style="vertical-align: middle;")
                span(v-if="token.scopes.length > 0") {{ token.scopes.join(', ') }}
              td(style="vertical-align: middle;")
                a(class="action-link text-danger" @click="revoke(token)") Revoke
</template>

<script>
export default {
  data() {
    return {
      tokens: []
    }
  },

  ready() {
    this.prepareComponent()
  },

  mounted() {
    this.prepareComponent()
  },

  methods: {
    prepareComponent() {
      this.getTokens()
    },

    getTokens() {
      axios.get('/oauth/tokens')
        .then(response => {
          this.tokens = response.data
        })
    },

    revoke(token) {
      axios.delete('/oauth/tokens/' + token.id)
        .then(response => {
          this.getTokens()
        })
    }
  }
}
</script>

<style lang="stylus" scoped>
  .action-link
    cursor pointer
</style>
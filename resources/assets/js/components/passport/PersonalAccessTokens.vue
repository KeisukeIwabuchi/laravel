<template lang="pug">
  div
    div
      .card.card-default
        .card-header
          div(style="display: flex; justify-content: space-between; align-items: center;")
            span Personal Access Tokens
            a.action-link(tabindex="-1" @click="showCreateTokenForm") Create New Token

        .card-body
          p.mb-0(v-if="tokens.length === 0") You have not created any personal access tokens.
          table.table.table-borderless.mb-0(v-if="tokens.length > 0")
            thead
              tr
                th Name
                th
            tbody
              tr(v-for="token in tokens")
                td(style="vertical-align: middle;") {{ token.name }}
                td(style="vertical-align: middle;")
                  a.action-link.text-danger(@click="revoke(token)") Delete

    <!-- Create Token Modal -->
    .modal.fade(id="modal-create-token" tabindex="-1" role="dialog")
      .modal-dialog
        .modal-content
          .modal-header
            h4.modal-title Create Token
            button.close(type="button" data-dismiss="modal" aria-hidden="true") &times;

          .modal-body
            .alert.alert-danger(v-if="form.errors.length > 0")
              p.mb-0
                strong Whoops!
                | Something went wrong!
              br
              ul
                li(v-for="error in form.errors") {{ error }}

            form(role="form" @submit.prevent="store")
              .form-group.row
                label.col-md-4.col-form-label Name
                .col-md-6
                  input.form-control(
                    id="create-token-name"
                    type="text"
                    name="name"
                    v-model="form.name")

              .form-group.row(v-if="scopes.length > 0")
                label.col-md-4.col-form-label Scopes
                .col-md-6
                  div(v-for="scope in scopes")
                    .checkbox
                      label
                        input(
                          type="checkbox"
                          @click="toggleScope(scope.id)"
                          :checked="scopeIsAssigned(scope.id)")
                        {{ scope.id }}

          .modal-footer
            button.btn.btn-secondary(type="button" data-dismiss="modal") Close
            button.btn.btn-primary(type="button" @click="store") Create

    .modal.fade(id="modal-access-token" tabindex="-1" role="dialog")
      .modal-dialog
        .modal-content
          .modal-header
            h4.modal-title Personal Access Token
            button.close(type="button" data-dismiss="modal" aria-hidden="true") &times;

          .modal-body
            p
              | Here is your new personal access token. 
              | This is the only time it will be shown so don't lose it!
              | You may now use this token to make API requests.
            textarea.form-control(rows="10") {{ accessToken }}

          .modal-footer
            button.btn.btn-secondary(type="button" data-dismiss="modal") Close
</template>

<script>
export default {
  data() {
    return {
      accessToken: null,

      tokens: [],
      scopes: [],

      form: {
        name: '',
        scopes: [],
        errors: []
      }
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
      this.getScopes()

      $('#modal-create-token').on('shown.bs.modal', () => {
        $('#create-token-name').focus()
      })
    },

    getTokens() {
      axios.get('/oauth/personal-access-tokens')
        .then(response => {
          this.tokens = response.data
        })
    },

    getScopes() {
      axios.get('/oauth/scopes')
        .then(response => {
          this.scopes = response.data
        })
    },

    showCreateTokenForm() {
      $('#modal-create-token').modal('show')
    },

    store() {
      this.accessToken = null

      this.form.errors = []

      axios.post('/oauth/personal-access-tokens', this.form)
        .then(response => {
          this.form.name = ''
          this.form.scopes = []
          this.form.errors = []

          this.tokens.push(response.data.token)

          this.showAccessToken(response.data.accessToken)
        })
        .catch(error => {
          if (typeof error.response.data === 'object') {
            this.form.errors = _.flatten(_.toArray(error.response.data.errors))
          } else {
            this.form.errors = ['Something went wrong. Please try again.']
          }
        })
    },

    toggleScope(scope) {
      if (this.scopeIsAssigned(scope)) {
        this.form.scopes = _.reject(this.form.scopes, s => s == scope)
      } else {
        this.form.scopes.push(scope)
      }
    },

    scopeIsAssigned(scope) {
      return _.indexOf(this.form.scopes, scope) >= 0
    },

    showAccessToken(accessToken) {
      $('#modal-create-token').modal('hide')

      this.accessToken = accessToken

      $('#modal-access-token').modal('show')
    },

    revoke(token) {
      axios.delete('/oauth/personal-access-tokens/' + token.id)
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
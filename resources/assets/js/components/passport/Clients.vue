<template lang="pug">
  div
    .card.card-default
      .card-header
        div(style="display: flex; justify-content: space-between; align-items: center;")
          span OAuth Clients
          a.action-link(tabindex="-1" @click="showCreateClientForm") Create New Client

      .card-body
        p.mb-0(v-if="clients.length === 0") You have not created any OAuth clients.
        table.table.table-borderless.mb-0(v-if="clients.length > 0")
          thead
            tr
              th Client ID
              th Name
              th Secret
              th
              th
          tbody
            tr(v-for="client, index in clients" :key="index")
              td(style="vertical-align: middle;") {{ client.id }}
              td(style="vertical-align: middle;") {{ client.name }}
              td(style="vertical-align: middle;")
                code {{ client.secret }}
              td(style="vertical-align: middle;")
                a.action-link(tabindex="-1" @click="edit(client)") Edit
              td(style="vertical-align: middle;")
                a.action-link.text-danger(@click="destroy(client)") Delete

    .modal.fade(id="modal-create-client" tabindex="-1" role="dialog")
      .modal-dialog
        .modal-content
          .modal-header
            h4.modal-title Create Client
            button(type="button" class="close" data-dismiss="modal" aria-hidden="true") &times
          .modal-body
            .alert.alert-danger(v-if="createForm.errors.length > 0")
              p.mb-0
                strong Whoops!
                | Something went wrong!
              br
              ul
                li(v-for="error in createForm.errors") {{ error }}
            form(role="form")
              .form-group.row
                label.col-md-3.col-form-label Name
                .col-md-9
                  input.form-control(
                    id="create-client-name"
                    type="text"
                    @keyup.enter="store"
                    v-model="createForm.name")
                  span.form-text.text-muted
                    | Something your users will recognize and trust.
              .form-group.row
                label.col-md-3.col-form-label Redirect URL
                .col-md-9
                  input.form-control(
                    type="text"
                    name="redirect"
                    @keyup.enter="store"
                    v-model="createForm.redirect")
                  span.form-text.text-muted
                    | Your application's authorization callback URL.

          .modal-footer
            button.btn.btn-secondary(type="button" data-dismiss="modal") Close
            button.btn.btn-primary(type="button" @click="store") Create

    .modal.fade(id="modal-edit-client" tabindex="-1" role="dialog")
      .modal-dialog
        .modal-content
          .modal-header
            h4.modal-title Edit Client
            button.close(type="button" data-dismiss="modal" aria-hidden="true") &times;

          .modal-body
            .alert.alert-danger(v-if="editForm.errors.length > 0")
              p.mb-0
                strong Whoops!
                | Something went wrong!
              br
              ul
                li(v-for="error in editForm.errors") {{ error }}
            form(role="form")
              .form-group.row
                label.col-md-3.col-form-label Name

                .col-md-9
                  input.form-control(
                    id="edit-client-name"
                    type="text"
                    @keyup.enter="update"
                    v-model="editForm.name")
                  span.form-text.text-muted
                    | Something your users will recognize and trust.

              .form-group.row
                label.col-md-3.col-form-label Redirect URL
                .col-md-9
                  input.form-control(
                    type="text"
                    name="redirect"
                    @keyup.enter="update"
                    v-model="editForm.redirect")
                  span.form-text.text-muted
                    | Your application's authorization callback URL.

          .modal-footer
            button.btn.btn-secondary(type="button" data-dismiss="modal") Close
            button.btn.btn-primary(type="button" @click="update") Save Changes
</template>

<script>
export default {
  data() {
    return {
      clients: [],

      createForm: {
        errors: [],
        name: '',
        redirect: ''
      },

      editForm: {
        errors: [],
        name: '',
        redirect: ''
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
      this.getClients();

      $('#modal-create-client').on('shown.bs.modal', () => {
        $('#create-client-name').focus()
      })

      $('#modal-edit-client').on('shown.bs.modal', () => {
        $('#edit-client-name').focus()
      })
    },

    getClients() {
      axios.get('/oauth/clients')
        .then(response => {
          this.clients = response.data;
        })
    },

    showCreateClientForm() {
      $('#modal-create-client').modal('show')
    },

    store() {
      this.persistClient(
        'post', '/oauth/clients',
        this.createForm, '#modal-create-client'
      )
    },

    edit(client) {
      this.editForm.id = client.id
      this.editForm.name = client.name
      this.editForm.redirect = client.redirect

      $('#modal-edit-client').modal('show')
    },

    update() {
      this.persistClient(
        'put', '/oauth/clients/' + this.editForm.id,
        this.editForm, '#modal-edit-client'
      )
    },

    persistClient(method, uri, form, modal) {
      form.errors = []

      axios[method](uri, form)
        .then(response => {
          this.getClients()

          form.name = ''
          form.redirect = ''
          form.errors = []

          $(modal).modal('hide')
        })
        .catch(error => {
          if (typeof error.response.data === 'object') {
            form.errors = _.flatten(_.toArray(error.response.data.errors))
          } else {
            form.errors = ['Something went wrong. Please try again.']
          }
        })
    },

    destroy(client) {
      axios.delete('/oauth/clients/' + client.id)
        .then(response => {
          this.getClients()
        })
    }
  }
}
</script>

<style lang="stylus" scoped>
  .action-link
    cursor pointer
</style>
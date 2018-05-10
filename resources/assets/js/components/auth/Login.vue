<template lang="pug">
  v-content
    v-container
      v-layout(row wrap)
        v-flex(md10 sm12 xs12 offset-md1)
          v-card(color="gray lighten-4")
            v-card-title(primary-title)
              v-container
                v-layout.headline(row)
                  v-flex.text-xs-center ログイン
                v-layout.gray--text(row)
                  v-flex.text-xs-center Login
            v-card-text
              v-container
                v-layout(row)
                  v-flex(xs4)
                    v-subheader E-mail
                  v-flex(xs8)
                    v-text-field(
                      name="email"
                      label="Enter your E-mail Address"
                      required
                      autofocus
                      v-model="email"
                    )
                v-layout(row)
                  v-flex(xs4)
                    v-subheader Passowrd
                  v-flex(xs8)
                    v-text-field(
                      :append-icon="password_visible ? 'visibility_off' : 'visibility'"
                      :append-icon-cb="() => (password_visible = !password_visible)"
                      name="password"
                      label="Enter your password"
                      required
                      :type="password_visible ? 'text' : 'password'"
                      v-model="password"
                      @keyup.enter="Login"
                    )
                v-layout(
                  v-if="error.length > 0"
                  row
                )
                  v-flex.text-xs-right.red--text.text--darken-1(xs12) {{ error }}
            v-card-actions
              v-container
                v-layout(row)
                  v-btn(
                    name="Login"
                    color="primary"
                    raised
                    @click="Login()"
                  ) Login
                  v-spacer
                  a(href="/password/reset") Forgot Your Password?
</template>

<script>
export default {
  data: () => ({
    email: '',
    password: '',
    password_visible: false,
    error: ''
  }),
  methods: {
    Login () {
      this.error = ''
      axios.post('/login', {
        email: this.email,
        password: this.password,
        remember: true
      })
      .then(data => {
        window.location.href = '/home'
      })
      .catch(() => {
        this.error = 'メールアドレスとパスワードが一致しません。'
      })
    }
  }
}
</script>

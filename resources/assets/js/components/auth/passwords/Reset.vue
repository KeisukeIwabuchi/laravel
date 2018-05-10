<template lang="pug">
  v-content
    v-container
      v-layout(row wrap)
        v-flex(md10 sm12 xs12 offset-md1)
          v-card(color="gray lighten-4")
            v-card-title(primary-title)
              v-container
                v-layout.headline(row)
                  v-flex.text-xs-center パスワードリセット
                v-layout.gray--text(row)
                  v-flex.text-xs-center Reset Password
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
                      :value="old"
                      v-model="email"
                    )
                v-layout(row)
                  v-flex(xs4)
                    v-subheader Passowrd
                  v-flex(xs8)
                    v-text-field(
                      name="password"
                      label="Enter your password"
                      required
                      type="password"
                      v-model="password"
                    )
                v-layout(row)
                  v-flex(xs4)
                    v-subheader Confirm Passowrd
                  v-flex(xs8)
                    v-text-field(
                      name="password_confirmation"
                      label="Enter your password again"
                      required
                      type="password"
                      v-model="password_confirmation"
                      @keyup.enter="Register"
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
                    color="primary"
                    raised
                    @click="Reset()"
                  ) Reset Password
</template>

<script>
export default {
  props: {
    old: {
      type: String,
      required: true
    },
    token: {
      type: String,
      required: true
    }
  },
  data: () => ({
    email: '',
    password: '',
    password_confirmation: '',
    error: ''
  }),
  methods: {
    Reset () {
      this.error = ''
      if (this.email.length === 0) {
        this.error = 'メールアドレスが未入力です。'
        return
      }
      if (this.password !== this.password_confirmation) {
        this.error = 'パスワードが一致しません。'
        return
      } else {
        if (this.password.length < 6) {
          this.error = 'パスワードは6文字以上にしてください。'
          return
        }
      }

      axios.post('/password/reset', {
        token: this.token,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation
      })
      .then(data => {
        window.location.href = '/home'
      })
      .catch(err => {
        this.error = 'パスワード変更に失敗しました。'
      })
    }
  }
}
</script>

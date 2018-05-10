<template lang="pug">
  v-content
    v-container
      v-layout(row wrap)
        v-flex(md10 sm12 xs12 offset-md1)
          v-card(color="gray lighten-4")
            v-card-title(primary-title)
              v-container
                v-layout.headline(row)
                  v-flex.text-xs-center 会員登録
                v-layout.gray--text(row)
                  v-flex.text-xs-center Register
            v-card-text
              v-container
                v-layout(row)
                  v-flex(xs4)
                    v-subheader Name
                  v-flex(xs8)
                    v-text-field(
                      name="name"
                      label="Enter your name"
                      required
                      autofocus
                      v-model="name"
                    )
                v-layout(row)
                  v-flex(xs4)
                    v-subheader E-mail
                  v-flex(xs8)
                    v-text-field(
                      name="email"
                      label="Enter your E-mail Address"
                      required
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
                    @click="Register()"
                  ) Register
</template>

<script>
export default {
  data: () => ({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    error: ''
  }),
  methods: {
    Register () {
      this.error = ''
      if (this.name.length === 0) {
        this.error = '名前が未入力です。'
        return
      }
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

      axios.post('/register', {
        name: this.name,
        email: this.email,
        password: this.password,
        password_confirmation: this.password_confirmation
      })
      .then(() => {
        console.log('success')
        window.location.href = '/home'
      })
      .catch(() => {
        this.error = '入力内容が不正です。'
      })
    }
  }
}
</script>


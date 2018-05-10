<template lang="pug">
  v-content
    v-container
      v-layout(row wrap)
        v-flex(
          v-if="status.message.length > 0"
          md10 sm12 xs12 offset-md1
        )
          v-alert(
            :type="status.type"
            :value="true"
          ) {{ status.message }}
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
                    v-subheader E-mail Address
                  v-flex(xs8)
                    v-text-field(
                      name="email"
                      label="Enter your E-mail Address"
                      required
                      autofocus
                      v-model="email"
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
                  ) Send Password Reset Link
</template>

<script>
export default {
  data: () => ({
    email: '',
    error: '',
    status: {
      message: '',
      type: 'info'
    }
  }),
  methods: {
    Reset () {
      this.error = ''
      if (this.email.length === 0) {
        this.error = 'メールアドレスが未入力です。'
        return
      }

      axios.post('/password/email', {
        email: this.email
      })
      .then(data => {
        console.log(data)
        this.status.message = 'メールを送信しました。'
        this.status.type = 'info'
      })
      .catch(err => {
        console.log(err)
        this.status.message = 'メール送信に失敗しました。'
        this.status.type = 'error'
      })
    }
  }
}
</script>

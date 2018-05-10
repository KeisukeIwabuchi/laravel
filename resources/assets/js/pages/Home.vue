<template lang="pug">
  v-app(light)
    v-navigation-drawer(
      app
      v-bind:miniVariant="drawer"
      permanent
      width="200"
    )
      v-list(dense)
        v-list-tile(@click="() => { this.drawer = !this.drawer }")
          v-list-tile-action
            v-icon(v-if="drawer") menu
            v-icon(v-else) arrow_back
          v-list-tile-content(v-if="drawer")
            v-list-tile-title Open
          v-list-tile-content(v-else)
            v-list-tile-title 閉じる
        v-list-tile(@click="() => { this.$router.push('/home/dashboard') }")
          v-list-tile-action
            v-icon dashboard
          v-list-tile-content
            v-list-tile-title ダッシュボード
        v-list-tile(@click="() => { this.$router.push('/home/setting') }")
          v-list-tile-action
            v-icon settings
          v-list-tile-content
            v-list-tile-title 設定
        v-list-tile(@click="Logout()")
          v-list-tile-action
            v-icon exit_to_app
          v-list-tile-content
            v-list-tile-title ログアウト
    v-content
      v-container(
        fluid
        fill-height
        pa-0
      )
        router-view
</template>

<script>
export default {
  name: 'home',
  data: () => ({
    drawer: true
  }),
  methods: {
    Logout () {
      axios.post('/logout')
      .then(() => {
        window.location.href = '/'
      })
    }
  }
}
</script>

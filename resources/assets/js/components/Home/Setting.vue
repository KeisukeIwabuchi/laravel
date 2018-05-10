<template lang="pug">
  v-layout(
    row
    wrap
    ma-5
  )
    v-flex(xs12)
      h1 Setting
      router-link(to="/") 戻る
      button(@click="reset") reset
</template>

<script>
export default {
  mounted () {
    let token = document.head.querySelector('meta[name="csrf-token"]')
    console.log(token.content)
  },
  methods: {
    reset () {
      let token = document.head.querySelector('meta[name="csrf-token"]')
      window.location.href = '/password/reset/' + token.content
    }
  }
}
</script>

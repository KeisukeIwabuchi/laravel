<template lang="pug">
  v-content.welcome
    v-container
      v-layout(row wrap)
        v-flex(md10 sm12 xs12 offset-md1)
          .welcome-title.my-5.text-xs-center Laravel
          .links
            a(href="https://laravel.com/docs") Documentation
            a(href="https://laracasts.com") Laracasts
            a(href="https://laravel-news.com") News
            a(href="https://forge.laravel.com") Forge
            a(href="https://github.com/laravel/laravel") GitHub
</template>

<script>
export default {

}
</script>

<style lang="stylus" scoped>
  .welcome
    background-color #fff
    color #636b6f
    font-family 'Raleway', sans-serif
    font-weight 100
    height 100vh
    margin 0

  .full-height
    height 100vh

  .flex-center
    align-items center
    display flex
    justify-content center

  .position-ref
    position relative

  .top-right
    position absolute
    right 10px
    top 18px

  .content
    text-align center

  .welcome-title
    font-size 84px

  .links > a
    color #636b6f
    padding 0 25px
    font-size 12px
    font-weight 600
    letter-spacing .1rem
    text-decoration none
    text-transform uppercase

  .m-b-md
    margin-bottom 30px
</style>

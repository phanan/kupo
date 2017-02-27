<template>
  <form method="get" action="/check" class="form form-check" autocomplete="off"
    @submit.prevent="check"
  >
    <input type="url" name="url" placeholder="Input your URL here, kupo!" v-model="url"
      required autofocus
    >
    <input type="submit" value="Check">
  </form>
</template>

<script>
import checker from '../services/checker'

export default {
  name: 'checkForm',

  data () {
    return {
      url: window.location.hash.substr(1)
    }
  },

  created () {
    if (this.url) {
      this.check()
    }
  },

  methods: {
    check () {
      window.location.hash = encodeURI(this.url)
      checker.check(this.url)
    }
  }
}
</script>

<style lang="scss">
.form-check {
  position: relative;
  padding-right: 99px;

  [type=url] {
    width: 100%;
    border-radius: 24px 0 0 24px;
  }

  [type=submit] {
    position: absolute;
    top: 0;
    right: 0;
    border-radius: 0 24px 24px 0;
    width: 100px;
  }
}
</style>

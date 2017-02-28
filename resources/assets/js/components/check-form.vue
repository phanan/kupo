<template>
  <form method="get" action="/check" class="form form-check" autocomplete="off"
    @submit.prevent="submitCheck"
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
      url: window.defaultUrl
    }
  },

  created () {
    if (this.url) {
      this.check()
    }

    window.onpopstate = event => {
      this.url = event.state ? event.state.url : ''
      this.check()
    }
  },

  methods: {
    submitCheck () {
      window.history.pushState({ url: this.url }, this.url, `?url=${encodeURI(this.url)}`)
      this.check()
    },

    check () {
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

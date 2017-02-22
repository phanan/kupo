<template>
  <div id="main" :class="{ 'checking': checking, 'touch': touch }">
    <site-header/>
    <results/>
    <site-footer/>
    <loader v-show="checking"/>
  </div>
</template>

<script>
import siteHeader from './components/site-header.vue'
import siteFooter from './components/site-footer.vue'
import results from './components/results.vue'
import loader from './components/loader.vue'
import event from './services/event'

export default {
  name: 'app',
  components: { siteHeader, siteFooter, results, loader },

  data () {
    return {
      checking: false,
      touch: 'ontouchstart' in window
    }
  },

  created () {
    event.on({
      'check-start': () => {
        this.checking = true
      },
      'check-done': () => {
        this.checking = false
      }
    })
  }
}
</script>

<style lang="scss">
#main {
  position: relative;
  padding: 16px;
  width: 520px;
  margin: 0 auto 64px;

  &.checking::after {
    position: fixed;
    content: ' ';
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    z-index: 1;
    pointer-events: none;
    background: transparentize(#fff, .5);
  }

  @media only screen and (max-width: 480px) {
    width: 100%;
    padding: 8px;
  }
}
</style>

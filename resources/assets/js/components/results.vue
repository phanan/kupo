<template>
  <div class="results">
    <transition-group
      name="staggered-fade"
      tag="ul"
      @before-enter="beforeEnter"
      @enter="enter"
      @leave="leave"
    >
      <li is="resultItem" v-for="(item, index) in items"
        :item="item"
        :data-index="index"
        :key="index"
      />
    </transition-group>
    <div class="error" v-if="errored">
      <p>Uh oh, something went wrong. Try again, may be?</p>
    </div>
  </div>
</template>

<script>
/*global Velocity*/
import resultItem from './result-item.vue'
import event from '../services/event'

export default {
  name: 'results',
  components: { resultItem },

  data () {
    return {
      items: [],
      errored: false
    }
  },

  methods: {
    beforeEnter (el) {
      el.style.opacity = 0
    },
    enter (el, done) {
      const delay = el.dataset.index * 50
      setTimeout(() => {
        Velocity(
          el,
          { opacity: 1 },
          { complete: done }
        )
      }, delay)
    },
    leave (el, done) {
      const delay = el.dataset.index * 50
      setTimeout(() => {
        Velocity(
          el,
          { opacity: 0 },
          { complete: done }
        )
      }, delay)
    }
  },

  created () {
    event.on({
      'check-start': () => {
        this.items = []
      },
      'check-done': data => {
        if (data) {
          this.items = data
          this.errored = false
        } else {
          this.errored = true
        }
      }
    })
  }
}
</script>

<style lang="scss" scoped>
@import '../../sass/_variables';

.results ul {
  list-style: none;
  padding: 0;
}

.error {
  text-align: center;

  p {
    color: $brand-warning;
    background: #fff;
    display: inline-block;
    padding: 8px 16px;
    border-radius: 16px;
  }
}


</style>

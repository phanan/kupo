<template>
  <div class="results">
    <ul v-if="items.length">
      <li is="resultItem" v-for="item in items" :item="item"/>
    </ul>
    <div class="error" v-if="errored">
      <p>Uh oh, something went wrong. Try again, may be?</p>
    </div>
  </div>
</template>

<script>
import resultItem from './result-item.vue'
import event from '../services/event'

export default {
  name: 'results',
  components: { resultItem },

  data () {
    return {
      items: [],
      errored: false,
    }
  },

  created () {
    event.on({
      'check-done': data => {
        if (data) {
          this.items = data
          this.errored = false
        } else {
          this.items = []
          this.errored = true
        }
      }
    })
  }
}
</script>

<style lang="sass" scoped>
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

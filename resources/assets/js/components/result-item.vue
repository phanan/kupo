<template>
  <li :class="['item', statusClass, levelClass]">
    <span class="label">{{ level }}</span>
    <div v-html="item.message"></div>
  </li>
</template>

<script>
import slugify from 'slugify'

export default {
  name: 'result-item',
  props: ['item'],

  computed: {
    level () {
      return this.item.passed ? 'Passed' : this.item.level
    },

    statusClass () {
      return this.item.passed ? 'passed' : 'failed'
    },

    levelClass () {
      return slugify(this.item.level).toLowerCase()
    }
  }
}
</script>

<style lang="sass">
  @import '../../sass/_variables';

  li.item {
    margin-bottom: 6px;
    border: 1px solid $brand-success;
    position: relative;
    background: #fff;
    padding: 24px 24px 0;
    border-radius: 5px;
    overflow: hidden;
    word-wrap: break-word;
    line-height: 1.8;
    border-bottom-width: 2px;

    .label {
      color: #fff;
      background: $brand-success;
      font-family: 'Roboto Mono', Monaco, courier, monospace;
      text-transform: uppercase;
      font-size: .8em;
      padding: 2px 4px;
      border-radius: 0 0 5px;
      position: absolute;
      left: 0;
      top: 0;
    }

    &.failed {
      &.notice {
        border-color: $brand-info;
        .label {
          background: $brand-info;
        }
      }

      &.warning {
        border-color: $brand-warning;
        .label {
          background: $brand-warning;
        }
      }

      &.error {
        border-color: $brand-danger;
        .label {
          background: $brand-danger;
        }
      }

      &.critical {
        border-color: $brand-critical;
        .label {
          background: $brand-critical;
        }
      }
    }
  }
</style>

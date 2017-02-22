<template>
  <transition>
    <li :class="['item', statusClass, levelClass]">
      <i class="help-icon" @click="showingHelp=!showingHelp">?</i>
      <div class="msg" v-html="item.message"/>
      <div class="help" v-show="showingHelp" v-html="item.help"/>
    </li>
  </transition>
</template>

<script>
import slugify from 'slugify'

export default {
  name: 'result-item',
  props: ['item'],

  data () {
    return {
      showingHelp: false
    }
  },

  computed: {
    statusClass () {
      return this.item.passed ? 'passed' : 'failed'
    },

    levelClass () {
      return slugify(this.item.level).toLowerCase()
    }
  }
}
</script>

<style lang="scss">
@import '../../sass/_variables';

li.item {
  margin-bottom: 6px;
  border: 1px solid $brand-success;
  position: relative;
  background: #fff;
  border-radius: 5px;
  overflow: hidden;
  word-wrap: break-word;
  border-bottom-width: 2px;

  .msg {
    padding: 24px 24px 0;
  }

  .help {
    padding: 8px 24px;
    font-size: .9em;
    border-top: 1px solid #fff;
    box-shadow: inset 0 1px 5px rgba(black, 0.1);
  }

  .help-icon {
    $wh: 18px;
    cursor: pointer;
    position: absolute;
    right: 5px;
    top: 5px;
    border: 1px solid #e4e4e4;
    color: #bfbfbf;
    font-style: normal;
    width: $wh;
    height: $wh;
    display: block;
    text-align: center;
    line-height: $wh - 2px;
    border-radius: 50%;
    font-size: .75em;
    opacity: 0;

    .touch & {
      opacity: 1;
    }

    &:hover {
      background-color: $brand-warning;
      border-color: $brand-warning;
      color: #fff;
    }
  }

  &:hover .help-icon {
    opacity: 1;
  }

  &::before {
    color: #fff;
    background: $brand-success;
    font-family: 'Roboto Mono', Monaco, courier, monospace;
    text-transform: uppercase;
    font-size: .7em;
    padding: 2px 4px;
    border-radius: 0 0 5px;
    position: absolute;
    left: 0;
    top: 0;
    content: 'Passed';
  }

  &.failed {
    &::before {
      content: 'Failed';
    }

    &.notice {
      border-color: $brand-info;
      &::before {
        background: $brand-info;
      }
    }

    &.warning {
      border-color: $brand-warning;
      &::before {
        background: $brand-warning;
      }
    }

    &.error {
      border-color: $brand-danger;
      &::before {
        background: $brand-danger;
      }
    }

    &.critical {
      border-color: $brand-critical;
      &::before {
        background: $brand-critical;
      }
    }
  }
}
</style>

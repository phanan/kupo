<template>
  <header class="site-header">
    <h1>
      <span class="name">{{ appMeta.name }}</span>
      <span class="description">{{ appMeta.description }}</span>
    </h1>
    <check-form/>
  </header>
</template>

<script>
import checkForm from './check-form.vue'

export default {
  name: 'header',
  components: { checkForm },
  data () {
    return {
      appMeta: window.appMeta
    }
  }
}
</script>

<style lang="scss">
@import '../../sass/_variables';

.site-header {
  h1 {
    margin-bottom: 32px;

    .name {
      color: $brand-primary;
    }

    .description {
      &::before {
        content: "· ";
      }

      @media only screen and (max-width: 667px) {
        display: none;
      }
    }
  }

  text-align: center;
  margin-bottom: 24px;
}
</style>

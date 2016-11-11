<template>
  <header class="site-header">
    <h1><span class="name">kupo</span> Site Launch Checklist</h1>
    <check-form/>
  </header>
</template>

<script>
import checkForm from './check-form.vue'

export default {
  name: 'header',
  components: { checkForm }
}
</script>

<style lang="sass">
@import '../../sass/_variables';

.site-header {
  h1 {
    margin-bottom: 32px;

    .name {
      color: $brand-primary;
    }
  }

  text-align: center;
  margin-bottom: 24px;
}
</style>

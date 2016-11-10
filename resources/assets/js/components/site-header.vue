<template>
  <header class="site-header">
    <h1>Deployment Checklist</h1>

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
.site-header {
  text-align: center;
  margin-bottom: 24px;
}
</style>

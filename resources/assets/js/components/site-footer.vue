<template>
  <footer class="site-footer">
    <p>An open source project by <a href="http://phanan.net">Phan An</a></p>
    <p>Built on <a href="http://laravel.com">Laravel</a> and <a href="http://vuejs.org">Vue</a> ·
    <a href="https://github.com/phanan/kupo">GitHub</a></p>
    <p><a href="http://finalfantasy.wikia.com/wiki/Moogle_(race)">Moogle</a>
      animation beautifully done by <a href="http://staticwind.deviantart.com/">staticwind</a></p>
    <p><em>Moogles</em> and <em>kupo</em> might be trademarks and/or copyrights of Square Enix, I don’t know.</p>
    <img src="img/moogles.gif" alt="Mooogles" width="96">
  </footer>
</template>

<script>
export default {}
</script>

<style lang="scss" scoped>
@import '../../sass/_variables';

footer {
  margin-top: 64px;
  text-align: center;
  font-size: .9em;
  line-height: 1.2;
  opacity: .8;

  p {
    margin: 4px 0;
  }
}
</style>

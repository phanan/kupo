<template>
  <div class="loader"></div>
</template>

<script>
export default {}
</script>

<style>
@-webkit-keyframes loading {
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}
@-moz-keyframes loading {
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}
@keyframes loading {
    0%{background-position:0% 50%}
    50%{background-position:100% 50%}
    100%{background-position:0% 50%}
}

.loader {
  height: 3px;
  position: fixed;
  width: 100%;
  top: 0;
  left: 0;
  z-index: 9999;

  background: linear-gradient(270deg, #893cbd, #3cbd69, #ddb925, #c11c1c);
  background-size: 800% 800%;

  -webkit-animation: loading 2s ease infinite;
  -moz-animation: loading 2s ease infinite;
  animation: loading 2s ease infinite;
}
</style>
